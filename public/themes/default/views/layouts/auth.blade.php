<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') &mdash; Seguro Auto Pratico</title>
    <link rel="stylesheet" href="{{ theme('css/backend.css') }}">
    <link rel="stylesheet" href="{{ theme('css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ theme('css/datepicker.css') }}">
    <link rel="stylesheet" href="{{ theme('css/sidebar.css') }}">
<body>

<div class="container">

    @yield('content')

</div>


<script src="{{ theme('js/jquery.js') }}"></script>
<script src="{{ theme('js/jquery-ui.js') }}"></script>
<script src="{{ theme('js/bootstrap.min.js') }}"></script>
<script src="{{ theme('js/bootstrap-datepicker.js') }}"></script>
<script src="{{ theme('js/bootstrap-validation.min.js') }}"></script>
<script src="{{ theme('js/cpfcpnj-validator.js') }}"></script>
<script src="{{ theme('js/locales/datepicker-ptbr.js') }}"></script>
<script src="{{ theme('js/maskedinput.min.js') }}"></script>
<script src="{{ theme('js/script.js') }}"></script>
</body>
</html>