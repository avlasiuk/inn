<?php


namespace App\Services;


use App\TaxPayerStatus;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;

class FnsService
{
    public function taxPayerStatus($inn)
    {
        $client = new Client();

        $status = Cache::get($inn);

        // Return previous result if query date difference is less than 1 day
        if ($status && Carbon::now()->diffInDays($status['updated_at']) < 1) {
            return $status['response'];
        }

        // Request status
        $response = $client->request('POST', 'https://statusnpd.nalog.ru/api/v1/tracker/taxpayer_status', [
            'json' => [
                'inn' => $inn,
                'requestDate' => Carbon::now()->toDateString(),
            ]
        ]);

        $result = json_decode($response->getBody()->getContents());


        // Update query in the database
        Cache::forever($inn, [
            'response' => $result->message,
            'updated_at' => Carbon::now(),
        ]);

        return Cache::get($inn)['response'];
    }
}
