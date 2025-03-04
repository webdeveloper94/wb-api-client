<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Income;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'sales' => Sale::latest()->take(10)->get(),
            'orders' => Order::latest()->take(10)->get(),
            'stocks' => Stock::latest()->take(10)->get(),
            'incomes' => Income::latest()->take(10)->get(),
            
            'totalSales' => Sale::count(),
            'totalOrders' => Order::count(),
            'totalStocks' => Stock::count(),
            'totalIncomes' => Income::count(),
            
            'totalSalesAmount' => Sale::sum('total_price'),
            'totalOrdersAmount' => Order::sum('total_price'),
            'totalStocksQuantity' => Stock::sum('quantity'),
            'totalIncomesAmount' => Income::sum('total_price'),
        ];
        
        return view('welcome', $data);
    }
}
