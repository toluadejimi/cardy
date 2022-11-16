<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendBulkVerify implements ShouldQueue
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
        $data = User::where('is_kyc_verified', '0')
        ->get();



        $input['subject'] = $this->details['subject'];


        foreach ($data as $key => $value) {
            $input['email'] = $value->email;
            $input['f_name'] = $value->f_name;

            $body = array(
                'f_name' => $input['f_name'],
            );


            \Mail::send('verifyreminder', ["data1" => $body], function($message) use($input){
                $message->to($input['email'], $input['f_name'])
                    ->subject($input['subject']);
            });
        }
    }
}
