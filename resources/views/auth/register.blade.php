@extends('layouts.app')

@section('content')
<section class="hero is-fullheight is-dark is-bold">
    <div class="hero-body">
      <div class="container">
        <div class="columns is-vcentered">
          <div class="column is-4 is-offset-4">
            <h1 class="title has-text-centered">
              {{ config('app.name', 'Intranet') }} Register
            </h1>
            <div class="box">

                <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                  <label class="label">Name</label>
                  <p class="control">
                    <input id="name" name="name" type="text" class="input" value="{{ old('name') }}" required autofocus>
                     @if ($errors->has('name'))
                        <span class="help-block has-text-danger">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                  </p>

                  <label class="label">Email Address</label>
                  <p class="control">
                    <input id="email" name="email" type="email" class="input" value="{{ old('email') }}" required>
                     @if ($errors->has('email'))
                        <span class="help-block has-text-danger">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                  </p>
                  <hr>

                    @if ($errors->has('password'))
                        <span class="help-block has-text-danger">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                  <label class="label">Password</label>
                  <p class="control">
                    <input id="password" name="password" class="input" type="password" required>
                  </p>
                  <label class="label">Confirm Password</label>
                  <p class="control">
                    <input id="password-confirm" name="password_confirmation" class="input" type="password" required>
                  </p>

                  <hr />
                  
                  <p class="control has-text-centered">
                    <button class="button is-primary">Register</button>
                  </p>

                </form>

            </div>
            <p class="has-text-centered">
              <a href="{{ route('login') }}">Login</a>
              | 
              <a class="btn btn-link" href="{{ route('password.request') }}">Forgot Your Password?</a>
            </p>
          </div>
        </div>
      </div>
    </div>
</section>

@endsection
