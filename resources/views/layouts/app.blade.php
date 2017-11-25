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
    <style>
    	@media screen and (min-width: 1024px){
    		.navbar, .navbar-end, .navbar-menu, .navbar-start {
    			display: block
    		}
    	}
    	.navbar-burger{
    		margin-right:auto;
    		margin-left:0px;
    	}
	</style>

  	<link rel="stylesheet"
        href="https://cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.css">


</head>
<body>

    @if(Auth::user())
    
		<div class="container">
			<div class="columns">
			    <div class="column is-7">
					@include('layouts.nav')
			    </div>
			    <div class="column is-5">
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
  			<div class="columns is-desktop">
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

<script>
	// For the mobile menu
document.addEventListener('DOMContentLoaded', function () {

  // Get all "navbar-burger" elements
  var $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

  // Check if there are any nav burgers
  if ($navbarBurgers.length > 0) {

    // Add a click event on each of them
    $navbarBurgers.forEach(function ($el) {
      $el.addEventListener('click', function () {

        // Get the target from the "data-target" attribute
        var target = $el.dataset.target;
        var $target = document.getElementById(target);

        // Toggle the class on both the "navbar-burger" and the "navbar-menu"
        $el.classList.toggle('is-active');
        $target.classList.toggle('is-active');

      });
    });
  }

});
</script>
</body>
</html>
