<?php

// namespace App\Exceptions;


// use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
// use Throwable;
// use Log;
// use Mail;
// use App\Mail\ExceptionOccured;

// class Handler extends ExceptionHandler
// {






//     /**
//      * A list of exception types with their corresponding custom log levels.
//      *
//      * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
//      */
//     protected $levels = [
//         //
//     ];

//     /**
//      * A list of the exception types that are not reported.
//      *
//      * @var array<int, class-string<\Throwable>>
//      */
//     protected $dontReport = [
//         //
//     ];

//     /**
//      * A list of the inputs that are never flashed to the session on validation exceptions.
//      *
//      * @var array<int, string>
//      */
//     protected $dontFlash = [
//         'current_password',
//         'password',
//         'password_confirmation',
//     ];

//     /**
//      * Register the exception handling callbacks for the application.
//      *
//      * @return void
//      */
//     public function register()
//     {
//         $this->reportable(function (Throwable $e) {
//             //
//         });
//     }


//     public function sendEmail(Throwable $exception)
//     {
//        try {

//             $content['message'] = $exception->getMessage();
//             $content['file'] = $exception->getFile();
//             $content['line'] = $exception->getLine();
//             $content['trace'] = $exception->getTrace();

//             $content['url'] = request()->url();
//             $content['body'] = request()->all();
//             $content['ip'] = request()->ip();

//             Mail::to('toluadejimi@gmail.com')->send(new ExceptionOccured($content));

//         } catch (Throwable $exception) {
//             Log::error($exception);
//         }
//     }






// }


namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Log;
use Mail;
use App\Mail\ExceptionOccured;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array>

     */
    protected $dontReport = [

    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array

     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            $this->sendEmail($e);
        });
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function sendEmail(Throwable $exception)
    {
       try {

            $content['message'] = $exception->getMessage();
            $content['file'] = $exception->getFile();
            $content['line'] = $exception->getLine();
            $content['trace'] = $exception->getTrace();

            $content['url'] = request()->url();
            $content['body'] = request()->all();
            $content['ip'] = request()->ip();

            Mail::to('toluadejimi@gmail.com')->send(new ExceptionOccured($content));

        } catch (Throwable $exception) {
            Log::error($exception);
        }
    }
}
