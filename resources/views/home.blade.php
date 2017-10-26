@extends('layouts.app')

@section('content')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

  <!-- START NAV -->
  <nav class="navbar is-white">
    <div class="container">
      <div class="navbar-brand">
        <h1 class="is-size-3">
            <a class="navbar-item brand-text" href="/">
              {{ config('app.name', 'Intranet') }}          
            </a>
        </h1>
      </div>
      
    </div>
  </nav>
  <!-- END NAV -->
  <div class="container">
    <div class="columns">
      <div class="column is-3">
        <aside class="menu">
          <p class="menu-label">
            General
          </p>
          <ul class="menu-list">
            <li><a class="is-active">Dashboard</a></li>
            <li><a>Folder List</a></li>
          </ul>
          <p class="menu-label">
            Administration
          </p>
          <ul class="menu-list">
            <li>
              <a>Folder</a>
              <ul>
                <li><a>New folder</a></li>
                <li><a>Edit folder</a></li>
                <li><a>Delete folder</a></li>
              </ul>
            </li>
            <li>
              <a>Files</a>
              <ul>
                <li><a>Delete files</a></li>
              </ul>
            </li>
            <li>
              <a>Users</a>
              <ul>
                <li><a>Delete users</a></li>
              </ul>
            </li>
          </ul>                
            <a class="button is-warning" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </aside>
      </div>
      <div class="column is-9">
        <nav class="breadcrumb" aria-label="breadcrumbs">
          <ul>
            <li><a href="../">General</a></li>
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
                        <td width="5%"><i class="fa fa-bell-o"></i></td>
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

            <br />

            <div class="card">
              <header class="card-header">
                <p class="card-header-title">
                  Search
                </p>
              </header>
              <div class="card-content">
                <div class="content">
                    <form id="elasticScout" action="/SearchQuery" method="get">
                      <div class="control has-icons-left has-icons-right">
                        <input class="input is-large" name="search" type="text" value="@if(!empty($query)){{ $query }}@endif" placeholder="Search...">
                        <span class="icon is-medium is-left">
                          <i class="fa fa-search"></i>
                        </span>
                      </div>
                    </form>
                </div>
              </div>
            </div>

            @if(!empty($files) && !empty($query))
                <ul>
                @foreach($files as $file)
                    <li><strong><a href="{{ route('download', [ 'filename' => $file->filename ]) }}">{{ $file->filename }}</a></strong>
                    <br />
                    {{ $file->getContentsExcerpt($query) }}
                        </li>
                @endforeach
                </ul>
            @endif

          </div>
        </div>
      </div>
    </div>
  </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
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
