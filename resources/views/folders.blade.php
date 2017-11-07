@extends('layouts.app')

@section('content')
    <div class="column is-9">
      <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
          <li><a href="../">Home</a></li>
          <li class="is-active"><a href="#" aria-current="page">Folder List</a></li>
        </ul>
      </nav>

  
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
                Folder List
              </p>
            </header>
            <div class="card-table">
              <div class="content">

                @if(\App\Folder::all()->count() > 1)
                <header class="card-header">
                  <a href="{{ route('folderCreate')}} " class="card-footer-item">Create a folder</a>
                </header>
                <table class="table is-fullwidth is-striped">
                  <tbody>
                      <tr>
                        <td></td>
                        <td>Folder Name</td>
                        <td>Description</td>
                      </tr>
                    @foreach (\App\Folder::all()->where('id', '!=', 1) as $subfolder)
                      <tr>
                        <td width="5%"><i class="fa fa-folder-o"></i></td>
                        <td><a href="{{ route('folder', [ 'folder' => $subfolder ]) }}">{{ $subfolder->name }}</a></td>
                        <td>{{ $subfolder->description }}</td>
                      </tr>
                    @endforeach

                  </tbody>
                </table>
                @else
                  <p>No folders yet.</p>
                @endif

                <br />

                <footer class="card-footer">
                  <a href="{{ route('folderCreate')}} " class="card-footer-item">Create a folder</a>
                </footer>

              </div>
            </div>
          </div>
          <br />

          <div class="card events-card">
            <header class="card-header">
              <p class="card-header-title">
                Files not in a folder
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

    <br />


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
