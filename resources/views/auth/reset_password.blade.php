<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            color: #212529;
        }

        p {
            line-height: 1.6;
            color: #333;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .reset-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #100d68;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
    <title>Reset Password</title>
</head>

<body>
    <div class="container">
        <h1>Reset Your Password</h1>
        <p>Hey Mr./Ms. {{ $fullname }},</p>
        <p>You are receiving this email because we received a password reset request for your account.</p>
        <p><strong>Reset your password:</strong></p>
        <p><a style="color: white" class="reset-button" href="{{ $resetLink }}">Click here</a></p>
        <p>If you did not request a password reset, no further action is required.</p>
    </div>
</body>

</html>