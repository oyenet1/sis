<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Styles -->
	<link rel="stylesheet" href="{{ mix('css/app.css') }}">

	@livewireStyles

	<!-- Scripts -->
	<script src="{{ mix('js/app.js') }}" defer></script>
	<title>@yield('title', 'SMS Authentication')</title>

	<link rel="stylesheet" href="/assets/css/style.css">
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/site.webmanifest">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">

	<style>
		[x-cloak] {
			display: none !important;
		}
	</style>
</head>

<body class="relative flex justify-around w-full h-screen bg-white font-fira">
	@yield('content')
	@livewireScripts
</body>

</html>
