@extends('layouts.app')

@section('content')
    <div class="column is-9">
      <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
          <li><a href="../">Home</a></li>
          <li class="is-active"><a href="#" aria-current="page">Dashboard</a></li>
        </ul>
      </nav>

      @if( Auth::check() )
      <section class="hero is-info welcome is-small">
        <div class="hero-body">
          <div class="container">
            <h1 class="title">
                  Hello, {{ Auth::user()->name }}
            </h1>
            <h2 class="subtitle">
              Your role: 
              @foreach (Auth::user()->roles()->get() as $role)
                  {{ $loop->first ? '' : ', ' }}
                  <span class="nice">{{ $role->name }}</span>
              @endforeach
            </h2>
          </div>
        </div>
      </section>
      @endif
      <section class="info-tiles">
        <div class="tile is-ancestor has-text-centered">
          <div class="tile is-parent">
            <article class="tile is-child box">
              <p class="title">{{ \App\User::all()->count() }}</p>
              <p class="subtitle">Users</p>
            </article>
          </div>
          <div class="tile is-parent">
            <article class="tile is-child box">
              <p class="title">{{ \App\Folder::all()->where('id', '!=', 1)->count() }}</p>
              <p class="subtitle">Folders</p>
            </article>
          </div>
          <div class="tile is-parent">
            <article class="tile is-child box">
              <p class="title">{{ \App\File::all()->count() }}</p>
              <p class="subtitle">Files</p>
            </article>
          </div>
        </div>
      </section>

      <br />

      <div class="columns">
        
        <div class="column is-12">
          <div class="card events-card">
            <header class="card-header">
              <p class="card-header-title">
                Recently Uploaded Files
              </p>
            </header>
            <div class="card-table">
              <div class="content">

                @if(\App\File::all()->count() > 0)
                <table class="table is-striped">
                  <tbody>
                  @foreach (\App\File::all() as $file)
                    <tr>
                      <td width="5%"><i class="fa fa-file-o"></i></td>
                      <td><span style="display: inline"><a href="{{ route('download', [ 'filename' => $file->filename ]) }}">{{ $file->filename }}</a></span></td>
                      <td><a class="button is-small is-warning" href="{{ route('folder', ['folder' => ($file->folder()->first())->id ]) }}"><i class="fa fa-folder"></i> {{ ($file->folder()->first())->name }}</a></td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
                @else
                  <div style="padding:20px">
                    <p>No files yet.</p>
                  </div>
                @endif
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
