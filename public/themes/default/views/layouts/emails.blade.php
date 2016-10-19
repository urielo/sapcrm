<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ theme('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ theme('css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ theme('css/email.css') }}">

</head>
<body class="email-body">
<div class="container-fluid">
    @yield('content')
</div>
</body>
</html>