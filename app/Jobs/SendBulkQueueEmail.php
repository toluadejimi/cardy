<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Charge;

use Mail;

class SendBulkQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    public $timeout = 7200; // 2 hours

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = User::where('identity', '1')
        ->get();

        $usd_rate = Charge::where('title', 'rate')
        ->first()->amount;

        // $body = array(
        //     'rate' => $usd_rate,
        // );



        $input['subject'] = $this->details['subject'];


        foreach ($data as $key => $value) {
            $input['email'] = $value->email;
            $input['f_name'] = $value->f_name;

            $body = array(
                'rate' => $usd_rate,
                'f_name' => $input['f_name'],
            );


            \Mail::send('ratemail', ["data1" => $body], function($message) use($input){
                $message->to($input['email'], $input['f_name'])
                    ->subject($input['subject']);
            });
        }
    }
}
