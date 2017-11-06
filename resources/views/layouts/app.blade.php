<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Intranet') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.5.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    @if(Auth::user())
		@include('layouts.nav')
		<div class="container">
  			<div class="columns">
				@include('layouts.menu')

				<!-- START CONTENT -->
				@yield('content')
				<!-- END CONTENT -->

				<!-- START FOOTER -->
				@include('layouts.footer')
				@yield('footer_js')
				<!-- END FOOTER -->
		  </div>
		</div>
	@else
		@yield('content')
	@endif

</body>
</html>
