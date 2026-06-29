<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashAdvanceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ZohoSaleController;
use App\Models\ZohoSale;
use App\Services\ZohoService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('/profile', [AuthController::class, 'getProfile'])->name('profile.show');
Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth');

Route::resource('positions', PositionController::class)->middleware('auth');
Route::resource('employees', EmployeeController::class)->middleware('auth');
Route::resource('attendances', AttendanceController::class)->middleware('auth');

Route::post('payrolls/generate', [PayrollController::class, 'generateBulk'])->name('payrolls.generate')->middleware('auth');
Route::post('payrolls/download-batch', [PayrollController::class, 'downloadBatch'])->name('payrolls.downloadBatch')->middleware('auth');
Route::get('payrolls/{id}/download', [PayrollController::class, 'download'])->name('payrolls.download')->middleware('auth');

Route::resource('payrolls', PayrollController::class)->middleware('auth');

Route::resource('zoho-sales', ZohoSaleController::class)->middleware('auth');
Route::resource('cash-advances', CashAdvanceController::class)->middleware('auth');


Route::get('/zoho/deals', function () {

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
           'fields' => 'id,Deal_Name,Amount,Stage,Closing_Date,Created_Time'
       ]);

   return $response->json();
});

// Route::get('/zoho/deals', function () {

//    // Ambil access token baru
//    $token = Http::asForm()->post(
//        'https://accounts.zoho.com/oauth/v2/token',
//        [
//            'refresh_token' => env('ZOHO_REFRESH_TOKEN'),
//            'client_id' => env('ZOHO_CLIENT_ID'),
//            'client_secret' => env('ZOHO_CLIENT_SECRET'),
//            'grant_type' => 'refresh_token',
//        ]
//    )->json();

//    // Ambil data Deals dari Zoho
//    $response = Http::withToken($token['access_token'])
//        ->get('https://www.zohoapis.com/crm/v7/Deals', [
//            'fields' => 'id,Deal_Name,Amount,Stage,Closing_Date,Created_Time,Modified_Time'
//        ])
//        ->json();

//    foreach ($response['data'] ?? [] as $deal) {

//        ZohoSale::updateOrCreate(
//            [
//                'zoho_id' => $deal['id'],
//            ],
//            [
//                'deal_name' => $deal['Deal_Name'] ?? null,
//                'amount' => $deal['Amount'] ?? 0,
//                'stage' => $deal['Stage'] ?? null,
//                'closing_date' => $deal['Closing_Date'] ?? null,
//                'zoho_created_at' => $deal['Created_Time'] ?? null,
//                'zoho_updated_at' => $deal['Modified_Time'] ?? null,
//                'payload' => $deal,
//            ]
//        );
//    }

//    return response()->json([
//        'message' => 'Zoho deals synchronized successfully',
//        'total' => count($response['data'] ?? []),
//    ]);
// });

Route::get('/zoho/deals-fields', function () {

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
       ->get('https://www.zohoapis.com/crm/v7/settings/fields', [
           'module' => 'Deals'
       ]);

   return $response->json();
});

// Route::get('/zoho/deals', function (ZohoService $zoho) {
//     return response()->json(
//         $zoho->syncDeals()
//     );
// });

Route::get('/zoho/callback', function (\Illuminate\Http\Request $request) {

    $response = Http::asForm()->post(
        'https://accounts.zoho.com/oauth/v2/token',
        [
            'grant_type' => 'authorization_code',
            'client_id' => env('ZOHO_CLIENT_ID'),
            'client_secret' => env('ZOHO_CLIENT_SECRET'),
            'redirect_uri' => env('ZOHO_REDIRECT_URI'),
            'code' => $request->code,
        ]
    );

    return $response->json();
});

Route::get('/zoho/authorize', function () {
    $query = http_build_query([
        'response_type' => 'code',
        'client_id'     => env('ZOHO_CLIENT_ID'),
        'redirect_uri'  => env('ZOHO_REDIRECT_URI'),
        'scope'         => 'ZohoCRM.modules.ALL,ZohoCRM.settings.ALL',
        'access_type'   => 'offline',
    ]);

    return redirect('https://accounts.zoho.com/oauth/v2/auth?' . $query);
});

//Route::get('/zoho/deals', function () {
//
//    $token = Http::asForm()->post(
//        'https://accounts.zoho.com/oauth/v2/token',
//        [
//            'refresh_token' => env('ZOHO_REFRESH_TOKEN'),
//            'client_id' => env('ZOHO_CLIENT_ID'),
//            'client_secret' => env('ZOHO_CLIENT_SECRET'),
//            'grant_type' => 'refresh_token',
//        ]
//    )->json();
//
//    $response = Http::withToken($token['access_token'])
//        ->get('https://www.zohoapis.com/crm/v7/Deals', [
//            'fields' => 'id,Deal_Name,Amount,Stage,Closing_Date,Created_Time'
//        ]);
//
//    return $response->json();
//});

//Route::get('/zoho/deals', function () {
//
//    // Ambil access token baru
//    $token = Http::asForm()->post(
//        'https://accounts.zoho.com/oauth/v2/token',
//        [
//            'refresh_token' => env('ZOHO_REFRESH_TOKEN'),
//            'client_id' => env('ZOHO_CLIENT_ID'),
//            'client_secret' => env('ZOHO_CLIENT_SECRET'),
//            'grant_type' => 'refresh_token',
//        ]
//    )->json();
//
//    // Ambil data Deals dari Zoho
//    $response = Http::withToken($token['access_token'])
//        ->get('https://www.zohoapis.com/crm/v7/Deals', [
//            'fields' => 'id,Deal_Name,Amount,Stage,Closing_Date,Created_Time,Modified_Time'
//        ])
//        ->json();
//
//    foreach ($response['data'] ?? [] as $deal) {
//
//        ZohoSale::updateOrCreate(
//            [
//                'zoho_id' => $deal['id'],
//            ],
//            [
//                'deal_name' => $deal['Deal_Name'] ?? null,
//                'amount' => $deal['Amount'] ?? 0,
//                'stage' => $deal['Stage'] ?? null,
//                'closing_date' => $deal['Closing_Date'] ?? null,
//                'zoho_created_at' => $deal['Created_Time'] ?? null,
//                'zoho_updated_at' => $deal['Modified_Time'] ?? null,
//                'payload' => $deal,
//            ]
//        );
//    }
//
//    return response()->json([
//        'message' => 'Zoho deals synchronized successfully',
//        'total' => count($response['data'] ?? []),
//    ]);
//});
//
//Route::get('/zoho/deals-fields', function () {
//
//    $token = Http::asForm()->post(
//        'https://accounts.zoho.com/oauth/v2/token',
//        [
//            'refresh_token' => env('ZOHO_REFRESH_TOKEN'),
//            'client_id' => env('ZOHO_CLIENT_ID'),
//            'client_secret' => env('ZOHO_CLIENT_SECRET'),
//            'grant_type' => 'refresh_token',
//        ]
//    )->json();
//
//    $response = Http::withToken($token['access_token'])
//        ->get('https://www.zohoapis.com/crm/v7/settings/fields', [
//            'module' => 'Deals'
//        ]);
//
//    return $response->json();
//});
