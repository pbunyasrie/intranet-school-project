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


  <link rel="stylesheet"
        href="https://cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.css">


</head>
<body>

    @if(Auth::user())
    
		<div class="container">
			<div class="columns">
			    <div class="column is-8">
					@include('layouts.nav')
			    </div>
			    <div class="column is-4">
      				@include('layouts.search')
			    </div>
		 	</div>
		 </div>
	     <br />


		@if (session('status'))
		<div class="container">
			<div class="columns">
			    <div class="column is-3">

			    </div>
			    <div class="column is-9">
					    <div class="alert alert-success">
					        <strong>{{ session('status') }}</strong>
					    </div>
			    </div>
		 	</div>
		 </div>
	     <br />
		@endif
				

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
