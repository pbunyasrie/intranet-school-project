@extends('layouts.app')

@section('content')
    <div class="column is-9">
      <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
          <li><a href="../">Home</a></li>
          <li><a href="{{ route('folders') }}" aria-current="page">Folder List</a></li>
          <li class="is-active"><a href="#" aria-current="page">{{ $folder->name }}</a></li>
        </ul>
      </nav>

      <strong>Description: {{ $folder->description }}</strong>
      <br /><br />

      <section class="info-tiles">

          <div class="card">
            <header class="card-header">
              <p class="card-header-title">
                Upload files
              </p>
            </header>
            <div class="card-content">
              <div class="content">
                  @if (count($errors) > 0)
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  @endif
                  @include('upload.form')
              </div>
            </div>
          </div>
      </section>

      <br />

      <div class="columns">
        <div class="column is-12">
          <div class="card events-card">
            <header class="card-header">
              <p class="card-header-title">
                Files in this folder
              </p>
            </header>
            <div class="card-table">
              <div class="content">
                <table class="table is-fullwidth is-striped">
                  <tbody>
                  @include('folders.files')
                  </tbody>
                </table>
              </div>
            </div>
          </div>        
        </div>
      </div>
    </div>

@endsection


@section('footer_js')

<!-- For uploading files -->
<script>
var file = document.getElementById("file");
file.onchange = function(){
    if(file.files.length > 0)
    {

      document.getElementById('filename').innerHTML =  file.files[0].name;

    }
};
</script>

@endsection
