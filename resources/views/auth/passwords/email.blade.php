@extends('layouts.app')

@section('content')
<section class="hero is-fullheight is-dark is-bold">
    <div class="hero-body">
      <div class="container">
        <div class="columns is-vcentered">
          <div class="column is-4 is-offset-4">
            <h1 class="title has-text-centered">
              {{ config('app.name', 'Intranet') }} Reset Password
            </h1>
            <div class="box">

                @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                @endif

                <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}

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
                  
                  <p class="control has-text-centered">
                    <button class="button is-primary">Send Password Reset Link</button>
                  </p>

                </form>

            </div>
            <p class="has-text-centered">
              <a href="{{ route('login') }}">Login</a>
              | 
              <a class="btn btn-link" href="{{ route('password.request') }}">Forgot Your Password?</a>
            </p>
            </p>
          </div>
        </div>
      </div>
    </div>
</section>

@endsection
