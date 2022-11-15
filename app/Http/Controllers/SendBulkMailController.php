<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendBulkMailController extends Controller
{
    public function sendUsdPrice(Request $request)
    {
    	$details = [
    		'subject' => 'Cardy Daily Rate'
    	];

    	// send all mail in the queue.
        $job = (new \App\Jobs\SendBulkQueueEmail($details))
            ->delay(
            	now()
            	->addSeconds(2)
            );

        dispatch($job);

        echo "Bulk mail send successfully in the background...";
    }
}
