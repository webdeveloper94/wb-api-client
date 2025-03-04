<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;

class WbApiService
{
    private string $baseUrl = 'http://89.108.115.241:6969/api';
    private string $apiKey;
    private int $maxRetries = 3;
    private int $timeout = 30;

    public function __construct()
    {
        $this->apiKey = config('services.wb.key', 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie');
    }

    public function getSales(string $dateFrom, string $dateTo, int $page = 1, int $limit = 500)
    {
        return $this->makeRequest('sales', compact('dateFrom', 'dateTo', 'page', 'limit'));
    }

    public function getOrders(string $dateFrom, string $dateTo, int $page = 1, int $limit = 500)
    {
        return $this->makeRequest('orders', compact('dateFrom', 'dateTo', 'page', 'limit'));
    }

    public function getStocks(string $dateFrom, int $page = 1, int $limit = 500)
    {
        return $this->makeRequest('stocks', compact('dateFrom', 'page', 'limit'));
    }

    public function getIncomes(string $dateFrom, string $dateTo, int $page = 1, int $limit = 500)
    {
        return $this->makeRequest('incomes', compact('dateFrom', 'dateTo', 'page', 'limit'));
    }

    private function makeRequest(string $endpoint, array $params = [])
    {
        $params['key'] = $this->apiKey;
        $attempt = 1;
        
        while ($attempt <= $this->maxRetries) {
            try {
                $response = Http::timeout($this->timeout)
                    ->retry($this->maxRetries, 1000)
                    ->get("{$this->baseUrl}/{$endpoint}", $params);
                
                if ($response->successful()) {
                    $data = $response->json();
                    
                    // Debug response
                    Log::debug("API Response for {$endpoint}", [
                        'params' => $params,
                        'data' => $data
                    ]);
                    
                    // Transform data
                    if (isset($data['data']) && is_array($data['data'])) {
                        $data['data'] = array_map(function ($item) {
                            // Ensure boolean fields are properly set
                            if (isset($item['is_supply'])) {
                                $item['is_supply'] = filter_var($item['is_supply'], FILTER_VALIDATE_BOOLEAN);
                            }
                            if (isset($item['is_realization'])) {
                                $item['is_realization'] = filter_var($item['is_realization'], FILTER_VALIDATE_BOOLEAN);
                            }
                            if (isset($item['is_cancel'])) {
                                $item['is_cancel'] = filter_var($item['is_cancel'], FILTER_VALIDATE_BOOLEAN);
                            }
                            
                            return $item;
                        }, $data['data']);
                    }
                    
                    return $data;
                }
                
                Log::error("API request failed", [
                    'endpoint' => $endpoint,
                    'params' => $params,
                    'response' => $response->body()
                ]);
                
                throw new \Exception("API request failed: " . $response->body());
            } catch (ConnectionException $e) {
                Log::warning("API connection failed, attempt {$attempt}", [
                    'endpoint' => $endpoint,
                    'error' => $e->getMessage()
                ]);
                
                if ($attempt === $this->maxRetries) {
                    throw $e;
                }
                sleep(2); // Wait 2 seconds before retrying
                $attempt++;
            }
        }
    }
}
