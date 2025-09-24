<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use App\Models\Income;
use App\Models\Sale;
use App\Models\Order;
use App\Models\Stock;

class ApiController extends Controller
{
    //
    public function getStocks()
    {
        $today_date = Carbon::now()->toDateString();

        $api_key = env('API_KEY');
        $page = 1;
        $limit = 500;
        $url = 'http://109.73.206.144:6969/api/stocks';
        $request_params = [
            'dateFrom' => $today_date,
            'page' => $page,
            'key' => $api_key,
            'limit' => $limit,
        ];

        $waiting_sec = 0.5;

        do {
            $response = Http::get($url, $request_params);

            dump($response);
            if (!$response->failed()) {
                $body_json = $response->body();
                $body_array = json_decode($body_json, 1);
                $data = $body_array['data'];
                $remaining_tries = $response->header('x-ratelimit-remaining');
                dump($remaining_tries);
                \Log::info('API Pagination Data', [
                    'remaining_tries' => $remaining_tries . PHP_EOL,
                    'request_params' => print_r($request_params, 1) . PHP_EOL,
                    'current_page' => $body_array['meta']['current_page'] . PHP_EOL ?? null,
                    'last_page' => $body_array['meta']['last_page'] . PHP_EOL ?? null
                ]);


                if ($remaining_tries < 59) {
                    $waiting_sec = 0.5;
                } elseif ($remaining_tries < 30) {
                    $waiting_sec = 1;
                } elseif ($remaining_tries < 15) {
                    $waiting_sec = 5;
                } elseif ($remaining_tries < 10) {
                    $waiting_sec = 10;
                } elseif ($remaining_tries < 5) {
                    $waiting_sec = 20;
                }
//            dump($data);
                $data_chunks = array_chunk($data, 100, true);
                foreach ($data_chunks as $chunk) {
//                    dump($chunk);
                    DB::transaction(function () use ($chunk) {
                        $current_datetime = Carbon::now()->toDateTimeString();
                        $prepared_data = array_map(function ($item) use ($current_datetime) {
                            $timestamps['created_at'] = $current_datetime;
                            $timestamps['updated_at'] = $current_datetime;
                            return array_merge($item, $timestamps);
                        }, $chunk);
                        Stock::insert($prepared_data);
                    }, 2);

                    DB::commit();
                }
                $request_params['page']++;
                usleep(1000000 * $waiting_sec);
//                sleep(1);
            } else {
                \Log::warning('Во время запросов к API произошла ошибка' . PHP_EOL .
                    'Код ответа: ' . $response->status() . PHP_EOL .
                    'Параметры запроса:' . PHP_EOL . print_r($request_params, 1)) . PHP_EOL .
                'Ответ на запрос:' . PHP_EOL . print_r($response->body(), 1);
            }
        } while (!empty($body_array) && $body_array['meta']['current_page'] < $body_array['meta']['last_page']);
    }

    public function getIncomes()
    {
        $date_to = Carbon::now()->toDateString();
        $date_from = Carbon::createFromTimestamp(1)->toDateString();

        $api_key = env('API_KEY');
        $page = 1;
        $limit = 500;
        $url = 'http://109.73.206.144:6969/api/incomes';
        $request_params = [
            'dateFrom' => $date_from,
            'dateTo' => $date_to,
            'page' => $page,
            'key' => $api_key,
            'limit' => $limit,
        ];

        $waiting_sec = 0.5;

        do {
            $response = Http::get($url, $request_params);

//            dump($response);
            if (!$response->failed()) {
                $body_json = $response->body();
                $body_array = json_decode($body_json, 1);
                $data = $body_array['data'];
//            dump($data);

                $remaining_tries = $response->header('X-Ratelimit-Remaining');
                dump($remaining_tries);
                if ($remaining_tries <= 59 && $remaining_tries > 30) {
                    $waiting_sec = 0.5;
                } elseif ($remaining_tries <= 30 && $remaining_tries > 15) {
                    $waiting_sec = 1;
                } elseif ($remaining_tries <= 15 && $remaining_tries > 10) {
                    $waiting_sec = 5;
                } elseif ($remaining_tries <= 10 && $remaining_tries > 5) {
                    $waiting_sec = 10;
                } elseif ($remaining_tries <= 5) {
                    $waiting_sec = 20;
                }
                $data_chunks = array_chunk($data, 100, true);
                foreach ($data_chunks as $chunk) {
                    dump($chunk);
                    DB::transaction(function () use ($chunk) {
                        $current_datetime = Carbon::now()->toDateTimeString();
                        $prepared_data = array_map(function ($item) use ($current_datetime) {
                            $timestamps['created_at'] = $current_datetime;
                            $timestamps['updated_at'] = $current_datetime;
                            return array_merge($item, $timestamps);
                        }, $chunk);
                        Income::insert($prepared_data);
                    }, 2);

                    DB::commit();
                }
                $request_params['page']++;
                usleep(1000000 * $waiting_sec);
//                sleep(1);
            } else {
                \Log::warning('Во время запросов к API произошла ошибка' . PHP_EOL . 'Код ответа: ' . $response->status() . PHP_EOL . 'Параметры запроса:' . PHP_EOL . print_r($request_params, 1));
            }
        } while ($body_array['meta']['current_page'] < $body_array['meta']['last_page']);
    }

    public function getSales()
    {
        $date_to = Carbon::now()->toDateString();
        $date_from = Carbon::createFromTimestamp(1)->toDateString();

        $api_key = env('API_KEY');
        $page = 1;
        $last_page = 100;
        $limit = 300;
        $url = 'http://109.73.206.144:6969/api/sales';
        $request_params = [
            'dateFrom' => $date_from,
            'dateTo' => $date_to,
            'page' => $page,
            'key' => $api_key,
            'limit' => $limit,
        ];

        $waiting_sec = 0.5;

        while ($request_params['page'] < $last_page) ;
        {
            \Log::info('Страница:' . $request_params['page'] , ' | Максимальная страница: ' . $last_page);
            $response = Http::get($url, $request_params);

//            dump($response);
            if (!$response->failed()) {
                $body_json = $response->body();
                $body_array = json_decode($body_json, 1);
                $data = $body_array['data'];
//            dump($data);

                $remaining_tries = $response->header('x-ratelimit-remaining');
                dump($remaining_tries);
                if ($remaining_tries <= 59 && $remaining_tries > 30) {
                    $waiting_sec = 0.5;
                } elseif ($remaining_tries <= 30 && $remaining_tries > 15) {
                    $waiting_sec = 1;
                } elseif ($remaining_tries <= 15 && $remaining_tries > 10) {
                    $waiting_sec = 5;
                } elseif ($remaining_tries <= 10 && $remaining_tries > 5) {
                    $waiting_sec = 10;
                } elseif ($remaining_tries <= 5) {
                    $waiting_sec = 20;
                }
                $data_chunks = array_chunk($data, 100, true);
                foreach ($data_chunks as $chunk) {
                    dump($chunk);
                    DB::transaction(function () use ($chunk) {
                        $current_datetime = Carbon::now()->toDateTimeString();
                        $prepared_data = array_map(function ($item) use ($current_datetime) {
                            $timestamps['created_at'] = $current_datetime;
                            $timestamps['updated_at'] = $current_datetime;
                            return array_merge($item, $timestamps);
                        }, $chunk);
                        Sale::insert($prepared_data);
                        unset($prepared_data);
                    }, 2);

                    DB::commit();
                }

                \Log::info('API Pagination Data', [
                    'remaining_tries' => $remaining_tries . PHP_EOL,
                    'request_params' => print_r($request_params, 1) . PHP_EOL,
                    'current_page' => $body_array['meta']['current_page'] . PHP_EOL ?? null,
                    'last_page' => $body_array['meta']['last_page'] . PHP_EOL ?? null
                ]);

                $request_params['page']++;
                usleep(1000000 * $waiting_sec);
                $last_page = $body_array['meta']['last_page'];
                unset($data, $body_array, $body_json);

                gc_collect_cycles();
//                sleep(1);
            } else {
                \Log::warning('Во время запросов к API произошла ошибка' . PHP_EOL . 'Код ответа: ' . $response->status() . PHP_EOL . 'Параметры запроса:' . PHP_EOL . print_r($request_params, 1));
            }

        }
    }

    public function getOrders()
    {
        $date_to = Carbon::now()->toDateString();
        $date_from = Carbon::createFromTimestamp(1)->toDateString();

        $api_key = env('API_KEY');
        $page = 1;
        $limit = 500;
        $url = 'http://109.73.206.144:6969/api/orders';
        $request_params = [
            'dateFrom' => $date_from,
            'dateTo' => $date_to,
            'page' => $page,
            'key' => $api_key,
            'limit' => $limit,
        ];

        $waiting_sec = 0.5;

        do {
            $response = Http::get($url, $request_params);

//            dump($response);
            if (!$response->failed()) {
                $body_json = $response->body();
                $body_array = json_decode($body_json, 1);
                $data = $body_array['data'];
//            dump($data);

                $remaining_tries = $response->header('X-Ratelimit-Remaining');
                dump($remaining_tries);
                if ($remaining_tries <= 59 && $remaining_tries > 30) {
                    $waiting_sec = 0.5;
                } elseif ($remaining_tries <= 30 && $remaining_tries > 15) {
                    $waiting_sec = 1;
                } elseif ($remaining_tries <= 15 && $remaining_tries > 10) {
                    $waiting_sec = 5;
                } elseif ($remaining_tries <= 10 && $remaining_tries > 5) {
                    $waiting_sec = 10;
                } elseif ($remaining_tries <= 5) {
                    $waiting_sec = 20;
                }
                $data_chunks = array_chunk($data, 100, true);
                foreach ($data_chunks as $chunk) {
                    dump($chunk);
                    DB::transaction(function () use ($chunk) {
                        $current_datetime = Carbon::now()->toDateTimeString();
                        $prepared_data = array_map(function ($item) use ($current_datetime) {
                            $timestamps['created_at'] = $current_datetime;
                            $timestamps['updated_at'] = $current_datetime;
                            return array_merge($item, $timestamps);
                        }, $chunk);
                        Order::insert($prepared_data);
                    }, 2);

                    DB::commit();
                }
                $request_params['page']++;
                usleep(1000000 * $waiting_sec);
//                sleep(1);
            } else {
                \Log::warning('Во время запросов к API произошла ошибка' . PHP_EOL . 'Код ответа: ' . $response->status() . PHP_EOL . 'Параметры запроса:' . PHP_EOL . print_r($request_params, 1));
            }
        } while ($body_array['meta']['current_page'] < $body_array['meta']['last_page']);
    }

}
