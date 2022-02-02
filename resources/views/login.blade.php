<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log In</title>
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <link rel="icon" href="data:,">
</head>
<body>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label class="hidden-label" for="email" :value="__('Email')"></label>

            <input id="email" class='input' type="email" name="email" placeholder="Email..." required />
        </div>

        <div>
            <label class="hidden-label" for="password" :value="__('Password')"></label>

            <input id="password" class='input' type="password" name="password" placeholder="Mot de passe..." required/>
        </div>

        <button class='btn' type='submit'>Log In</button>
    </form>

</body>
</html>

