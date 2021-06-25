<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta name="description" content="ChargeMod EV Charging Stations">
<meta name="author" content="">

<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE,PATCH,OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
?>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title') | {{ config('app.name') }}</title>

<link rel="apple-touch-icon" href="{{ asset('/assets/images/apple-touch-icon.png', config('app.asset_secure')) }}">
<link rel="shortcut icon" href="{{ asset('/assets/images/favicon.ico', config('app.asset_secure')) }}">



<!-- Stylesheets -->
<link rel="stylesheet" href="{{ asset('/assets/css/bootstrap.min.css', config('app.asset_secure')) }}">
<link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-extend.min.css', config('app.asset_secure')) }}">
<link rel="stylesheet" href="{{ asset('/assets/css/site.min.css', config('app.asset_secure')) }}">
<link rel="stylesheet" href="{{ asset('/assets/skins/orange.min.css ', config('app.asset_secure')) }}">
<link rel="stylesheet" href="{{ asset('/css/jquery.datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('/css/msc-style.css') }}">


<!-- Plugins -->
@section('css_vendor')
<link rel="stylesheet" href="{{ asset('/assets/vendor/animsition/animsition.css', config('app.asset_secure')) }}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/asscrollable/asScrollable.css', config('app.asset_secure')) }}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/switchery/switchery.css', config('app.asset_secure')) }}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/intro-js/introjs.css', config('app.asset_secure')) }}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/slidepanel/slidePanel.css', config('app.asset_secure')) }}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/flag-icon-css/flag-icon.css', config('app.asset_secure')) }}">

<link rel="stylesheet" href="{{ asset('/assets/vendor/datatables.net-bs4/dataTables.bootstrap4.css', config('app.asset_secure')) }}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css', config('app.asset_secure')) }}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/datatables.net-fixedcolumns-bs4/dataTables.fixedcolumns.bootstrap4.css', config('app.asset_secure')) }}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/datatables.net-rowgroup-bs4/dataTables.rowgroup.bootstrap4.css', config('app.asset_secure')) }}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css', config('app.asset_secure')) }}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/datatables.net-select-bs4/dataTables.select.bootstrap4.css', config('app.asset_secure')) }}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css', config('app.asset_secure')) }}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/datatables.net-buttons-bs4/dataTables.buttons.bootstrap4.css', config('app.asset_secure')) }}">

<link rel="stylesheet" href="{{ asset('/assets/vendor/toastr/toastr.css', config('app.asset_secure')) }}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/select2/select2.min.css', config('app.asset_secure')) }}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/ladda/ladda.min.css', config('app.asset_secure')) }}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/alertify/alertify.css', config('app.asset_secure')) }}">
<link rel="stylesheet" href="{{ asset('/assets/vendor/bootstrap-datepicker/bootstrap-datepicker.css', config('app.asset_secure')) }}">
@show
@stack('css')

<!-- Fonts -->
@section('fonts')
<link rel="stylesheet" href="{{ asset('/assets/fonts/web-icons/web-icons.min.css', config('app.asset_secure')) }}">
<link rel="stylesheet" href="{{ asset('/assets/fonts/font-awesome/font-awesome.min.css', config('app.asset_secure')) }}">
<link rel="stylesheet" href="{{ asset('/assets/fonts/brand-icons/brand-icons.min.css', config('app.asset_secure')) }}">
<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css"> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
<link rel="stylesheet" href="{{ asset('/assets/fonts/web-icons/web-icons.min.css', config('app.asset_secure')) }}">


@show
{{-- <script src='https://cdnjs.com/libraries/Chart.js'></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>

<!--[if lt IE 9]>
<script src="{{ asset('/vendor/html5shiv/html5shiv.min.js', config('app.asset_secure')) }}"></script>


<![endif]-->

<!--[if lt IE 10]>
<script src="{{ asset('/vendor/media-match/media.match.min.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/vendor/respond/respond.min.js', config('app.asset_secure')) }}"></script>
<![endif]-->

<!-- Scripts -->
<script src="{{ asset('/assets/vendor/breakpoints/breakpoints.js', config('app.asset_secure')) }}"></script>

{{-- <script type="text/javascript" src="{{ asset('../remote.js', config('app.asset_secure')) }}"></script> --}}
{{-- <script type="text/javascript" src="../../../../remote.js"></script> --}}

<script>
  Breakpoints();
</script>
