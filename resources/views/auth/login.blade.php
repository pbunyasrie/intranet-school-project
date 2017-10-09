@extends('layouts.app')

@section('content')
  <section class="hero is-fullheight is-dark is-bold">
    <div class="hero-body">
      <div class="container">
        <div class="columns is-vcentered">
          <div class="column is-4 is-offset-4">
            <h1 class="title has-text-centered">
              {{ config('app.name', 'Intranet') }} Login
            </h1>
            <div class="box">

                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                  <label class="label">Email Address</label>
                  <p class="control">
                    <input id="email" name="email" type="email" class="input" value="{{ old('email') }}" required autofocus>
                     @if ($errors->has('email'))
                        <span class="help-block has-text-danger">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                  </p>
                  <hr>
                  <label class="label">Password</label>
                  <p class="control">
                    <input id="password" name="password" class="input" type="password" required>
                    @if ($errors->has('password'))
                        <span class="help-block has-text-danger">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                  </p>

                  <hr />
                  
                  <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                  <p class="control has-text-centered">
                    <button class="button is-primary">Login</button>
                  </p>

                </form>

            </div>
            <p class="has-text-centered">
              <a href="{{ route('register') }}">Register</a>
              | 
              <a class="btn btn-link" href="{{ route('password.request') }}">Forgot Your Password?</a>
            </p>
          </div>
        </div>
      </div>
    </div>

  </section>
@endsection
