<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use App\Jobs\ApiCallsJob;

use App\Models\Income;
use App\Models\Sale;
use App\Models\Order;
use App\Models\Stock;

class ApiController extends Controller
{
    //
    public function getStocks()
    {
        $api_key = env('API_KEY');
        $url = 'http://109.73.206.144:6969/api/stocks';
        $request_params = [
            'dateFrom' => Carbon::now()->toDateString(),
            'page' => 1,
            'key' => $api_key,
            'limit' => 500,
        ];
        ApiCallsJob::dispatch($url, Stock::class, $request_params);
    }

    public function getIncomes()
    {
        $api_key = env('API_KEY');
        $url = 'http://109.73.206.144:6969/api/incomes';
        $request_params = [
            'dateFrom' => Carbon::createFromTimestamp(1)->toDateString(),
            'dateTo' => Carbon::now()->toDateString(),
            'page' => 1,
            'key' => $api_key,
            'limit' => 500,
        ];
        ApiCallsJob::dispatch($url, Income::class, $request_params);
    }

    public function getSales()
    {
        $api_key = env('API_KEY');

        $url = 'http://109.73.206.144:6969/api/sales';
        $request_params = [
            'dateFrom' => Carbon::createFromTimestamp(1)->toDateString(),
            'dateTo' => Carbon::now()->toDateString(),
            'page' => 1,
            'key' => $api_key,
            'limit' => 500
        ];
        ApiCallsJob::dispatch($url, Sale::class, $request_params);
    }

    public function getOrders()
    {
        $api_key = env('API_KEY');
        $url = 'http://109.73.206.144:6969/api/orders';
        $request_params = [
            'dateFrom' => Carbon::createFromTimestamp(1)->toDateString(),
            'dateTo' => Carbon::now()->toDateString(),
            'page' => 1,
            'key' => $api_key,
            'limit' => 500,
        ];
        ApiCallsJob::dispatch($url, Order::class, $request_params);
    }

}
