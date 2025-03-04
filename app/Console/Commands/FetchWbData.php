<?php

namespace App\Console\Commands;

use App\Models\Income;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Stock;
use App\Services\WbApiService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class FetchWbData extends Command
{
    protected $signature = 'wb:fetch-data {--days=7}';
    protected $description = 'Fetch data from WB API and store in database';

    private WbApiService $apiService;

    public function __construct(WbApiService $apiService)
    {
        parent::__construct();
        $this->apiService = $apiService;
    }

    public function handle()
    {
        try {
            $days = $this->option('days');
            $dateFrom = Carbon::now()->subDays($days)->format('Y-m-d');
            $dateTo = Carbon::now()->format('Y-m-d');

            $this->fetchSales($dateFrom, $dateTo);
            $this->fetchOrders($dateFrom, $dateTo);
            $this->fetchStocks(Carbon::now()->format('Y-m-d')); // Faqat bugungi sana uchun
            $this->fetchIncomes($dateFrom, $dateTo);

            $this->info('Data fetched successfully!');
        } catch (\Exception $e) {
            Log::error('Error fetching data: ' . $e->getMessage());
            $this->error('Error fetching data: ' . $e->getMessage());
        }
    }

    private function fetchSales($dateFrom, $dateTo)
    {
        $this->info("Fetching sales data from {$dateFrom} to {$dateTo}");
        $page = 1;

        do {
            $data = $this->apiService->getSales($dateFrom, $dateTo, $page);
            
            foreach ($data['data'] ?? [] as $item) {
                try {
                    $item = $this->formatData($item);
                    
                    // Ensure required fields are set
                    $item['is_storno'] = (int)($item['is_storno'] ?? 0);
                    $item['is_supply'] = $item['is_supply'] ?? false;
                    $item['is_realization'] = $item['is_realization'] ?? false;
                    
                    Sale::updateOrCreate(
                        ['sale_id' => $item['sale_id']],
                        Arr::except($item, ['sale_id'])
                    );
                } catch (\Exception $e) {
                    Log::error('Error saving sale: ' . $e->getMessage(), ['data' => $item]);
                }
            }

            $page++;
        } while (!empty($data['data']));
    }

    private function fetchOrders($dateFrom, $dateTo)
    {
        $this->info("Fetching orders data from {$dateFrom} to {$dateTo}");
        $page = 1;

        do {
            $data = $this->apiService->getOrders($dateFrom, $dateTo, $page);
            
            foreach ($data['data'] ?? [] as $item) {
                try {
                    $item = $this->formatData($item);
                    
                    // Ensure required fields are set
                    $item['is_cancel'] = $item['is_cancel'] ?? false;
                    
                    Order::updateOrCreate(
                        ['odid' => $item['odid']],
                        Arr::except($item, ['odid'])
                    );
                } catch (\Exception $e) {
                    Log::error('Error saving order: ' . $e->getMessage(), ['data' => $item]);
                }
            }

            $page++;
        } while (!empty($data['data']));
    }

    private function fetchStocks($dateFrom)
    {
        $this->info("Fetching stocks data for {$dateFrom}");
        $page = 1;

        do {
            $data = $this->apiService->getStocks($dateFrom, $page);
            
            foreach ($data['data'] ?? [] as $item) {
                try {
                    $item = $this->formatData($item);
                    
                    // Ensure required fields are set
                    $item['quantity'] = (int)($item['quantity'] ?? 0);
                    $item['quantity_full'] = (int)($item['quantity_full'] ?? 0);
                    $item['in_way_to_client'] = (int)($item['in_way_to_client'] ?? 0);
                    $item['in_way_from_client'] = (int)($item['in_way_from_client'] ?? 0);
                    $item['is_supply'] = $item['is_supply'] ?? false;
                    $item['is_realization'] = $item['is_realization'] ?? false;
                    
                    Stock::updateOrCreate(
                        [
                            'barcode' => $item['barcode'],
                            'warehouse_name' => $item['warehouse_name']
                        ],
                        Arr::except($item, ['barcode', 'warehouse_name'])
                    );
                } catch (\Exception $e) {
                    Log::error('Error saving stock: ' . $e->getMessage(), ['data' => $item]);
                }
            }

            $page++;
        } while (!empty($data['data']));
    }

    private function fetchIncomes($dateFrom, $dateTo)
    {
        $this->info("Fetching incomes data from {$dateFrom} to {$dateTo}");
        $page = 1;

        do {
            $data = $this->apiService->getIncomes($dateFrom, $dateTo, $page);
            
            foreach ($data['data'] ?? [] as $item) {
                try {
                    $item = $this->formatData($item);
                    
                    Income::updateOrCreate(
                        ['income_id' => $item['income_id']],
                        Arr::except($item, ['income_id'])
                    );
                } catch (\Exception $e) {
                    Log::error('Error saving income: ' . $e->getMessage(), ['data' => $item]);
                }
            }

            $page++;
        } while (!empty($data['data']));
    }

    private function formatData($item)
    {
        return array_map(function ($value) {
            if ($value === '?' || $value === '') {
                return null;
            }
            
            // Convert boolean strings to actual booleans
            if ($value === 'true' || $value === '1') {
                return true;
            }
            if ($value === 'false' || $value === '0') {
                return false;
            }
            
            return $value;
        }, $item);
    }
}
