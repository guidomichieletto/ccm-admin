<!DOCTYPE html>
<html lang="it">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ $GLOBALS['basePath'] }}static/css/tabler.min.css">
    <link rel="stylesheet" href="{{ $GLOBALS['basePath'] }}static/css/tabler-vendors.min.css">

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <title>@yield('title') | CCM</title>
  </head>
  @yield('content')
  <script src="{{ $GLOBALS['basePath'] }}static/js/tabler.min.js"></script>
  <script src="{{ $GLOBALS['basePath'] }}static/js/tom-select.base.min.js"></script>
  <script src="{{ $GLOBALS['basePath'] }}static/js/theme.min.js"></script>
</html>