<?php

namespace App\Services;

use App\Models\ZohoSale;
use Illuminate\Support\Facades\Http;

class ZohoService
{
    public function syncDeals()
    {
        $token = Http::asForm()->post(
            'https://accounts.zoho.com/oauth/v2/token',
            [
                'refresh_token' => env('ZOHO_REFRESH_TOKEN'),
                'client_id' => env('ZOHO_CLIENT_ID'),
                'client_secret' => env('ZOHO_CLIENT_SECRET'),
                'grant_type' => 'refresh_token',
            ]
        )->json();

        $response = Http::withToken($token['access_token'])
            ->get('https://www.zohoapis.com/crm/v7/Deals', [
                'fields' => 'id,Deal_Name,Amount,Stage,Closing_Date,Created_Time,Modified_Time'
            ])
            ->json();

        foreach ($response['data'] ?? [] as $deal) {

            ZohoSale::updateOrCreate(
                [
                    'zoho_id' => $deal['id'],
                ],
                [
                    'deal_name' => $deal['Deal_Name'] ?? null,
                    'amount' => $deal['Amount'] ?? 0,
                    'stage' => $deal['Stage'] ?? null,
                    'closing_date' => $deal['Closing_Date'] ?? null,
                    'zoho_created_at' => $deal['Created_Time'] ?? null,
                    'zoho_updated_at' => $deal['Modified_Time'] ?? null,
                    'payload' => $deal,
                ]
            );
        }

        return [
            'message' => 'Sync success',
            'total' => count($response['data'] ?? []),
        ];
    }
}
