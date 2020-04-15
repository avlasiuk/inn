<?php

namespace App\Http\Controllers;

use App\Services\FnsService;
use App\TaxPayerStatus;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;

class TaxPayerController extends Controller
{
    public function checkStatus(Request $request, FnsService $fnsService)
    {
        try {
            $status = $fnsService->taxPayerStatus($request->inn);

            return redirect()
                ->route('home')
                ->with('result', $status);
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
