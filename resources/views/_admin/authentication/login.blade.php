<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | {{config('app.name')}} </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=yes">
    <link rel="icon" href="{{URL::to('/assets/_admin/')}}/img/favicon/red-tutorial.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/assets/css/bundle.min.css?v=7">
</head>
<body id="admin_authentication" >

    <main class="container f-box-display" >
        <section class="row">
            <h1>Welcome</h1>

            <div class="img-container">
                <img class="user-img" src="/assets/img/user_placeholderw150h150.png" alt="User Image">
            </div>
            @if ($errors->any())
                <div >
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        @foreach ($errors->all(':message') as $message)
                            {{ $message }}
                        @endforeach
                    </div>
                </div>
            @endif
            <form action="{{config('app.admin_route')}}/login" id="login_form" method="POST">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="input-container input-container_username">
                    <input type="text" name="email" placeholder="Email address" autocomplete="off" >
                </div>
                <div class="input-container">
                    <input type="password" name="password" placeholder="Password" autocomplete="off">
                </div>

                <button class="submit">Login</button>
            </form>
        </section>

    </main>

</body>
</html>