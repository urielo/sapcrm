<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seguro AUTOPRATICO</title>

    <link rel="stylesheet" href="{{ theme('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ theme('css/bootstrap-theme.min.css') }}">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ theme('css/pdf.css') }}">
    <script src="{{ theme('js/jquery.js') }}"></script>
    <script src="{{ theme('js/bootstrap.min.js') }}"></script>
    {{--<script src="{{ theme('js/script.js') }}"></script>--}}
    @yield('script')


</head>

<body>
<div class="container-fluid">
    @yield('content')
</div>

</body>
</html>