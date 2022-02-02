<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>xavier-cauchy.com</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="icon" href="data:,">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <nav class='menu'>
        <x-home-navbar :categories="$categories"/>
    </nav>

    <main>
        <x-home-galery :home="$home" :homeimg="$home_img"/>
    </main>

</body>

<script src='{{asset('js/home.js')}}'></script>
</html>
