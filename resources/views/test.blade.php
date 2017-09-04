<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" ng-app="auth">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
	<!-- Favicon -->
    <link rel="shortcut icon" href="/img/ezpayplus.png">

	<!-- Laravel Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<!-- Goolge Fonts Roboto -->
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>
	<!-- Vendor CSS -->
	<link rel="stylesheet" href="/css/vendor.css">
	<!-- Application CSS -->
	<link rel="stylesheet" href="/css/application.css">

	<!-- Scripts -->

</head>
<body>
	
	<!-- Vendor Scripts -->
	<script src="/js/vendor.js"></script>
  <script>
      window.Laravel = {!! json_encode([
          'csrfToken' => csrf_token(),
      ]) !!};

  </script>
</body>
</html>
