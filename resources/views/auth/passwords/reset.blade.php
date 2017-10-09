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

                <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                    {{ csrf_field() }}

                  <input type="hidden" name="token" value="{{ $token }}">
                  <label class="label">Email Address</label>
                  <p class="control">
                    <input id="email" name="email" type="email" class="input" value="{{ $email or old('email') }}" required autofocus>
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
                    <button class="button is-primary">Reset Password</button>
                  </p>

                </form>

            </div>
           
          </div>
        </div>
      </div>
    </div>
</section>

@endsection
