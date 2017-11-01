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
              Your role: {{ Auth::user()->roles()->get()[0]->name }}
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
              <p class="title">{{ \App\Folder::all()->count() }}</p>
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

      <div class="columns">
        <div class="column is-6">
          <div class="card events-card">
            <header class="card-header">
              <p class="card-header-title">
                Recently Uploaded Files
              </p>
              <a href="#" class="card-header-icon" aria-label="more options">
                <span class="icon">
                  <i class="fa fa-angle-down" aria-hidden="true"></i>
                </span>
              </a>
            </header>
            <div class="card-table">
              <div class="content">
                <table class="table is-fullwidth is-striped">
                  <tbody>

                  @foreach (\App\File::all() as $file)
                    <tr>
                      <td width="5%"><i class="fa fa-file-o"></i></td>
                      <td><a href="{{ route('download', [ 'filename' => $file->filename ]) }}">{{ $file->filename }}</a></td>
                      <td><a class="button is-small is-primary" href="#">Action</a></td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <footer class="card-footer">
              <a href="#" class="card-footer-item">View All</a>
            </footer>
          </div>        
        </div>
        <div class="column is-6">

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
                  <form action="/upload" method="post" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      Files (can attach more than one):
                      <br />
                      <div class="file is-boxed has-name">
                        <label class="file-label">
                          <input class="file-input" id="file" type="file" name="files[]" multiple />
                          <span class="file-cta">
                            <span class="file-icon">
                              <i class="fa fa-upload"></i>
                            </span>
                            <span class="file-label">
                              Choose a file…
                            </span>
                          </span>
                        <span id="filename" class="file-name">
                         
                        </span>
                        </label>
                      </div>
                      <br /><br />
                      <button class="button is-primary">Upload</button>
                  </form>
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
