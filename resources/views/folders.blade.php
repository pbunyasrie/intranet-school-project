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
                <table class="table is-fullwidth is-striped">
                  <tbody>

                  @foreach (\App\Folder::all() as $folder)
                    <tr>
                      <td width="5%"><i class="fa fa-folder-o"></i></td>
                      <td><a href="{{ route('folder', [ 'folder' => $folder ]) }}">{{ $folder->name }}</a></td>
                      <td>{{ $folder->description }}</td>
                    </tr>
                  @endforeach
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
