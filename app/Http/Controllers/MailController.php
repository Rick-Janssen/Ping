<?php

namespace App\Http\Controllers;

use Exception;
use App\Mail\MailNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail(Request $request)
    {
        $data = [
            'subject' => '',
            'body' => '',
        ];

        try {
            if($request->input('email') != null) {
                Mail::to($request->input('email'))->send(new MailNotify($data));
            
            $response = <<<JS
                <script>
                    setTimeout(function() {
                        window.location.href = '/';
                    }, 5);
                </script>
JS;

            return response($response, 200)->header('Content-Type', 'text/html');
            }
            else{
                return back()->withErrors(['email' => 'The email field is required.'])->onlyInput('email');
            }

        } catch (Exception $th) {
            return response('Sorry, something went wrong<br>'.$th, 500);
        }
    }
}
