<!doctype html>
<html lang="en" class="fullscreen-bg">
<head>
  <title>{{ env('APP_NAME') }}</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <!-- App css -->
  <link href="{{ asset('klorofil/assets/css/bootstrap-custom.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('klorofil/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">

  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('klorifil/assets/images/favicon.png') }}">
</head>
<body>
  <!-- WRAPPER -->
  @yield('content')
  <!-- END WRAPPER -->
</body>
</html>