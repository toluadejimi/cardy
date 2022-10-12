<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ManageController;
use App\Http\Middleware\AdminAuth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

Route::get('/', function () {
    return view('login');
});

Route::get('/welcome', [MainController::class,'login_view']);



Route::get('forgot-password', [MainController::class, 'forgot_password']);

Route::post('forgot-password-now', [MainController::class, 'forgot_password_send_code']);

Route::get('reset-password', [MainController::class, 'reset_password']);

Route::get('verify-reset-code',[MainController::class, 'verify_reset_code']);

Route::post('verify-reset-code-now', [MainController::class, 'verify_reset_code_now']);

Route::post('reset-password-now', [MainController::class, 'reset_password_now']);














Route::get('login_notification', 'MainController@loginNotification');

Route::get('signin', [MainController::class,'signin']);



Route::get('/register', [MainController::class,'register_view']);
Route::post('register_now', [MainController::class,'register_now']);

Route::get('verify-email-code', [MainController::class,'verify_email_code']);
Route::post('verify-email-code-now', [MainController::class,'verify_email_code_now']);
Route::get('send-verification-code', [MainController::class,'send_verification_code']);




Route::post('register-verify-email', [MainController::class,'email_verify_code']);


Route::get('/add-account', [MainController::class,'add_account']);
Route::get('/add-account-now', [MainController::class,'add_account_now']);


Route::get('/confirmation', [MainController::class,'confirmation']);




Route::get('/pin-verify-account', [MainController::class,'pin_verify_account']);

Route::get('/verify-change-account', [MainController::class,'verify_change_account']);








Route::group(['middleware' => 'adminAuth'],function(){

    Route::get('/user-dashboard', [MainController::class,'user_dashboard']);


    Route::get('/my-card', [MainController::class,'my_card']);

    Route::get('/bank-transfer', [MainController::class,'bank_transfer']);
    Route::post('/withdraw-now', [MainController::class,'withdraw_now']);
    Route::post('/send-other-bank', [MainController::class,'verify_account_info']);

    Route::get('/confirm-account-before-sending', [MainController::class,'confirm_account_before_sending']);



    Route::post('/transfer-money', [MainController::class,'transfer_money']);

    Route::post('/otherbank-transfer-now', [MainController::class,'otherbank_transfer_now']);



    Route::get('/send-money-phone', [MainController::class,'send_funds_with_phone_number']);

    Route::post('/confirm-user-now', [MainController::class,'confirm_user_now']);

    Route::post('/confirm-user', [MainController::class,'confirm_user']);

    Route::post('/send-money-phone-now', [MainController::class,'send_funds_with_phone_numbe_now']);











    Route::get('/profile', [MainController::class,'profile']);
    Route::get('/bank-account', [MainController::class,'bank_account']);
    Route::get('/add-account-now', [MainController::class,'add_account_now']);


    Route::get('/security', [MainController::class,'secutiry']);


    Route::post('/delete', [MainController::class,'delete']);







    Route::get('pin-verify', [MainController::class,'pin_verify']);
    Route::get('verify', [MainController::class,'verify']);


    Route::post('verify-account-now', [MainController::class,'verify_account_now']);
    Route::get('verify-account', [MainController::class,'verify_account']);

    Route::get('create-usd-card', [MainController::class,'create_usd_card']);
    Route::post('create-usd-card-now', [MainController::class,'create_usd_card_now']);


    Route::get('create-ngn-card', [MainController::class,'create_ngn_card']);
    Route::post('create-ngn-card-now', [MainController::class,'create_ngn_card_now']);


    Route::get('usd-card', [MainController::class,'usd_card_view']);
    Route::post('fund-usd-card', [MainController::class,'fund_usd_card']);
    Route::get('get-usd-card', [MainController::class,'get_usd_card_details']);





    //Airtime & Data

    Route::get('buy-airtime', [MainController::class,'buy_airtime']);
    Route::get('buy-airtime-now', [MainController::class,'buy_airtime_now']);


    Route::get('buy-data', [MainController::class,'buy_data']);
    Route::get('buy-data-now', [MainController::class,'buy_data_now']);

    Route::get('buy-mtn-data', [MainController::class,'buy_data_now']);
    Route::get('buy-glo-data', [MainController::class,'buy_data_now']);
    Route::get('buy-airtel-data', [MainController::class,'buy_data_now']);
    Route::get('buy-9mobile-data', [MainController::class,'buy_data_now']);







    //fund-wallet
    Route::get('fund-wallet', [MainController::class,'fund_wallet']);

    Route::post('/pay-now', [MainController::class, 'pay_now']);
    // The callback url after a payment
    Route::get('/verify-pay', [MainController::class, 'callback']);


    Route::post('/bank-transfer-fund', [MainController::class, 'bank_transfer_fund']);






















    Route::get('updatepassword', [MainController::class,'update_password']);
    Route::post('update-password-now', [MainController::class,'update_password_now']);







        Route::get('logout', [MainController::class,'logout']);


        //drop off
        Route::get('/drop-off', [MainController::class,'drop_offlist']);
        Route::delete('dropoffDelete/{id}', [MainController::class,'dropoffDelete']);


        //agent request
        Route::get('/agent-request', [MainController::class,'agent_request']);
        Route::get('/agent_request_update/{id}', [MainController::class,'agent_request_update']);

       //fund agent
       Route::get('/fund-agent', [MainController::class,'fund_agent']);





       //transaction
        Route::get('/transactions', [MainController::class,'transactions']);







        Route::get('/users', [MainController::class,'users']);
        Route::get('/customers', [MainController::class,'customers']);
        Route::get('/agents', [MainController::class,'agents']);
        Route::post('createUser', [MainController::class,'createUser']);
         Route::post('/userEdit/{id}', [MainController::class,'userEdit']);
        Route::get('/user_edit/{id}', [MainController::class,'user_edit']);
        Route::delete('userDelete/{id}', [MainController::class,'userDelete']);

        Route::get('/report', [MainController::class,'report']);

        Route::get('/sorting', [MainController::class,'sorting']);
        Route::post('sorted', [MainController::class,'sorted']);

        Route::post('testsorting', [MainController::class,'testsorting']);

        Route::get('viewSortingDetails/{id}', [MainController::class,  'viewsorting']);
        Route::delete('sortedDelete/{id}', [ManageController::class,'deleteSorting']);
        // Route::get('sortedEdit/{id}', [ManageController::class,'editSorting']);
        // Route::post('sortedEdit/{id}', [ManageController::class,'updateSorting']);

        Route::get('/sortedtransfer', [MainController::class,'sortedTransferView']);
        Route::post('sorted_transfers', [MainController::class,'sortedTransfer']);
        Route::delete('sortedTransferDeleted/{id}', [ManageController::class,'sortedTransferDeleted']);

        Route::get('/item', [MainController::class,'itemList']);
        Route::get('/item_edit/{id}', [MainController::class,'itemEdit']);
        Route::post('itemEdit/{id}', [MainController::class,'itemEditUpdate']);
        Route::post('createItem', [MainController::class,'createItem']);
        Route::delete('itemDelete/{id}', [MainController::class,'itemDelete']);

        Route::get('/manage/role', [ManageController::class,'roleList']);
        Route::get('/manage/role_edit/{id}', [ManageController::class,'roleEdit']);
        Route::post('roleEdit/{id}', [ManageController::class,'roleEditUpdate']);
        Route::post('createRole', [ManageController::class,'createRole']);
        Route::delete('roleDelete/{id}', [ManageController::class,'roleDelete']);

        Route::get('/bailing', [MainController::class,'bailing']);
        Route::post('bailed', [MainController::class,'bailed']);

        Route::get('/addCollection', [MainController::class,'viewCollect']);
        Route::get('/collectioncenter', [MainController::class,'collectionCenter']);
        Route::post('collect', [MainController::class,'collect']);
        Route::get('collectionsDetails/{id}', [MainController::class,  'viewcollection']);
        Route::get('collection_center_details/{id}', [MainController::class,  'viewcollectioncenter']);
        Route::delete('deleteCollection/{id}', [ManageController::class,'deleteCollection']);


        Route::get('/bailing_item', [MainController::class,'bailingList']);
        Route::post('createBailingItem', [MainController::class,'createBailingItem']);
        Route::get('/bailing_item_edit/{id}', [MainController::class,'bailedEdit']);
        Route::post('bailItemEdit/{id}', [MainController::class,'bailItemEditUpdate']);
        Route::delete('bailedDelete/{id}', [ManageController::class,'deleteBailing']);


        Route::get('/locations', [MainController::class,'locations']);
        Route::post('createLocation', [MainController::class,'location']);
        Route::get('factory_edit/{id}', [MainController::class,'factoryEdit']);
        Route::post('factoryUpdate/{id}', [MainController::class,'factoryUpdate']);
        Route::delete('factoryDelete/{id}', [MainController::class,'factoryDelete']);


        Route::get('/factory', [MainController::class,'factory']);
        Route::get('/viewFactory/{id}', [MainController::class,'viewfactory']);
        Route::post('/createFactory', [MainController::class,'createFactory']);

        Route::get('/transfer', [MainController::class,'transfering']);
        Route::post('transferd', [MainController::class,'transferd']);
        Route::delete('tranferDeleted/{id}', [ManageController::class,'deleteTransfer']);
        Route::get('viewTransfer/{id}', [MainController::class,  'viewtransfer']);

        Route::get('/recycle', [MainController::class,'recycled']);
        Route::post('addrecycle', [MainController::class,'recycle']);
        Route::delete('recycleDelete/{id}', [ManageController::class,'deleteRecycle']);

        Route::get('/sales', [MainController::class,'salesp']);
        Route::post('addsales', [MainController::class,'sales']);
        Route::delete('salesDelete/{id}', [ManageController::class,'deleteSales']);

        //filiter

        Route::get('collectionFilter', [MainController::class,'collectionFilter']);
        Route::get('collection_report', [MainController::class,'collection_filter']);

        Route::get('sortedFilter', [MainController::class,'sortedFilter']);
        Route::get('sorting_report', [MainController::class,'sorted_filter']);

        Route::get('bailedFilter', [MainController::class,'bailedFilter']);
        Route::get('bailed_report', [MainController::class,'bailed_filter']);

        Route::get('transferFilter', [MainController::class,'transferFilter']);
        Route::get('transfered_report', [MainController::class,'transfer_filter']);

        Route::get('recycleFilter', [MainController::class,'recycleFilter']);
        Route::get('recycled_report', [MainController::class,'recycle_filter']);

        Route::get('salesFilter', [MainController::class,'salesFilter']);
        Route::get('sales_report', [MainController::class,'sales_filter']);
        Route::get('salesbailed_report', [MainController::class,'salesbailed_filter']);





});






