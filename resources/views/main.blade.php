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
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
	<!-- Main View -->
	<div class="main-view no-opacity" ng-controller="formController as vm" ng-init="vm.show()" id="main">
		<md-content flex layout="column" layout-align="center center" class="full-height-min dirty-white">
			<a href="/" layout="row" layout-align="center center" layout-padding class="site-logo">
				<img src="/img/2Color-Favicon_512x512-1.png" alt="Personiv Logo">
			</a>
			<h1 class="weight-100">{{ config('app.name', 'Laravel') }}</h1>
			<br>
			@if (count($errors) > 0)
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif
			@yield('content')
		</md-content>
	</div>
	<!-- Vendor Scripts -->
	<script src="/js/vendor.js"></script>
	<!-- Shared Scripts -->
	<script src="/js/auth.js"></script>
</body>
</html>