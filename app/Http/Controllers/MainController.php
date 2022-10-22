<?php

namespace App\Http\Controllers;

use App\Http\Traits\HistoryTrait;
use App\Models\Bank;
use App\Models\BankTransfer;
use App\Models\Charge;
use App\Models\DataType;
use App\Models\EMoney;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Vcard;
use App\Models\Power;
use App\Models\Cable;

use App\Services\Encryption;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use GuzzleHttp\Client as GuzzleClient;
use Session;

class MainController extends Controller
{

    public $successStatus = true;
    public $failedStatus = false;
    //
    use HistoryTrait;

    public function register_view(Request $request)
    {

        return view('register');
    }

    public function welcome(Request $request)
    {
        return view('welcome');
    }

    public function login_view()
    {

        return view('login');
    }

    public function register_now(Request $request)
    {

        $email_code = random_int(100000, 999999);

        $input = $request->validate([
            'f_name' => ['required', 'string'],
            'm_name' => ['required', 'string'],
            'l_name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'pin' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'password' => ['required', 'confirmed', 'string'],
        ]);

        $check_email = User::where('email', $request->email)->first()->email ?? null;

        if ($check_email == $request->email) {

            return back()->with('error', 'User Already Exist, Please Login');
        }

        $user = new User();
        $user->f_name = $request->f_name;
        $user->m_name = $request->m_name;
        $user->l_name = $request->l_name;
        $user->email = $request->email;
        $user->pin = Hash::make($request->pin);
        $user->phone = str_replace(' ', '', $request->phone);
        $user->gender = $request->gender;
        $user->type = '2';
        $user->password = Hash::make($request->password);
        $user->email_code = $email_code;
        $user->save();

        return redirect('/')->with('message', 'Your account has been successfully created, Login to continue');
    }

    public function verify_email_code(Request $request)
    {

        $user = User::all();

        return view('/auth.verify-email-code', compact('user'));
    }

    public function signin(Request $request)
    {

        $api_key = env('ELASTIC_API');
        $from = env('FROM_API');

        $email_code = random_int(100000, 999999);

        $device = $request->header('User-Agent');
        $clientIP = request()->ip();

        $credentials = $request->validate([
            'phone' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            if (Auth::user()->is_email_verified == 0) {

                $user = User::where("id", Auth::id())->get();

                $email_code = User::where('id', Auth::id())
                    ->update(['email_code' => $email_code]);

                $new_email_code = User::where('id', Auth::id())
                    ->first()->email_code;

                $f_name = User::where('id', Auth::id())
                    ->first()->f_name;

                $email = User::where('id', Auth::id())
                    ->first()->email;

                $user_email = User::where('id', Auth::id())->first()->email;
                require_once "vendor/autoload.php";
                $client = new Client([
                    'base_uri' => 'https://api.elasticemail.com',
                ]);

                // The response to get
                $res = $client->request('GET', '/v2/email/send', [
                    'query' => [

                        'apikey' => "$api_key",
                        'from' => "$from",
                        'fromName' => 'Cardy',
                        'sender' => "$from",
                        'senderName' => 'Cardy',
                        'subject' => 'Verification Code',
                        'to' => "$email",
                        'bodyHtml' => view('verifyemail', compact('new_email_code', 'f_name'))->render(),
                        'encodingType' => 0,

                    ],
                ]);

                $body = $res->getBody();
                $array_body = json_decode($body);

                return redirect('verify-email-code')->with('message', "Enter the verification code sent to $email");
            }

            $user = User::where("id", Auth::id())->get();

            $email_code = User::where('id', Auth::id())
                ->update(['email_code' => $email_code]);

            $new_email_code = User::where('id', Auth::id())
                ->first()->email_code;

            $f_name = User::where('id', Auth::id())
                ->first()->f_name;

            $email = User::where('id', Auth::id())
                ->first()->email;

            $user_email = User::where('id', Auth::id())->first()->email;

            require_once "vendor/autoload.php";
            $client = new Client([
                'base_uri' => 'https://api.elasticemail.com',
            ]);

            // The response to get
            $res = $client->request('GET', '/v2/email/send', [
                'query' => [

                    'apikey' => "$api_key",
                    'from' => "$from",
                    'fromName' => 'Cardy',
                    'sender' => "$from",
                    'senderName' => 'Cardy',
                    'subject' => 'Verification Code',
                    'to' => "$user_email",
                    'bodyHtml' => view('verification', compact('new_email_code', 'f_name'))->render(),
                    'encodingType' => 0,

                ],
            ]);

            $body = $res->getBody();
            $array_body = json_decode($body);

            return redirect('pin-verify')->with('message', "Enter the verification code sent to $email");
        } else {
            return back()->with('error', 'Invalid Credentials');
        }
    }

    public function send_verification_code(Request $request)
    {

        $api_key = env('ELASTIC_API');
        $from = env('FROM_API');

        $user = User::where("id", Auth::id())->get();

        $new_email_code = User::where('id', Auth::id())
            ->first()->email_code;

        $f_name = User::where('id', Auth::id())
            ->first()->f_name;

        $user_email = User::where('id', Auth::id())
            ->first()->email;

        require_once "vendor/autoload.php";
        $client = new Client([
            'base_uri' => 'https://api.elasticemail.com',
        ]);

        // The response to get
        $res = $client->request('GET', '/v2/email/send', [
            'query' => [

                'apikey' => "$api_key",
                'from' => "$from",
                'fromName' => 'Cardy',
                'sender' => "$from",
                'senderName' => 'Cardy',
                'subject' => 'Verification Code',
                'to' => "$user_email",
                'bodyHtml' => view('verification', compact('new_email_code', 'f_name'))->render(),
                'encodingType' => 0,

            ],
        ]);

        $body = $res->getBody();
        $array_body = json_decode($body);

        return back()->with('message', 'Verification code sent successfully');
    }

    public function pin_verify(Request $request)
    {

        $user = User::all();

        return view('pin-verify', compact('user'));
    }

    public function pin_verify_account(Request $request)
    {
        $api_key = env('ELASTIC_API');
        $from = env('FROM_API');

        $email_code = random_int(100000, 999999);

        $user = User::all();

        $email_code = User::where('id', Auth::id())
            ->update(['email_code' => $email_code]);

        $f_name = User::where('id', Auth::id())
            ->first()->f_name;

        $new_email_code = User::where('id', Auth::id())
            ->first()->email_code;

        $user_email = User::where('id', Auth::id())->first()->email;
        require_once "vendor/autoload.php";
        $client = new Client([
            'base_uri' => 'https://api.elasticemail.com',
        ]);

        // The response to get
        $res = $client->request('GET', '/v2/email/send', [
            'query' => [

                'apikey' => "$api_key",
                'from' => "$from",
                'fromName' => 'Cardy',
                'sender' => "$from",
                'senderName' => 'Cardy',
                'subject' => 'Verification Code',
                'to' => "$user_email",
                'bodyHtml' => view('change-account', compact('new_email_code', 'f_name'))->render(),
                'encodingType' => 0,

            ],
        ]);

        $body = $res->getBody();
        $array_body = json_decode($body);

        return view('pin-verify-account', compact('user', 'new_email_code', 'f_name'))->with('message', "Enter the verification code sent to $user_email");
    }

    public function verify_change_account(Request $request)
    {
        $user_code = User::where('email', Auth::user()->email)
            ->first()->email_code;

        $codes = $request->code;

        if ($codes == $user_code) {
            return redirect('/add-account');
        }

        return back()->with('error', 'Invalid Code');
    }

    public function email_verify_code(Request $request)
    {

        $user_code = User::where('email', Auth::user()->email)
            ->first()->email_code;

        $codes = $request->code;

        if ($codes == $user_code) {

            $update = User::where('email', Auth::user()->email)
                ->update(['is_email_verified' => 1]);

            $wallet = new EMoney();
            $wallet->user_id = Auth::id();
            $wallet->save();

            return redirect('/user-dashboard')->with('message', 'Your Email has been verified');
        }

        return back()->with('error', 'Invalid Code');
    }

    public function verify(Request $request)
    {

        $input = $request->code;

        $get_email_code = Auth::user()->email_code;

        if ($input == $get_email_code) {

            return redirect('user-dashboard');
        } else {
            return back()->with('error', 'Invalid Code');
        }
    }

    public function user_dashboard()
    {
        $get_user_id = Auth::id();

        $get_user_wallet = EMoney::where('user_id', $get_user_id)
            ->first();

        if ($get_user_wallet == null) {

            $wallet = new EMoney;
            $wallet->user_id = $get_user_id;
            $wallet->save();
        }

        $users = User::all();

        $uuid = Auth::id();

        $transactions = Transaction::orderBy('id', 'DESC')
            ->where('user_id', $uuid)
            ->orWhere('to_user_id', $uuid)
            ->paginate(10);

        $user_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        return view('user-dashboard', compact('users', 'user_wallet', 'transactions'));
    }

    public function my_card(Request $request)
    {

        $usd_card_id = Vcard::where('user_id', Auth::id())
            ->where('card_type', 'usd')
            ->first()->card_id ?? null;

        $carddetails = Vcard::where('card_id', $usd_card_id)
            ->first() ?? null;

        if ($carddetails == null) {
            return redirect('/user-dashboard');
        }

        if (Auth::user()->is_kyc_verified == '0') {
            return redirect('/user-dashboard');
        }

        if (Auth::user()->balance == 'null') {
            return redirect('/user-dashboard');
        }

        $usd_card_id = Vcard::where('user_id', Auth::id())
            ->where('card_type', 'usd')
            ->first()->card_id ?? null;

        $carddetails = Vcard::where('card_id', $usd_card_id)
            ->first() ?? null;

        $card_amount = $carddetails->balance / 100;
        $card_name = $carddetails->name_on_card;

        $usd_card_no_decrypt = Encryption::decryptString($carddetails->card_number);
        $usd_card_cvv_decrypt = Encryption::decryptString($carddetails->cvv);
        $usd_card_expiry_month_decrypt = Encryption::decryptString($carddetails->expiry_month);
        $usd_card_expiry_year_decrypt = Encryption::decryptString($carddetails->expiry_year);
        $usd_card_last_decrypt = Encryption::decryptString($carddetails->last_four);

        $card = Vcard::where('user_id', Auth::id())
            ->get();

        $user = User::all();
        $user_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        return view('mycard', compact('user', 'card_amount', 'usd_card_last_decrypt', 'card_name', 'usd_card_cvv_decrypt', 'usd_card_expiry_month_decrypt', 'usd_card_expiry_year_decrypt', 'user_wallet', 'card'));
    }

    public function create_usd_card(Request $request)
    {


        $get_rate = Charge::where('title', 'rate')->first();
        $rate = $get_rate->amount;

        $conversion_rate = Charge::where('title', 'rate')->first()->amount;

        $get_usd_creation_fee = Charge::where('title', 'usd_card_creation')->first();
        $usd_creation_fee = $get_usd_creation_fee->amount;

        $rate2 = $usd_creation_fee * $rate;

        $min_amount = $rate * 10;
        $max_amount = $rate * 250;

        $funding_fee = Charge::where('title', 'funding')
            ->first('amount');

        $get_usd_card_records = Vcard::where('card_type', 'usd')
            ->where('user_id', Auth::id())
            ->get() ?? null;

        $card = Vcard::all();

        $user = User::all();
        $user_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        return view('create-usd-card', compact('user', 'user_wallet', 'funding_fee', 'max_amount', 'min_amount', 'card', 'rate', 'rate2', 'get_usd_card_records', 'conversion_rate'));
    }

    public function create_ngn_card(Request $request)
    {

        $get_rate = Charge::where('title', 'rate')->first();
        $rate = $get_rate->amount;

        $get_ngn_creation_fee = Charge::where('title', 'ngn_card_creation')->first();
        $ngn_creation_fee = $get_ngn_creation_fee->amount;

        $card = Vcard::all();

        $get_ngn_card_records = Vcard::where('card_type', 'ngn')
            ->where('user_id', Auth::id())
            ->get();

        $user = User::all();
        $user_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        return view('create-ngn-card', compact('user', 'user_wallet', 'card', 'rate', 'ngn_creation_fee', 'get_ngn_card_records'));
    }

    public function create_usd_card_now(Request $request)
    {




        $input = $request->validate([
            'amount_to_fund' => ['required', 'string'],
            'result' => ['required', 'string'],

        ]);


        $final_amount_ngn = $request->result;

        $amount_in_ngn = $request->amount_to_fund;

        $funding_fee = Charge::where('title', 'funding')
            ->first('amount');




        $get_rate = Charge::where('title', 'rate')->first();
        $rate = $get_rate->amount;


        $get_usd_creation_fee = Charge::where('title', 'usd_card_creation')->first();
        $usd_creation_fee = $get_usd_creation_fee->amount;

        $usd_card_conversion_rate_to_naira = $usd_creation_fee * $rate;





        $get_amount_to_fund_mono = $amount_in_ngn - $usd_card_conversion_rate_to_naira;

        $amount_to_fund_mono = $get_amount_to_fund_mono / $rate;










        $get_user_amount = EMoney::where('user_id', Auth::id())
            ->first();
        $user_amount = $get_user_amount->current_balance;




        $get_amount_in_usd = (int) $amount_in_ngn / (int) $rate;

        $get_total_in_ngn = (int) $amount_in_ngn + (int) $usd_card_conversion_rate_to_naira;



        $get_amount_in_usd_to_cent = $amount_to_fund_mono * 100;






        $mono_amount_in_cent  = round($get_amount_in_usd_to_cent, 2);



        $get_usd_card_records = Vcard::where('card_type', 'usd')
            ->where('user_id', Auth::id())
            ->get() ?? null;

        if ($usd_card_conversion_rate_to_naira > $user_amount) {
            return back()->with('error', 'Insufficient funds, Fund your wallet to continue.');
        }

        if ($amount_in_ngn > $user_amount) {
            return back()->with('error', 'Insufficient funds, Fund your wallet to continue.');
        }

        $check_for_usd_virtual_card = Vcard::where('user_id', Auth::id())
            ->where('card_type', 'usd')
            ->first();


        if (empty($check_for_usd_virtual_card)) {

            $api_key = env('ELASTIC_API');
            $from = env('FROM_API');

            $databody = array(
                "account_holder" => Auth::user()->mono_customer_id,
                "currency" => "usd",
                "amount" => $mono_amount_in_cent,
            );

            $mono_api_key = env('MONO_KEY');

            $body = json_encode($databody);
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, 'https://api.withmono.com/issuing/v1/cards/virtual');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_ENCODING, '');
            curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
            curl_setopt($curl, CURLOPT_TIMEOUT, 0);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(
                $curl,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                    'Accept: application/json',
                    "mono-sec-key: $mono_api_key",
                )
            );
            // $final_results = curl_exec($curl);

            $var = curl_exec($curl);
            curl_close($curl);

            $var = json_decode($var);




            if ($var->status == 'successful') {

                $card = new Vcard();
                $card->card_id = $var->data->id;
                $card->user_id = Auth::id();
                $card->card_type = 'usd';
                $card->save();

                $debit = $user_amount - $amount_in_ngn;
                $update = EMoney::where('user_id', Auth::id())
                    ->update([
                        'current_balance' => $debit,
                    ]);




                $transaction = new Transaction();
                $transaction->ref_trans_id = Str::random(10);
                $transaction->user_id = Auth::id();
                $transaction->transaction_type = "cash_out";
                $transaction->debit = $amount_in_ngn;
                $transaction->note = "USD Card Creation and Funding";
                $transaction->save();





                $email = User::where('id', Auth::id())
                ->first()->email;

            $f_name = User::where('id', Auth::id())
                ->first()->f_name;

            require_once "vendor/autoload.php";
            $client = new Client([
                'base_uri' => 'https://api.elasticemail.com',
            ]);

            $res = $client->request('GET', '/v2/email/send', [
                'query' => [

                    'apikey' => "$api_key",
                    'from' => "$from",
                    'fromName' => 'Cardy',
                    'sender' => "$from",
                    'senderName' => 'Cardy',
                    'subject' => 'Fund Wallet',
                    'to' => "$email",
                    'bodyHtml' => view('card-creation-notification', compact('f_name'))->render(),
                    'encodingType' => 0,

                ],
            ]);

            $body = $res->getBody();
            $array_body = json_decode($body);




                return back()->with('message', 'Card creation is been processed');


            } else {



                $err_message = $var->message;


                require_once "vendor/autoload.php";
                $client = new Client([
                    'base_uri' => 'https://api.elasticemail.com',
                ]);

                $res = $client->request('GET', '/v2/email/send', [
                    'query' => [

                        'apikey' => "$api_key",
                        'from' => "$from",
                        'fromName' => 'Cardy',
                        'sender' => "$from",
                        'senderName' => 'Cardy',
                        'subject' => 'Card Creation Error',
                        'to' => 'toluadejimi@gmail.com',
                        'bodyText' => "Error from Mono -  $err_message",
                        'encodingType' => 0,

                    ],
                ]);

                $body = $res->getBody();
                $array_body = json_decode($body);


                return back()->with('error', 'Opps!! Unable to fund card this time, Please Try again Later');
            }
        }

        return back()->with('error', 'Sorry!! You can only have one USD Virtual Card');

        $card = Vcard::all();
        $user = User::all();
        $user_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        return view('create-usd-card', compact('user', 'user_wallet', 'card'));
    }

    public function create_ngn_card_now(Request $request)
    {
        $input = $request->validate([
            'amount' => ['required', 'string'],
        ]);

        $amount_in_ngn = $request->amount;

        $get_rate = Charge::where('title', 'rate')->first();
        $rate = $get_rate->amount;

        $get_ngn_creation_fee = Charge::where('title', 'ngn_card_creation')->first();
        $ngn_creation_fee = $get_ngn_creation_fee->amount;

        $get_user_amount = EMoney::where('user_id', Auth::id())
            ->first();
        $user_amount = $get_user_amount->current_balance;

        $get_total_in_ngn = (int) $amount_in_ngn + (int) $ngn_creation_fee;

        if ($get_total_in_ngn > $user_amount) {
            return back()->with('error', 'Insufficient funds, Fund your wallet to continue.');
        }

        if ($amount_in_ngn > $user_amount) {
            return back()->with('error', 'Insufficient funds, Fund your wallet to continue.');
        }

        $check_for_ngn_virtual_card = Vcard::where('user_id', Auth::id())
            ->where('card_type', 'ngn')
            ->first();

        if (empty($check_for_ngn_virtual_card)) {

            $databody = array(
                "account_holder" => Auth::user()->mono_customer_id,
                "currency" => "ngn",
                "amount" => $amount_in_ngn,
            );

            $mono_api_key = env('MONO_KEY');

            $body = json_encode($databody);
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, 'https://api.withmono.com/issuing/v1/cards/virtual');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_ENCODING, '');
            curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
            curl_setopt($curl, CURLOPT_TIMEOUT, 0);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(
                $curl,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                    'Accept: application/json',
                    "mono-sec-key: $mono_api_key",

                )
            );
            // $final_results = curl_exec($curl);

            $var = curl_exec($curl);
            curl_close($curl);

            $var = json_decode($var);

            if ($var->status == 'successful') {

                function generateRandomString($length = 10)
                {
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
                    return $randomString;
                }

                $debit = $user_amount - $get_total_in_ngn;
                $update = EMoney::where('user_id', Auth::id())
                    ->update([
                        'current_balance' => $debit,
                    ]);

                $transaction = new Transaction();
                $transaction->ref_trans_id = Str::random(10);
                $transaction->user_id = Auth::id();
                $transaction->transaction_type = "cash_out";
                $transaction->debit = $get_total_in_ngn;
                $transaction->note = "NGN Card Creation and Funding";
                $transaction->save();

                $card = new Vcard();
                $card->card_id = $var->id;
                $card->user_id = Auth::id();
                $card->save;

                return back()->with('message', 'Card creation is been processed');
            } else {

                return back()->with('error', 'Opps!! Unable to fund card this time, Please Try again Later');
            }
        }
        return back()->with('error', 'Sorry!! You can only have one NGN Virtual Card');

        $card = Vcard::all();
        $user = User::all();
        $user_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        return view('create-usd-card', compact('user', 'user_wallet', 'card'));
    }

    public function usd_card_view(Request $request)
    {

        if (Auth::user()->is_kyc_verified == '0') {
            return redirect('/user-dashboard');
        }

        $fund = Charge::where('title', 'funding')->first()->amount;

        $get_rate = Charge::where('title', 'rate')->first();
        $rate = $get_rate->amount;

        $sd = $rate * $fund;

        $min_amount = ($rate * 10) + $sd;
        $max_amount = ($rate  * 250) +$sd ;

        $get_usd_creation_fee = Charge::where('title', 'usd_card_creation')->first();
        $usd_creation_fee = $get_usd_creation_fee->amount;

        $usd_card_conversion_rate_to_naira = $usd_creation_fee * $rate;

        $users = User::all();

        $check = Vcard::where('user_id', Auth::id())
            ->first();

        if ($check == null) {
            return redirect('/user-dashboard');
        }

        $user_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        $get_id = Vcard::where('user_id', Auth::id())
            ->where('card_type', 'usd')
            ->first();

        $get_status = Vcard::where('user_id', Auth::id())
            ->first()->status;

        if ($get_id == null) {

            return back()->with('error', 'You dont have an active USD card, Please create one.');
        }

        //card transaction
        $id = $get_id->card_id;

        $databody = array();

        $mono_api_key = env('MONO_KEY');

        $body = json_encode($databody);
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, "https://api.withmono.com/issuing/v1/cards/$id/transactions");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Accept: application/json',
                "mono-sec-key: $mono_api_key",

            )
        );

        $var = curl_exec($curl);
        curl_close($curl);

        $var = json_decode($var);

        $cardTransaction = $var->data;

        if ($var->status == 'failed') {

            return redirect('/user-dashboard')->with('error', 'Sorry!!, Undable to fetch card at the moment. Contact Support..');
        }

        //get_card details
        $id = $get_id->card_id;

        $databody = array();

        $mono_api_key = env('MONO_KEY');

        $body = json_encode($databody);
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, "https://api.withmono.com/issuing/v1/cards/$id");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Accept: application/json',
                "mono-sec-key: $mono_api_key",

            )
        );

        $var = curl_exec($curl);
        curl_close($curl);

        $var = json_decode($var);
        $cardDetails = $var->data;

        if ($get_status == 1) {

            $update = Vcard::where('card_id', $id)
                ->update([
                    'balance' => $var->data->balance,
                ]);
        } else {

            $update = Vcard::where('card_id', $id)
                ->update([
                    'city' => $var->data->billing_address->city,
                    'country' => $var->data->billing_address->country,
                    'street' => $var->data->billing_address->street,
                    'postal_code' => $var->data->billing_address->postal_code,
                    'state' => $var->data->billing_address->state,
                    'card_status' => $var->data->status,
                    'type' => $var->data->type,
                    'card_id' => $var->data->id,
                    'brand' => $var->data->brand,
                    'status' => 1,
                    'name_on_card' => $var->data->name_on_card,
                    'balance' => $var->data->balance,
                    'created_at' => $var->data->created_at,
                    'card_number' => $var->data->card_number,
                    'cvv' => $var->data->cvv,
                    'expiry_month' => $var->data->expiry_month,
                    'expiry_year' => $var->data->expiry_year,
                    'last_four' => $var->data->last_four,
                    'account_holder' => $var->data->account_holder,

                ]);
        }

        $carddetails = Vcard::where('card_id', $id)
            ->first();

        $card_amount = $carddetails->balance / 100;
        $card_name = $carddetails->name_on_card;
        $city = $carddetails->city;
        $country = $carddetails->country;
        $street = $carddetails->street;
        $state = $carddetails->state;
        $zip_code = $carddetails->postal_code;
        $type = $carddetails->type;

        //Decryption of card

        $usd_card_no_decrypt = Encryption::decryptString($carddetails->card_number);
        $usd_card_cvv_decrypt = Encryption::decryptString($carddetails->cvv);
        $usd_card_expiry_month_decrypt = Encryption::decryptString($carddetails->expiry_month);
        $usd_card_expiry_year_decrypt = Encryption::decryptString($carddetails->expiry_year);
        $usd_card_last_decrypt = Encryption::decryptString($carddetails->last_four);

        return view('usd-card', compact('users', 'cardTransaction', 'min_amount', 'fund', 'max_amount', 'city', 'country', 'street', 'state', 'zip_code', 'type', 'usd_card_last_decrypt', 'card_name', 'card_amount', 'usd_card_expiry_year_decrypt', 'usd_card_expiry_month_decrypt', 'usd_card_no_decrypt', 'usd_card_cvv_decrypt', 'user_wallet', 'rate', 'fund', 'carddetails', 'usd_card_conversion_rate_to_naira'));
    }

    public function fund_wallet(Request $request)
    {

        $url = env('FLCURL');

        $users = User::all();

        $user_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        $funding_rate = Charge::where('title', 'funding')
            ->first()->amount;

        $fpk = env('FLWPKEY');

        $banktransfers = BankTransfer::orderBy('id', 'DESC')
            ->where('user_id', Auth::id())
            ->take(10)->get();

        $trx = Str::random(10);

        return view('fund-wallet', compact('users', 'banktransfers', 'trx', 'user_wallet', 'fpk'));
    }

    public function callback(Request $request)
    {

        $api_key = env('ELASTIC_API');
        $from = env('FROM_API');

        $fpk = env('FLWPKEY');

        $fsk = env('FLW_SECRET_KEY');

        $transaction_id = $request->query('transaction_id');
        $status = $request->query('status');

        if ($status == 'successful') {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/$transaction_id/verify", // Pass transaction ID for validation
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Bearer $fsk",
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $res = json_decode($response);

            $new_amount = $res->data->amount;

            if ($res->status == 'success') {
                //fund user wallet

                $amount = number_format($res->data->amount, 2);
                $first_name = Auth::user()->f_name;

                $user_wallet = EMoney::where('user_id', $res->data->meta->user_id)
                    ->first()->current_balance;

                $credit = (int) $res->data->amount + (int) $user_wallet;

                $update = EMoney::where('user_id', $res->data->meta->user_id)
                    ->update([
                        'current_balance' => $credit,
                    ]);

                $transaction = new Transaction();
                $transaction->ref_trans_id = $res->data->flw_ref;
                $transaction->user_id = $res->data->meta->user_id;
                $transaction->transaction_type = "Cash in";
                $transaction->debit = $res->data->amount;
                $transaction->note = "Funding ot Wallet";
                $transaction->save();

                $transfer = new BankTransfer();
                $transfer->amount = $res->data->amount;
                $transfer->user_id = $res->data->meta->user_id;
                $transfer->ref_id = $res->data->flw_ref;
                $transfer->status = 1;
                $transfer->type = "Instant Funding";
                $transfer->save();

                $users = User::where('id', Auth::id())
                    ->first();

                $email = User::where('id', Auth::id())
                    ->first()->email;

                $f_name = User::where('id', Auth::id())
                    ->first()->f_name;

                require_once "vendor/autoload.php";
                $client = new Client([
                    'base_uri' => 'https://api.elasticemail.com',
                ]);

                $res = $client->request('GET', '/v2/email/send', [
                    'query' => [

                        'apikey' => "$api_key",
                        'from' => "$from",
                        'fromName' => 'Cardy',
                        'sender' => "$from",
                        'senderName' => 'Cardy',
                        'subject' => 'Fund Wallet',
                        'to' => "$email",
                        'bodyHtml' => view('wallet-fund-nofication', compact('f_name', 'new_amount'))->render(),
                        'encodingType' => 0,

                    ],
                ]);

                $body = $res->getBody();
                $array_body = json_decode($body);
            }
            return redirect('/fund-wallet')->with('message', 'Your Wallet has been successfully credited');
        } else {

            $transfer = new BankTransfer();
            $transfer->amount = $res->data->amount;
            $transfer->user_id = Auth::id();
            $transfer->ref_id = "failed";
            $transfer->status = 0;
            $transfer->type = "Instant Funding";
            $transfer->save();

            return redirect('/fund-wallet')->with('error', 'Sorry Unable to fund wallet Please contact support');
        }
    }

    public function get_usd_card_details(Request $request)
    {

        $databody = array();

        $mono_api_key = env('MONO_KEY');

        $body = json_encode($databody);
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://api.withmono.com/issuing/v1/accountholders');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Accept: application/json',
                "mono-sec-key: $mono_api_key",

            )
        );

        $var = curl_exec($curl);
        curl_close($curl);

        $var = json_decode($var);
        $cardTranscation = $var->data;

        $get_rate = Charge::where('title', 'rate')->first();
        $rate = $get_rate->amount;

        $user_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        $mono_api_key = env('MONO_KEY');

        $card_number = Vcard::where('user_id', Auth::id())
            ->first()->card_number;

        //card decryption

        $encryptedBin = hex2bin($card_number);

        $iv = substr($encryptedBin, 0, 16);

        $encryptedText = substr($card_number, 16);

        $key = substr(base64_encode(hash('sha256', $mono_api_key, true)), 0, 32);

        $algorithm = "aes-256-cbc";

        $usd_card_number = openssl_decrypt($card_number, $algorithm, $mono_api_key, OPENSSL_RAW_DATA, $iv);

        dd($usd_card_number);

        return view('usd-card', compact('card_number', 'user_wallet', 'rate', 'cardTranscation'));
    }

    public function fund_usd_card(Request $request)
    {

        $amount_to_fund = $request->validate([
            'amount_to_fund' => ['required', 'string'],
        ]);

        $amount_to_fund = $request->amount_to_fund;

        $card_id = Vcard::where('user_id', Auth::user()->id)
            ->first()->card_id;

        $id = $card_id;

        $get_rate = Charge::where('title', 'rate')->first();
        $rate = $get_rate->amount;

        $get_fund = Charge::where('title', 'funding')->first()->amount;

        $fund = $get_fund * 100;



        $users = User::all();

        $user_wallet_banlance = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        $get_usd_amount = (int) $amount_to_fund / (int) $rate;

        $get_usd_amount = round($get_usd_amount * 100 );



        $usd_amount = $get_usd_amount - $fund;



        if ($amount_to_fund < $user_wallet_banlance) {

            if ($usd_amount >= 1000) {

                //debit user for card funding
                $debit = (int) $user_wallet_banlance - (int) $amount_to_fund;

                $update = EMoney::where('user_id', Auth::id())
                    ->update([
                        'current_balance' => $debit,
                    ]);

                $transaction = new Transaction();
                $transaction->ref_trans_id = Str::random(10);
                $transaction->user_id = Auth::id();
                $transaction->transaction_type = "cash_out";
                $transaction->debit = $amount_to_fund;
                $transaction->note = "Usd Card Funding";
                $transaction->save();

                $mono_api_key = env('MONO_KEY');

                $databody = array(

                    "amount" => $usd_amount,
                    "fund_source" => 'usd',
                );

                $body = json_encode($databody);
                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, "https://api.withmono.com/issuing/v1/cards/$id/fund");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_ENCODING, '');
                curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
                curl_setopt($curl, CURLOPT_TIMEOUT, 0);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "mono-sec-key: $mono_api_key",
                    )
                );
                // $final_results = curl_exec($curl);

                $var = curl_exec($curl);
                curl_close($curl);

                $var = json_decode($var);

                if ($var->status == 'failed') {

                    //refund user for card funding
                    $credit = (int) $amount_to_fund + (int) $user_wallet_banlance - (int) $amount_to_fund;

                    $update = EMoney::where('user_id', Auth::id())
                        ->update([
                            'current_balance' => $credit,
                        ]);

                    $transaction = new Transaction();
                    $transaction->ref_trans_id = Str::random(10);
                    $transaction->user_id = Auth::id();
                    $transaction->transaction_type = "refund";
                    $transaction->debit = $amount_to_fund;
                    $transaction->note = "Refund";
                    $transaction->save();

                    return back()->with('error', "Sorry!! Unable to fund card, Contact Support");
                }
                return back()->with('message', "Card Funded with $get_usd_amount");
            }
            return back()->with('error', 'Sorry!! Minimum Amount to fund is 10USD');
        }
        return back()->with('error', 'Sorry!! Insufficient Funds, Fund your Wallet');
    }

    public function buy_airtime(Request $request)
    {
        $user_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        $user = User::all();

        return view('buy-airtime', compact('user', 'user_wallet'));
    }

    public function buy_airtime_now(Request $request)
    {

        $user_wallet_banlance = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        $userid = env('CKUSER');
        $apikey = env('CKKEY');

        $input = $request->validate([
            'network' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'amount_to_fund' => ['required', 'string'],
            'pin' => ['required', 'string'],

        ]);

        $mobilenetwork_code = $request->network;
        $recipient_mobilenumber = $request->phone_number;
        $order_amount = $request->amount_to_fund;
        $callback_url = "https://cardy.enkwave.com";
        $transfer_pin = $request->pin;

        $getpin = Auth()->user();
        $user_pin = $getpin->pin;

        if (Hash::check($transfer_pin, $user_pin)) {

            if ($order_amount < 100) {
                return back()->with('error', 'Amount must not be less than NGN 100');
            }

            if ($order_amount <= $user_wallet_banlance) {

                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, "https://www.nellobytesystems.com/APIAirtimeV1.asp?UserID=$userid&APIKey=$apikey&MobileNetwork=$mobilenetwork_code&Amount=$order_amount&MobileNumber=$recipient_mobilenumber&CallBackURL=$callback_url");

                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_ENCODING, '');
                curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
                curl_setopt($curl, CURLOPT_TIMEOUT, 0);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/json',
                        'Accept: application/json',
                    )
                );
                // $final_results = curl_exec($curl);

                $var = curl_exec($curl);
                curl_close($curl);

                $var = json_decode($var);

                if ($var->status == 'INSUFFICIENT_BALANCE') {

                    return back()->with('error', "Sorry!! Unable to Recharge, Please contact our support");
                }

                $debit = $user_wallet_banlance - $order_amount;

                $update = EMoney::where('user_id', Auth::id())
                    ->update([
                        'current_balance' => $debit,
                    ]);

                $transaction = new Transaction();
                $transaction->ref_trans_id = Str::random(10);
                $transaction->user_id = Auth::id();
                $transaction->transaction_type = "cash_out";
                $transaction->debit = $order_amount;
                $transaction->note = "Airtime Purchase to $recipient_mobilenumber";
                $transaction->save();

                return back()->with('message', "Airtime Purchase Successful");
            }
            return back()->with('error', "Insufficnet Funds, Fund your Wallet");
        } else {
            return back()->with('error', 'Invalid Pin');
        }
    }

    public function buy_data(Request $request)
    {
        $user_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        $user = User::all();

        $get_mtn_network = DataType::where('network', 'MTN')->get();
        $get_glo_network = DataType::where('network', 'GLO')->get();
        $get_airtel_network = DataType::where('network', 'Airtel')->get();
        $get_9mobile_network = DataType::where('network', '9mobile')->get();

        return view('buy-data', compact('user', 'user_wallet', 'get_mtn_network', 'get_glo_network', 'get_airtel_network', 'get_9mobile_network'));
    }

    public function bank_transfer(Request $request)
    {
        $user_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        $user = User::all();

        $account_number = User::where('id', Auth::id())
            ->first()->account_number;

        $banktransfers = BankTransfer::orderBy('id', 'DESC')
            ->where('user_id', Auth::id())
            ->where('type', 'Withdrawal')
            ->take(10)->get();

        //get banks

        $country = "NG";

        $databody = array(
            "country" => $country,
        );

        $body = json_encode($databody);
        $curl = curl_init();

        $key = env('FLW_SECRET_KEY');

        //"Authorization: $key",
        curl_setopt($curl, CURLOPT_URL, "https://api.flutterwave.com/v3/banks/$country");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: $key",
            )
        );

        $var = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($var);


        $banks = $result->data;

        return view('bank-transfer', compact('user', 'user_wallet', 'banks', 'banktransfers'));
    }

    public function send_funds_with_phone_number(Request $request)
    {
        $user_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        $user = User::all();

        $banktransfers = BankTransfer::orderBy('id', 'DESC')
            ->where('user_id', Auth::id())
            ->where('type', 'Cardy-User')
            ->take(10)->get();

        return view('send-money-phone', compact('user', 'user_wallet', 'banktransfers'));
    }

    public function confirm_user(Request $request)
    {

        $input = $request->validate([
            'amount' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'pin' => ['required', 'string'],
        ]);

        $sender_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        $user_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        $user = User::all();

        $phone = $request->phone;

        $amount = $request->amount;

        $transfer_pin = $request->pin;

        $getpin = Auth()->user()->pin;
        $user_pin = $getpin;

        if (Hash::check($transfer_pin, $user_pin)) {

            $receiver = User::where('phone', $request->phone)
                ->first();

            if ($receiver == null) {

                return back()->with('error', 'Sorry!! User not found');

            }

            $surname = $receiver->l_name;
            $first_name = $receiver->f_name;
            $status = $receiver->is_kyc_verified;
            $receiver_id = $receiver->id;

            $receiver_amount = EMoney::where('user_id', $receiver_id)
                ->first()->current_balance;

            if (Auth::user()->phone == $phone) {

                return back()->with('error', 'Sorry!! You can not send money to yourslef');

            }

            if ($user_wallet < $amount) {

                return back()->with('error', 'Sorry!! Insufficent Funds, Fund your wallet');

            }

            if ($status == 0) {

                return back()->with('error', 'Sorry!! User is not verified');

            }
            return view('confirm-user', compact('user', 'user_wallet', 'surname', 'amount', 'phone', 'first_name'));

        }return back()->with('error', 'Invalid Pin');

    }

    public function send_funds_with_phone_numbe_now(Request $request)
    {

        $api_key = env('ELASTIC_API');
        $from = env('FROM_API');

        $sender_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        $user_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        $user = User::all();

        $phone = $request->phone;

        $amount = $request->amount;

        $receiver = User::where('phone', $request->phone)
            ->first();
        $surname = $receiver->l_name;
        $first_name = $receiver->f_name;
        $status = $receiver->is_kyc_verified;
        $receiver_id = $receiver->id;
        $receiver_email = $receiver->email;

        $receiver_amount = EMoney::where('user_id', $receiver_id)
            ->first()->current_balance;

        if (Auth::user()->phone == $phone) {

            return back()->with('error', 'Sorry!! You can not send money to yourslef');

        }

        if ($user_wallet < $amount) {

            return back()->with('error', 'Sorry!! Insufficent Funds, Fund your wallet');

        }

        if ($status == 0) {

            return back()->with('error', 'Sorry!! User is not verified');

        }

        if ($receiver == null) {

            return back()->with('error', 'Sorry!! User not found');

        }

        $sender_debit = $sender_wallet - $amount;

        $receiver_credit = $receiver_amount + $amount;

        //update sender
        $update_sender = EMoney::where('user_id', Auth::id())
            ->update(['current_balance' => $sender_debit]);

        //update receiver
        $update_receiver = EMoney::where('user_id', $receiver_id)
            ->update(['current_balance' => $receiver_credit]);

        //sender debit notfifcation

        $email = Auth::user()->email;
        $sf_name = Auth::user()->f_name;
        require_once "vendor/autoload.php";
        $client = new Client([
            'base_uri' => 'https://api.elasticemail.com',
        ]);

        $res = $client->request('GET', '/v2/email/send', [
            'query' => [

                'apikey' => "$api_key",
                'from' => "$from",
                'fromName' => 'Cardy',
                'sender' => "$from",
                'senderName' => 'Cardy',
                'subject' => 'Cardy Transfer',
                'to' => "$email",
                'bodyHtml' => view('send-by-phone-debit-notification', compact('sf_name', 'amount'))->render(),
                'encodingType' => 0,

            ],
        ]);

        $body = $res->getBody();
        $array_body = json_decode($body);

        //credit notofication

        require_once "vendor/autoload.php";
        $client = new Client([
            'base_uri' => 'https://api.elasticemail.com',
        ]);

        $res = $client->request('GET', '/v2/email/send', [
            'query' => [

                'apikey' => "$api_key",
                'from' => "$from",
                'fromName' => 'Cardy',
                'sender' => "$from",
                'senderName' => 'Cardy',
                'subject' => 'Cardy Transfer',
                'to' => "$receiver_email",
                'bodyHtml' => view('credit-notification', compact('first_name', 'amount'))->render(),
                'encodingType' => 0,

            ],
        ]);

        $body = $res->getBody();
        $array_body = json_decode($body);

        $ref = Str::random(10);

        $transaction = new Transaction();
        $transaction->ref_trans_id = $ref;
        $transaction->user_id = Auth::id();
        $transaction->from_user_id = Auth::id();
        $transaction->to_user_id = $receiver_id;
        $transaction->transaction_type = "Cardy Transfer";
        $transaction->debit = $amount;
        $transaction->credit = $amount;
        $transaction->note = "Transfer to Cardy User";
        $transaction->save();

        return redirect('/send-money-phone')->with('message', "You have successfully sent NGN $amount  to  $surname $first_name ");

    }

    public function bank_transfer_fund(Request $request)
    {

        $fpk = env('FLWPKEY');

        $trx = Str::random(10);

        $user_wallet = EMoney::where('user_id', Auth::id())
            ->first()->current_balance;

        $amount = $request->amount;

        $user_id = Auth::id();

        $ref_id = "CA-" . Auth::id() . "-" . Str::random(3);

        $account_number = Bank::where('id', '1')
            ->first()->account_number;

        $account_name = Bank::where('id', '1')
            ->first()->account_name;

        $bank_name = Bank::where('id', '1')
            ->first()->bank_name;

        $transfer = new BankTransfer();
        $transfer->amount = $amount;
        $transfer->user_id = $user_id;
        $transfer->ref_id = $ref_id;
        $transfer->type = "Bank Transfer";
        $transfer->save();

        $api_key = env('ELASTIC_API');
        $from = env('FROM_API');

        $user = User::where('id', Auth::id())
            ->first();

        $email = User::where('id', Auth::id())
            ->first()->email;

        $f_name = User::where('id', Auth::id())
            ->first()->f_name;

        require_once "vendor/autoload.php";
        $client = new Client([
            'base_uri' => 'https://api.elasticemail.com',
        ]);

        $res = $client->request('GET', '/v2/email/send', [
            'query' => [

                'apikey' => "$api_key",
                'from' => "$from",
                'fromName' => 'Cardy',
                'sender' => "$from",
                'senderName' => 'Cardy',
                'subject' => 'Fund Wallet With Transfer',
                'to' => "$email",
                'bodyHtml' => view('bank-transfer-notification', compact('f_name', 'amount', 'account_number', 'account_name', 'bank_name', 'ref_id'))->render(),
                'encodingType' => 0,

            ],
        ]);

        $body = $res->getBody();
        $array_body = json_decode($body);



        require_once "vendor/autoload.php";
        $client = new Client([
            'base_uri' => 'https://api.elasticemail.com',
        ]);

        $res = $client->request('GET', '/v2/email/send', [
            'query' => [

                'apikey' => "$api_key",
                'from' => "$from",
                'fromName' => 'Cardy',
                'sender' => "$from",
                'senderName' => 'Cardy',
                'subject' => 'Fund Wallet With Transfer',
                'to' => 'toluadejimi@gmail.com',
                'message' => "New Transfer Pending message from  $email",
                'encodingType' => 0,

            ],
        ]);

        $body = $res->getBody();
        $array_body = json_decode($body);

        return redirect('/fund-wallet')->with('message', "Transafer created Successfully, Check your email - ($email) for further instructions");
    }

    public function add_account(Request $request)
    {

        $api_key = env('FLW_SECRET_KEY');

        $users = User::where('id', Auth::id())
            ->first();

        //get banks

        $country = "NG";

        $databody = array(
            "country" => $country,
        );

        $body = json_encode($databody);
        $curl = curl_init();

        $key = env('FLW_SECRET_KEY');
        //"Authorization: $key",
        curl_setopt($curl, CURLOPT_URL, "https://api.flutterwave.com/v3/banks/$country");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: $key",
            )
        );

        $var = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($var);

        $banks = $result->data;

        return view('add-account', compact('users', 'banks'));
    }

    public function add_account_now(Request $request)
    {

        $account_number = $request->account_number;
        $bank = $request->code;

        $code = str_replace(['+', '-'], '', filter_var($bank, FILTER_SANITIZE_NUMBER_INT));
        $bank_name = preg_replace('/\d+/', '', $bank);

        $databody = array(
            "account_number" => $account_number,
            "account_bank" => $code,

        );

        $body = json_encode($databody);
        $curl = curl_init();

        $key = env('FLW_SECRET_KEY');
        //"Authorization: $key",
        curl_setopt($curl, CURLOPT_URL, 'https://api.flutterwave.com/v3/accounts/resolve');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: $key",
            )
        );

        $var = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($var);

        $acc_name = $result->data->account_name;

        if ($result->status == 'success') {

            //update user

            $update = User::where('id', Auth::id())
                ->update([

                    'account_number' => $account_number,
                    'bank_code' => $code,
                    'bank_name' => $bank_name,
                    'bank_name' => $bank_name,
                    'account_name' => $acc_name,

                ]);

            return redirect('/confirmation')->with('message', "$acc_name");
        }
        return back()->with('error', "Account Name is  $result->message");
    }

    public function withdraw_now(Request $request)
    {
        $api_key = env('FLW_SECRET_KEY');

        $user_amount = EMoney::where('user_id', Auth::id())
            ->first()->current_balance;

        $amount = $request->amount;

        $account_number = User::where('id', Auth::id())
            ->first()->account_number;

        $bank_code = User::where('id', Auth::id())
            ->first()->bank_code;

        $ref = Str::random(10);

        if ($user_amount <= $amount) {

            return back()->with('error', 'Insufficient balance, fund your wallet');
        }

        $transfer_pin = $request->pin;

        $getpin = Auth()->user();
        $user_pin = $getpin->pin;

        if (Hash::check($transfer_pin, $user_pin)) {

            $databody = array(
                "account_number" => $account_number,
                "account_bank" => $bank_code,
                "amount" => $amount,
                "narration" => 'Withdrwal from Cardy',
                "currency" => 'NGN',
                "reference" => $ref,
                "debit_currency" => 'NGN',

            );

            $body = json_encode($databody);
            $curl = curl_init();

            $key = env('FLW_SECRET_KEY');
            //"Authorization: $key",
            curl_setopt($curl, CURLOPT_URL, 'https://api.flutterwave.com/v3/transfers');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_ENCODING, '');
            curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
            curl_setopt($curl, CURLOPT_TIMEOUT, 0);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(
                $curl,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                    'Accept: application/json',
                    "Authorization: $key",
                )
            );

            $var = curl_exec($curl);
            curl_close($curl);
            $result = json_decode($var);

            $trans_id = $result->data->id;

            if ($result->status == 'success') {

                //debit

                $charges = Charge::where('title', 'withdrawal')
                    ->first()->amount;

                $new_amount = $charges + $amount;

                $debit = $user_amount - $new_amount;

                $update = EMoney::where('user_id', Auth::id())
                    ->update(['current_balance' => $debit]);

                $transaction = new Transaction();
                $transaction->ref_trans_id = $ref;
                $transaction->user_id = Auth::id();
                $transaction->transaction_type = "Withdrawl";
                $transaction->debit = $amount;
                $transaction->note = "Withdrawal to main account";
                $transaction->transaction_id = $trans_id;
                $transaction->save();

                $transfer = new BankTransfer();
                $transfer->amount = $new_amount;
                $transfer->user_id = Auth::id();
                $transfer->ref_id = $ref;
                $transfer->type = "Withdrawal";
                $transfer->status = 1;
                $transfer->save();

                //Send Email
                $api_key = env('ELASTIC_API');
                $from = env('FROM_API');

                $users = User::where('id', Auth::id())
                    ->first();

                $email = User::where('id', Auth::id())
                    ->first()->email;

                $f_name = User::where('id', Auth::id())
                    ->first()->f_name;

                require_once "vendor/autoload.php";
                $client = new Client([
                    'base_uri' => 'https://api.elasticemail.com',
                ]);

                $res = $client->request('GET', '/v2/email/send', [
                    'query' => [

                        'apikey' => "$api_key",
                        'from' => "$from",
                        'fromName' => 'Cardy',
                        'sender' => "$from",
                        'senderName' => 'Cardy',
                        'subject' => 'Wallet Debited',
                        'to' => "$email",
                        'bodyHtml' => view('debit-notification', compact('f_name', 'new_amount'))->render(),
                        'encodingType' => 0,

                    ],
                ]);

                $body = $res->getBody();
                $array_body = json_decode($body);

                return redirect('/bank-transfer')->with('message', "Transaction Successful");
            }
        }
        return back()->with('error', "Invalid Pin");

        return back()->with('error', "Transaction not successful");
    }

    public function otherbank_transfer_now(Request $request)
    {
        $api_key = env('FLW_SECRET_KEY');

        $user_amount = EMoney::where('user_id', Auth::id())
            ->first()->current_balance;

        $amount = $request->amount;

        $charge = Charge::where('title', 'other-banks')
            ->first()->amount;

        $flw_amount = $amount - $charge;

        $account_number = $request->account_number;
        $bank_code = $request->code;
        $bank_name = $request->bank_name;
        $acc_name = $request->acc_name;

        $ref = Str::random(10);

        $databody = array(
            "account_number" => $account_number,
            "account_bank" => $bank_code,
            "amount" => $flw_amount,
            "narration" => "Transfer to other bank | $acc_name",
            "currency" => 'NGN',
            "reference" => $ref,
            "debit_currency" => 'NGN',

        );

        $body = json_encode($databody);
        $curl = curl_init();

        $key = env('FLW_SECRET_KEY');
        //"Authorization: $key",
        curl_setopt($curl, CURLOPT_URL, 'https://api.flutterwave.com/v3/transfers');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: $key",
            )
        );

        $var = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($var);

        if ($result->status == 'success') {

            $trans_id = $result->data->id;

            //debit
            $debit = $user_amount - $amount;

            $update = EMoney::where('user_id', Auth::id())
                ->update(['current_balance' => $debit]);

            $transaction = new Transaction();
            $transaction->ref_trans_id = $ref;
            $transaction->user_id = Auth::id();
            $transaction->transaction_type = "Withdrawl";
            $transaction->debit = $amount;
            $transaction->note = "Transfer to other bank | $acc_name";
            $transaction->transaction_id = $trans_id;
            $transaction->save();

            $transfer = new BankTransfer();
            $transfer->amount = $amount;
            $transfer->user_id = Auth::id();
            $transfer->ref_id = $ref;
            $transfer->type = "Withdrawal";
            $transfer->status = 1;
            $transfer->save();

            //Send Email
            $api_key = env('ELASTIC_API');
            $from = env('FROM_API');

            $users = User::where('id', Auth::id())
                ->first();

            $email = User::where('id', Auth::id())
                ->first()->email;

            $f_name = User::where('id', Auth::id())
                ->first()->f_name;

            require_once "vendor/autoload.php";
            $client = new Client([
                'base_uri' => 'https://api.elasticemail.com',
            ]);

            $res = $client->request('GET', '/v2/email/send', [
                'query' => [

                    'apikey' => "$api_key",
                    'from' => "$from",
                    'fromName' => 'Cardy',
                    'sender' => "$from",
                    'senderName' => 'Cardy',
                    'subject' => 'Wallet Debited',
                    'to' => "$email",
                    'bodyHtml' => view('otherbank-debit-notification', compact('f_name', 'amount'))->render(),
                    'encodingType' => 0,

                ],
            ]);

            $body = $res->getBody();
            $array_body = json_decode($body);

            return redirect('/bank-transfer')->with('message', "Transaction Successful");
        }

        return back()->with('error', "Transaction not successful");
    }

    public function verify_account_info(Request $request)
    {

        $account_number = $request->account_number;
        $amount = $request->amount;
        $bank = $request->code;
        $transfer_pin = $request->pin;

        $charges = Charge::where('title', 'other-banks')
            ->first()->amount;

        $new_amount = $charges + $amount;

        $code = str_replace(['+', '-'], '', filter_var($bank, FILTER_SANITIZE_NUMBER_INT));
        $bank_name = preg_replace('/\d+/', '', $bank);

        $bank_code = $code;

        $user_wallet = EMoney::where('user_id', Auth::id())
            ->first()->current_balance;

        $own_account_number = Auth::user()->account_number;

        if ($amount > $user_wallet) {
            return back()->with('error', 'Insufficient balance, fund your wallet');
        }

        if ($account_number == $own_account_number) {
            return back()->with('error', 'Use Withdraw to main account section');
        }

        $getpin = Auth()->user();
        $user_pin = $getpin->pin;

        if (Hash::check($transfer_pin, $user_pin)) {

            $databody = array(
                "account_number" => $account_number,
                "account_bank" => $code,

            );

            $body = json_encode($databody);
            $curl = curl_init();

            $key = env('FLW_SECRET_KEY');
            //"Authorization: $key",
            curl_setopt($curl, CURLOPT_URL, 'https://api.flutterwave.com/v3/accounts/resolve');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_ENCODING, '');
            curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
            curl_setopt($curl, CURLOPT_TIMEOUT, 0);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(
                $curl,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                    'Accept: application/json',
                    "Authorization: $key",
                )
            );

            $var = curl_exec($curl);
            curl_close($curl);
            $result = json_decode($var);

            if ($result->status == 'success') {

                $acc_name = $result->data->account_name;

                return view('/confirm-account-before-sending', compact('account_number', 'bank_code', 'bank_name', 'user_wallet', 'new_amount', 'acc_name'))->with('message', "$acc_name");
            }
            return back()->with('error', "Check account details for errors");
        }return back()->with('error', "Invalid Pin");

    }

    public function confirm_account_before_sending(Request $request)
    {
        $user_wallet = EMoney::where('user_id', Auth::id())
            ->first()->current_balance;

        return view('confirm-account-before-sending', compact('user_wallet'));
    }

    public function transfer_money(Request $request)
    {

        dd($request->all());

    }

    public function send_other_bank(Request $request)
    {
        $api_key = env('FLW_SECRET_KEY');

        $user_amount = EMoney::where('user_id', Auth::id())
            ->first()->current_balance;

        $amount = $request->amount;

        $account_number = User::where('id', Auth::id())
            ->first()->account_number;

        $bank_code = User::where('id', Auth::id())
            ->first()->bank_code;

        $ref = Str::random(10);

        if ($user_amount <= $amount) {

            return back()->with('error', 'Insufficient balance, fund your wallet');
        }

        $transfer_pin = $request->pin;

        $getpin = Auth()->user();
        $user_pin = $getpin->pin;

        if (Hash::check($transfer_pin, $user_pin)) {

            $databody = array(
                "account_number" => $account_number,
                "account_bank" => $bank_code,
                "amount" => $amount,
                "narration" => 'Withdrwal from Cardy',
                "currency" => 'NGN',
                "reference" => $ref,
                "debit_currency" => 'NGN',

            );

            $body = json_encode($databody);
            $curl = curl_init();

            $key = env('FLW_SECRET_KEY');
            //"Authorization: $key",
            curl_setopt($curl, CURLOPT_URL, 'https://api.flutterwave.com/v3/transfers');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_ENCODING, '');
            curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
            curl_setopt($curl, CURLOPT_TIMEOUT, 0);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(
                $curl,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                    'Accept: application/json',
                    "Authorization: $key",
                )
            );

            $var = curl_exec($curl);
            curl_close($curl);
            $result = json_decode($var);

            $trans_id = $result->data->id;

            if ($result->status == 'success') {

                //debit

                $charges = Charge::where('title', 'withdrawal')
                    ->first()->amount;

                $new_amount = $charges + $amount;

                $debit = $user_amount - $new_amount;

                $update = EMoney::where('user_id', Auth::id())
                    ->update(['current_balance' => $debit]);

                $transaction = new Transaction();
                $transaction->ref_trans_id = $ref;
                $transaction->user_id = Auth::id();
                $transaction->transaction_type = "Withdrawl";
                $transaction->debit = $amount;
                $transaction->note = "Withdrawal to main account";
                $transaction->transaction_id = $trans_id;
                $transaction->save();

                $transfer = new BankTransfer();
                $transfer->amount = $new_amount;
                $transfer->user_id = Auth::id();
                $transfer->ref_id = $ref;
                $transfer->type = "Withdrawal";
                $transfer->status = 1;
                $transfer->save();

                //Send Email
                $api_key = env('ELASTIC_API');
                $from = env('FROM_API');

                $users = User::where('id', Auth::id())
                    ->first();

                $email = User::where('id', Auth::id())
                    ->first()->email;

                $f_name = User::where('id', Auth::id())
                    ->first()->f_name;

                require_once "vendor/autoload.php";
                $client = new Client([
                    'base_uri' => 'https://api.elasticemail.com',
                ]);

                $res = $client->request('GET', '/v2/email/send', [
                    'query' => [

                        'apikey' => "$api_key",
                        'from' => "$from",
                        'fromName' => 'Cardy',
                        'sender' => "$from",
                        'senderName' => 'Cardy',
                        'subject' => 'Wallet Debited',
                        'to' => "$email",
                        'bodyHtml' => view('debit-notification', compact('f_name', 'new_amount'))->render(),
                        'encodingType' => 0,

                    ],
                ]);

                $body = $res->getBody();
                $array_body = json_decode($body);

                return redirect('/bank-transfer')->with('message', "Transaction Successful");
            }
        }
        return back()->with('error', "Invalid Pin");

        return back()->with('error', "Transaction not successful");
    }

    public function confirmation(Request $request)
    {
        $api_key = env('ELASTIC_API');
        $from = env('FROM_API');

        $users = User::where('id', Auth::id())
            ->first();

        $email = User::where('id', Auth::id())
            ->first()->email;

        $f_name = User::where('id', Auth::id())
            ->first()->f_name;

        require_once "vendor/autoload.php";
        $client = new Client([
            'base_uri' => 'https://api.elasticemail.com',
        ]);

        $res = $client->request('GET', '/v2/email/send', [
            'query' => [

                'apikey' => "$api_key",
                'from' => "$from",
                'fromName' => 'Cardy',
                'sender' => "$from",
                'senderName' => 'Cardy',
                'subject' => 'Account Details Changed',
                'to' => "$email",
                'bodyHtml' => view('account-chnage-confirmation', compact('f_name'))->render(),
                'encodingType' => 0,

            ],
        ]);

        $body = $res->getBody();
        $array_body = json_decode($body);

        return view('confirmation', compact('users'));
    }

    public function profile(Request $request)
    {
        $users = User::where('id', Auth::id())
            ->first();

        $user_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        return view('profile', compact('users', 'user_wallet'));
    }

    public function bank_account(Request $request)
    {
        $users = User::where('id', Auth::id())
            ->first();

        $user_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        return view('bank-account', compact('users', 'user_wallet'));
    }

    public function delete(Request $request)
    {

        $user_id = Auth::id();

        //$user = User::where('id', $id)->firstorfail()->delete();
        $user = User::where('id', $user_id)->delete();

        return redirect('/login')->with('error', 'Account Deleted Successfully');
    }

    public function buy_data_now(Request $request)
    {

        $user_wallet_banlance = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        $userid = env('CKUSER');
        $apikey = env('CKKEY');

        $input = $request->validate([
            'data_bundle' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'pin' => ['required', 'string'],

        ]);

        $data_amount = DataType::where('data_bundle', $request->data_bundle)
            ->first()->amount;

        $recipient_mobilenumber = $request->phone_number;
        $mobilenetwork_code = $request->mobilenetwork_code;

        $amount = $data_amount;

        $callback_url = "https://cardy.enkwave.com";
        $transfer_pin = $request->pin;

        $getpin = Auth()->user();
        $user_pin = $getpin->pin;

        if (Hash::check($transfer_pin, $user_pin)) {

            if ($amount < 100) {
                return back()->with('error', 'Amount must not be less than NGN 100');
            }

            if ($amount <= $user_wallet_banlance) {

                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, "https://www.nellobytesystems.com/APIDatabundleV1.asp?UserID=$userid&APIKey=$apikey&MobileNetwork=$mobilenetwork_code&DataPlan=$amount&MobileNumber=$recipient_mobilenumber&CallBackURL=$callback_url");

                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_ENCODING, '');
                curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
                curl_setopt($curl, CURLOPT_TIMEOUT, 0);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/json',
                        'Accept: application/json',
                    )
                );
                // $final_results = curl_exec($curl);

                $var = curl_exec($curl);
                curl_close($curl);

                $var = json_decode($var);

                if ($var->status == 'INSUFFICIENT_BALANCE') {

                    return back()->with('error', "Sorry!! Unable to Recharge, Please contact our support");
                }

                $debit = $user_wallet_banlance - $order_amount;

                $update = EMoney::where('user_id', Auth::id())
                    ->update([
                        'current_balance' => $debit,
                    ]);

                $transaction = new Transaction();
                $transaction->ref_trans_id = Str::random(10);
                $transaction->user_id = Auth::id();
                $transaction->transaction_type = "cash_out";
                $transaction->debit = $order_amount;
                $transaction->note = "Airtime Purchase to $recipient_mobilenumber";
                $transaction->save();

                return back()->with('message', "Airtime Purchase Successful");
            }
            return back()->with('error', "Insufficnet Funds, Fund your Wallet");
        } else {
            return back()->with('error', 'Invalid Pin');
        }
    }

    public function get_data_bundle(Request $request)
    {
    }

    public function verify_account(Request $request)
    {
        $card = Vcard::all();
        $user = User::all();
        $user_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        return view('verify-account', compact('user', 'user_wallet', 'card'));
    }

    public function verify_account_now(Request $request)
    {

        $user_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        $user = User::all();

        $first_name = Auth::user()->f_name;
        $last_name = Auth::user()->l_name;
        $phone = Auth::user()->phone;

        $input = $request->validate([
            'address_line1' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'lga' => ['required', 'string'],
            'bvn' => ['required', 'string'],

        ]);

        $address_line1 = $request->input('address_line1');
        $city = $request->input('city');
        $state = $request->input('state');
        $lga = $request->input('lga');
        $bvn = $request->input('bvn');

        $databody = array(

            "address" => array(
                "address_line1" => $address_line1,
                "city" => $city,
                "state" => $state,
                "lga" => $lga,
            ),

            "entity" => "INDIVIDUAL",
            "first_name" => $first_name,
            "last_name" => $last_name,
            "phone" => $phone,
            "bvn" => $bvn,
        );

        $mono_api_key = env('MONO_KEY');

        $body = json_encode($databody);
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://api.withmono.com/issuing/v1/accountholders');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Accept: application/json',
                "mono-sec-key: $mono_api_key",
            )
        );
        // $final_results = curl_exec($curl);

        $var = curl_exec($curl);
        curl_close($curl);

        $var = json_decode($var);

        $message = $var->message;

        // $id = $var[0]->id;
        if ($var->status == "successful") {

            User::where('id', Auth::user()->id)
                ->update([
                    'address_line1' => $request->address_line1,
                    'city' => $request->city,
                    'f_name' => $request->f_name,
                    'l_name' => $request->l_name,
                    'm_name' => $request->m_name,
                    'state' => $request->state,
                    'lga' => $request->lga,
                    'bvn' => $request->bvn,
                    'mono_customer_id' => $var->data->id,
                    'is_kyc_verified' => 1,

                ]);
        }
        return back()->with('error', "Verification Failed!! $message");

        Session::flush();
        Auth::logout();

        return redirect('/')->with('message', 'Your account has been succesffly approved.');
    }



    public function forgot_password()
    {

        $users = User::all();

        return view('forgot-password', compact('users'));
    }

    public function forgot_password_send_code(Request $request)
    {

        $api_key = env('ELASTIC_API');
        $from = env('FROM_API');

        $email = $request->email;

        $get_user = User::where('email', $email)->first();

        if ($get_user == null) {

            return back()->with('error', 'Email not found on our system');
        }

        $new_email_code = random_int(100000, 999999);

        $update_code = User::where('email', $email)->update(['email_code' => $new_email_code]);

        $get_code = User::where('email', $email)->first()->email_code;

        $f_name = User::where('email', $email)->first()->f_name;

        require_once "vendor/autoload.php";
        $client = new Client([
            'base_uri' => 'https://api.elasticemail.com',
        ]);

        // The response to get
        $res = $client->request('GET', '/v2/email/send', [
            'query' => [

                'apikey' => "$api_key",
                'from' => "$from",
                'fromName' => 'Cardy',
                'sender' => "$from",
                'senderName' => 'Cardy',
                'subject' => 'Verification Code',
                'to' => "$email",
                'bodyHtml' => view('verification', compact('new_email_code', 'f_name'))->render(),
                'encodingType' => 0,

            ],
        ]);

        $body = $res->getBody();
        $array_body = json_decode($body);

        return redirect('verify-reset-code')->with('message', "Enter the verification code sent to $email");

    }

    public function verify_reset_code()
    {

        return view('verify-reset-code');

    }

    public function reset_password()
    {

        return view('reset-password');
    }

    public function verify_reset_code_now(Request $request)
    {

        $code = $request->code;

        $email = User::where('email_code', $code)
            ->first()->email;

        if ($email == null) {
            return back()->with('error', 'Invalid Code');
        }

        return view('reset-password', compact('email'));

    }

    public function reset_password_now(Request $request)
    {

        $api_key = env('ELASTIC_API');
        $from = env('FROM_API');

        $email = $request->email;



        $input = $request->validate([
            'password' => ['required', 'confirmed', 'string'],
        ]);

        $password = Hash::make($request->password);

        $check_email = User::where('email', $email)->first();

        $f_name = User::where('email', $email)->first()->f_name;

        if ($check_email == null) {

            return back()->with('error', 'Email not found');

        }

        $update_password = User::where('email', $email)
            ->update(['password' => $password]);

        require_once "vendor/autoload.php";
        $client = new Client([
            'base_uri' => 'https://api.elasticemail.com',
        ]);

        // The response to get
        $res = $client->request('GET', '/v2/email/send', [
            'query' => [

                'apikey' => "$api_key",
                'from' => "$from",
                'fromName' => 'Cardy',
                'sender' => "$from",
                'senderName' => 'Cardy',
                'subject' => 'Password Updated',
                'to' => "$email",
                'bodyHtml' => view('reset-password-notification', compact('f_name'))->render(),
                'encodingType' => 0,

            ],
        ]);

        $body = $res->getBody();
        $array_body = json_decode($body);

        return redirect('/')->with('message', 'Your password has been successfully updated');

    }

    public function update_password()
    {
        $user_wallet = EMoney::where('user_id', Auth::id())
            ->first()->current_balance;

        $user = User::all();

        return view('updatepassword', compact('user', 'user_wallet'));
    }

    public function update_password_now(Request $request)
    {
        $user = User::all();
        $input = $request->all();
        $userid = Auth::user()->id;
        //dd($userid);
        $users = User::find($userid);
        $rules = array(
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = array("status" => $this->failedStatus, "message" => $validator->errors()->first());
        } else {
            try {
                if ((Hash::check(request('old_password'), $users->password)) == false) {
                    return back()->with('error', 'Check your old password');
                } else if ((Hash::check(request('new_password'), $users->password)) == true) {
                    return back()->with('error', 'Please enter a password which is not similar then current password');
                } else {
                    User::where('id', $userid)->update(['password' => Hash::make($input['new_password'])]);
                    return back()->with('message', 'Password Updated Successfully');
                }
            } catch (Exception $e) {
                if (isset($e->errorInfo[2])) {
                    $msg = $e->errorInfo[2];
                } else {
                    $msg = $e->getMessage();
                }
                $arr = array("status" => $this->failedStatus, "message" => $msg);
            }
        }
        return back()->with('error', $e);
        //return back()->with('message', 'Password Updated Successfully');
        //return view('updatepassword',compact('user','arr'));
    }

    public function logout()
    {
        Session::flush();

        Auth::logout();

        return redirect('/');
    }

    public function verify_meter(Request $request){





        $userid = env('CKUSER');
        $apikey = env('CKKEY');

        $input = $request->validate([
            // 'eletric_company' => ['required', 'string'],
            // 'meter_type' => ['required', 'string'],
            'meter_number' => ['required', 'string'],
            // 'amount' => ['required', 'string'],
            // 'phone_number' => ['required', 'string'],
            // 'pin' => ['required', 'string'],

        ]);

        $get_eletric_company = $request->eletric_company;
        $meter_type = $request->meter_type;
        $meter_number = $request->meter_number;
        $order_amount = $request->amount;
        $phone_number = $request->phone_number;
        $transfer_pin = $request->pin;


        $eletric_company = str_replace(['+', '-'], '', filter_var($get_eletric_company, FILTER_SANITIZE_NUMBER_INT));
        $get_biller_name = preg_replace('/\d+/','',$get_eletric_company);
        $biller_name = trim($get_biller_name);












        $user_wallet_banlance = EMoney::where('user_id', Auth::user()->id)
        ->first()->current_balance;


        $getpin = Auth()->user();
        $user_pin = $getpin->pin;

        // if (Hash::check($transfer_pin, $user_pin)) {

        //     if ($order_amount < 1000) {
        //         return back()->with('error', 'Amount must not be less than NGN 1000');
        //     }

        //     if ($order_amount <= $user_wallet_banlance) {

                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, "https://www.nellobytesystems.com/APIVerifyElectricityV1.asp?UserID=$userid&APIKey=$apikey&ElectricCompany=$eletric_company&MeterNo=$meter_number");

                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_ENCODING, '');
                curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
                curl_setopt($curl, CURLOPT_TIMEOUT, 0);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/json',
                        'Accept: application/json',
                    )
                );
                // $final_results = curl_exec($curl);

                $var = curl_exec($curl);
                curl_close($curl);

                $var = json_decode($var);

                $customer_name = $var->customer_name;


                if($var-> status == 00){

                    $update = User::where('id', Auth::id())
                    ->update([
                        'meter_number' => $request->meter_number,
                        'eletric_company' => $request->eletric_company
                    ]);

                    return back()->with('mm', "$customer_name");

                }





    //         } return back()->with('error', 'Sorry!! Invalid Pin');


    //     } return back()->with('error', 'Sorry!! Insufficient Balance');


    }



    public function buy_eletricity(){


        $user_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;

        $meter_number = User::where('id', Auth::user()->id)
        ->first()->meter_number ?? null;


        $eletric_company = User::where('id', Auth::user()->id)
        ->first()->eletric_company ?? null;


        $phone = User::where('id', Auth::user()->id)
            ->first()->phone;

        $power = Power::all();







        return view('buy-electricty', compact('user_wallet', 'eletric_company','meter_number','phone', 'power' ));

    }


    public function buy_eletricity_now(Request $request){




        $userid = env('CKUSER');
        $apikey = env('CKKEY');
        $url = 'https://dashboard.cardy4u.com/buy-eletricty';








        $user_wallet_banlance = EMoney::where('user_id', Auth::user()->id)
        ->first()->current_balance;

        $get_eletric_company = $request->eletric_company;
        $meter_type = $request->meter_type;
        $meter_number = $request->meter_number;
        $order_amount = $request->amount;
        $phone_number = $request->phone_number;
        $transfer_pin = $request->pin;

        $eletric_company = str_replace(['+', '-'], '', filter_var($get_eletric_company, FILTER_SANITIZE_NUMBER_INT));
        $get_biller_name = preg_replace('/\d+/','',$get_eletric_company);
        $biller_name = trim($get_biller_name);



        $getpin = Auth()->user();
        $user_pin = $getpin->pin;

        if (Hash::check($transfer_pin, $user_pin)) {

            if ($order_amount < 1000) {
                return back()->with('error', 'Amount must not be less than NGN 1000');
            }

            if ($order_amount <= $user_wallet_banlance) {

                $curl = curl_init();

                curl_setopt_array($curl, array(
                  CURLOPT_URL => "https://www.nellobytesystems.com/APIElectricityV1.asp?UserID=$userid&APIKey=$apikey&ElectricCompany=$eletric_company&MeterType=$meter_type&MeterNo=$meter_number&Amount=$order_amount&PhoneNo=$phone_number&CallBackURL=https://cardy4u.com",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'GET',
                  CURLOPT_HTTPHEADER => array(
                  ),
                ));

                $response = curl_exec($curl);

                $var = curl_exec($curl);
                curl_close($curl);

                $var = json_decode($var);

                $status = $var->status;

                dd($var);



                if($status !== 'ORDER_RECEIVED' ){

                    $databody = array(
                        'country' => "NG",
                        'customer' =>  $meter_number,
                        'amount' => $order_amount,
                        'type' =>  $biller_name,
                        'reference'=> Str::random(10),

                    );

                    $body = json_encode($databody);
                    $curl = curl_init();

                    $key = env('FLW_SECRET_KEY');
                    //"Authorization: $key",
                    curl_setopt($curl, CURLOPT_URL, 'https://api.flutterwave.com/v3/bills');
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_ENCODING, '');
                    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
                    curl_setopt($curl, CURLOPT_TIMEOUT, 0);
                    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt(
                        $curl,
                        CURLOPT_HTTPHEADER,
                        array(
                            'Content-Type: application/json',
                            'Accept: application/json',
                            "Authorization: $key",
                        )
                    );

                    $var = curl_exec($curl);
                    curl_close($curl);
                    $result = json_decode($var);







                }




















                $request_id = "6454722129";


                $client = new \GuzzleHttp\Client();
                $request = $client->get("https://www.nellobytesystems.com/APIQueryV1.asp?UserID=$userid&APIKey=$apikey&OrderID=$request_id");
                $response = $request->getBody();

                $result = json_decode($response);

                $statuscode = $result->statuscode;

                $token = $result->metertoken;

                if($statuscode == 200){

                    $email = User::where('id', Auth::id())
                    ->first()->email;

                    $f_name = User::where('id', Auth::id())
                    ->first()->f_name;


                    $api_key = env('ELASTIC_API');
                    $from = env('FROM_API');

                require_once "vendor/autoload.php";
                $client = new Client([
                    'base_uri' => 'https://api.elasticemail.com',
                ]);

                $res = $client->request('GET', '/v2/email/send', [
                    'query' => [

                        'apikey' => "$api_key",
                        'from' => "$from",
                        'fromName' => 'Cardy',
                        'sender' => "$from",
                        'senderName' => 'Cardy',
                        'subject' => 'Eletricity Token',
                        'to' => "$email",
                        'bodyHtml' => view('token-notification', compact('token', 'f_name'))->render(),
                        'encodingType' => 0,

                    ],
                ]);

                $body = $res->getBody();
                $array_body = json_decode($body);



                return back()->with('message', "Your Meter Token $token has been sent to your email");


                } return back()->with('error', "Failed!! Please try again later");

































                // if($var-> status == 00){

                //     $update = User::where('id', Auth::id())
                //     ->update([
                //         'meter_number' => $request->meter_number,
                //         'eletric_company' => $request->eletric_company
                //     ]);

                //     return back()->with('mm', "$customer_name");

                // }





            } return back()->with('error', 'Sorry!! Insufficient Balance');


        }return back()->with('error', 'Sorry!! Invalid Pin');









    }




    public function cable(){

        $user_wallet = EMoney::where('user_id', Auth::user()->id)
            ->first()->current_balance;


        $client = new \GuzzleHttp\Client();
                $request = $client->get('https://www.nellobytesystems.com/APICableTVPackagesV2.asp');
                $response = $request->getBody();

                $result = json_decode($response);
                dd($result->TV_ID->DStv);

                $cable_company = $result->TV_ID->Dstv;



                return view('cable', compact('cable_company', 'user_wallet'));


    }










}
