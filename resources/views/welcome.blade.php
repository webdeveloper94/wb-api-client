<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WB API Data</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="text-center mb-5">WB API Data</h1>
        
        <!-- Summary Cards -->
        <div class="row mb-5">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Продажи</h5>
                        <p class="card-text">Всего: {{ $totalSales }}</p>
                        <p class="card-text">Сумма: {{ number_format($totalSalesAmount, 2) }} ₽</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Заказы</h5>
                        <p class="card-text">Всего: {{ $totalOrders }}</p>
                        <p class="card-text">Сумма: {{ number_format($totalOrdersAmount, 2) }} ₽</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Остатки</h5>
                        <p class="card-text">Всего: {{ $totalStocks }}</p>
                        <p class="card-text">Количество: {{ number_format($totalStocksQuantity) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">Доходы</h5>
                        <p class="card-text">Всего: {{ $totalIncomes }}</p>
                        <p class="card-text">Сумма: {{ number_format($totalIncomesAmount, 2) }} ₽</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Latest Data Tables -->
        <div class="row">
            <!-- Sales Table -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Последние продажи</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Артикул</th>
                                        <th>Цена</th>
                                        <th>Дата</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales as $sale)
                                    <tr>
                                        <td>{{ $sale->sale_id }}</td>
                                        <td>{{ $sale->supplier_article }}</td>
                                        <td>{{ number_format($sale->total_price, 2) }} ₽</td>
                                        <td>{{ $sale->date }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Orders Table -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Последние заказы</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Артикул</th>
                                        <th>Цена</th>
                                        <th>Дата</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->odid }}</td>
                                        <td>{{ $order->supplier_article }}</td>
                                        <td>{{ number_format($order->total_price, 2) }} ₽</td>
                                        <td>{{ $order->date }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stocks Table -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Последние остатки</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Артикул</th>
                                        <th>Склад</th>
                                        <th>Количество</th>
                                        <th>Цена</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stocks as $stock)
                                    <tr>
                                        <td>{{ $stock->supplier_article }}</td>
                                        <td>{{ $stock->warehouse_name }}</td>
                                        <td>{{ $stock->quantity }}</td>
                                        <td>{{ number_format($stock->price, 2) }} ₽</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Incomes Table -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Последние доходы</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Артикул</th>
                                        <th>Сумма</th>
                                        <th>Дата</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($incomes as $income)
                                    <tr>
                                        <td>{{ $income->income_id }}</td>
                                        <td>{{ $income->supplier_article }}</td>
                                        <td>{{ number_format($income->total_price, 2) }} ₽</td>
                                        <td>{{ $income->date }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
