@extends('layouts.app')

@section('content')
    <div class="column is-9">
      <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
          <li><a href="../">Home</a></li>
          <li class="is-active"><a href="#" aria-current="page">Help</a></li>
        </ul>
      </nav>

  
      <section class="info-tiles">

          <div class="card">
            <header class="card-header">
              <p class="card-header-title">
                Help
              </p>
            </header>
            <div class="card-content">
              <div class="content">
                  Need help? Please contact one of the site managers below:

                  <ul>
                  @foreach (\App\User::getUsersByRole("Site Manager") as $sitemanager)

                  <li>{{ $sitemanager->name }} - <a href="mailto:{{ $sitemanager->email }}">{{ $sitemanager->email }}</a></li>

                  @endforeach
                  </ul>
              </div>
            </div>
          </div>
      </section>

      <br />



@endsection


@section('footer_js')

@endsection
