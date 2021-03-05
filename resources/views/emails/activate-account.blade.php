<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Activate Account</title>

    </head>
    <body>
        <p>
            Hi {{$first_name}},<br/>

            <br/>

            Follow this link to activate your account: <a href="{{$activation_url}}">{{$activation_url}}</a>.<br/>

            <br/>

            Kind regards,<br/>
            {{config('app.name')}} Team
        </p>
    </body>
</html>
