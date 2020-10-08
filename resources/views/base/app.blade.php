<!doctype html>
<html lang="en">
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
  <link rel="shortcut icon" href="{{ asset('klorofil/assets/images/favicon.png') }}">

  <!-- Datatable css -->
  <link rel="stylesheet" href="{{ asset('css/datatable-bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/datatable-button.css') }}">
  <!-- <link rel="stylesheet" href="{{ asset('css/datatable-jquery.css') }}"> -->
  <link rel="stylesheet" href="{{ asset('sb-admin/css/custom.css') }}">

  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

  @stack('css')
</head>
<body>
  <!-- WRAPPER -->
  <div id="wrapper">

    <!-- NAVBAR -->
    @include('base.layouts.topbar')
    <!-- END NAVBAR -->

    <!-- LEFT SIDEBAR -->
    @include('base.layouts.sidebar')
    <!-- END LEFT SIDEBAR -->

    <!-- MAIN -->
    <div class="main">

      <!-- MAIN CONTENT -->
      <div class="main-content">
        @include('base.layouts.content-heading')
        <div class="container-fluid">
          @include('base.layouts.alert')
          @yield('content')
          @yield('modal')
        </div>
      </div>
      <!-- END RIGHT SIDEBAR -->

    </div>
    <!-- END MAIN -->

    <div class="clearfix"></div>
    
    <!-- footer -->
    @include('base.layouts.footer')
    <!-- end footer -->
  </div>
  <!-- END WRAPPER -->

  <!-- Vendor -->
  <script src="{{ asset('klorofil/assets/js/vendor.min.js') }}"></script>
  <script src="{{ asset('js/datatable.js') }}"></script>
  <script src="{{ asset('js/datatable-button.js') }}"></script>
  <script src="{{ asset('js/datatable-bootstrap.js') }}"></script>
  <script src="{{ asset('js/button-flash.js') }}"></script>
  <script src="{{ asset('js/js-zip.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="{{ asset('js/button-html5.js') }}"></script>
  <script src="{{ asset('js/button-print.js') }}"></script>

  <!-- Sweetalert js -->
  <script src="{{ asset('js/sweetalert.js') }}"></script>

  <!-- App -->
  <script src="{{ asset('klorofil/assets/js/app.min.js') }}"></script>

  @stack('script')
</body>
</html>