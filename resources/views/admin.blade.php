<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="icon" href="data:,">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body ondragover="return false">

    <header>
        <h1>XAVIER CAUCHY PHOTOGRAHPHIE</h1>
        <a href='{{route("logout")}}' class='btn' >Log Out</a>
    </header>

    <main>
        <nav class='admin-menu'>
            <x-admin-navbar
                :categories="$categories"
                :lastgaleryorder="$last_category_order"
            />
        </nav>

        <div class='admin-galery'>
            <x-admin-galery :galery="$galery"/>
        </div>
    </main>

</body>

<script src='{{asset('js/admin.js')}}'></script>
</html>
