<?php

namespace App\Http\Controllers;

use App\Query;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;

class InnController extends Controller
{
    public function check(Request $request)
    {
        $client = new Client();

        try {
            $query = Query::where('inn', $request->inn)->first();

            // Return previous result if query date difference is less than 1 day
            if ($query && Carbon::now()->diffInDays($query->updated_at) < 1) {
                return redirect()->route('home')->with('result', $query->result);
            }

            // Request inn
            $response = $client->request('POST', 'https://statusnpd.nalog.ru/api/v1/tracker/taxpayer_status', [
                'json' => [
                    'inn' => $request->inn,
                    'requestDate' => '2019-01-11',
                ]
            ]);

            $result = json_decode($response->getBody()->getContents());

            // Update query in the database
            if ($query) {
                $query->result = $result->message;
                $query->updated_at = Carbon::now();
            } else {
                $query = new Query();
                $query->inn = $request->inn;
                $query->result = $result->message;
            }
            $query->save();

            return redirect()
                ->route('home')
                ->with('result', $result->message);

        } catch (ClientException $e) {
            $error = json_decode(
                $e->getResponse()
                    ->getBody()
                    ->getContents()
            );

            return redirect()->route('home')->with('error', $error);
        }
    }
}
