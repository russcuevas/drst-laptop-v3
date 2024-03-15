<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;

class ContactController extends Controller
{
    public function ContactPage()
    {
        return view('page.contact');
    }

    public function SendEmail(Request $request)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       = env('MAIL_HOST');
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USERNAME');
            $mail->Password   = env('MAIL_PASSWORD');
            $mail->SMTPSecure = env('MAIL_ENCRYPTION');
            $mail->Port       = env('MAIL_PORT');

            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $mail->addAddress('russelcuevas0@gmail.com');

            $name = $request->input('name');
            $email = $request->input('email');
            $message = $request->input('message');

            $mail->isHTML(true);
            $mail->Subject = 'Contact Form';
            $mail->Body = "
            <html>
                    <head>
                        <style>
                            /* Inline CSS for email compatibility */
                            body {
                                background-color: #fff;
                                font-family: Arial, sans-serif;
                                margin: 0;
                                padding: 0;
                            }
                            .container {
                                max-width: 600px;
                                margin: 0 auto;
                                background-color: #ffffff;
                                padding: 20px;
                            }
                            .header {
                                background-color: #404040;
                                color: #ffffff;
                                text-align: center;
                                padding: 10px;
                            }
                            .content {
                                padding: 20px;
                            }
                            .footer {
                                background-color: #f5f5f5;
                                text-align: center;
                                padding: 10px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <div class='header'>
                                <h1 style='color: #073186 '>DRST</h1>
                            </div>
                            <div class='content'>
                                <h3>Thank you for contacting us!</h3>
                                <p>Name: $name</p>
                                <p>Email: $email</p>
                                <p>Message: $message</p>
                            </div>
                        </div>
                    </body>
                    </html>
                    ";

            $mail->send();
            return redirect()->route('contactpage')->with('success', 'Thankyou for contacting us!');
        } catch (Exception $e) {
            return redirect()->route('contactpage')->with('error', 'Please try again');
        }
    }
}
