<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use App\Models\Sale;
use App\Models\Order;
use App\Models\Income;
use App\Models\Stock;

class ApiCallsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $url;
    protected $model_name;
    protected $request_param;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url, $model_name, $request_param)
    {
        //
        $this->url = $url;
        $this->model_name = $model_name;
        $this->request_param = $request_param;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        \Log::info('Страница:' . $this->request_param['page']);
        $response = Http::get($this->url, $this->request_param);
        if (!$response->failed()) {
            $body_array = json_decode($response->body(), 1);
            $data = $body_array['data'];

            $remaining_tries = $response->header('x-ratelimit-remaining');

            $this->insertData($data);

            \Log::info('Данные с запроса к API:', [
                'remaining_tries' => $remaining_tries,
                'request_params' => print_r($this->request_param, 1),
                'current_page' => $body_array['meta']['current_page'] ?? null,
                'last_page' => $body_array['meta']['last_page'] ?? null
            ]);

            $last_page = $body_array['meta']['last_page'];
            unset($data, $body_array);

            if ($this->request_param['page'] < $last_page) {
                $this->request_param['page']++;
                ApiCallsJob::dispatch($this->url, $this->model_name, $this->request_param)
                    ->delay(now()->addSeconds($this->calculateWaitTime($response->header('x-ratelimit-remaining'))));
            }
        } else {
            \Log::warning('Во время запросов к API произошла ошибка' . PHP_EOL . 'Код ответа: ' . $response->status() . PHP_EOL . 'Параметры запроса:' . PHP_EOL . print_r($this->request_param, 1));

        }
    }

    private function calculateWaitTime($remaining_tries)
    {
        return match (true) {
            $remaining_tries <= 5 => 20,
            $remaining_tries <= 10 => 10,
            $remaining_tries <= 15 => 5,
            $remaining_tries <= 30 => 1,
            default => 0.5
        };
    }

    private function insertData($data)
    {
        $data_chunks = array_chunk($data, 100, true);
        foreach ($data_chunks as $chunk) {

            try {
                DB::transaction(function () use ($chunk) {
                    $current_datetime = Carbon::now()->toDateTimeString();
                    $prepared_data = array_map(function ($item) use ($current_datetime) {
                        return array_merge($item, [
                            'created_at' => $current_datetime,
                            'updated_at' => $current_datetime,
                        ]);
                    }, $chunk);

                    return $this->model_name::insert($prepared_data);
                }, 5);
            } catch (\Exception $e) {
                \Log::error("Проблема с вставкой данных в БД: " . $e->getMessage());
            }
        }

    }
}
