@extends('layouts.app')

@section('content')
    <div class="column is-9">
      <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
          <li><a href="../">Home</a></li>
          <li class="is-active"><a href="#" aria-current="page">Folder List</a></li>
        </ul>
      </nav>

      <div class="columns">
        <div class="column is-9">

          <div class="card events-card message is-warning">
            <header class="card-header message-header">
              <p class="card-header-title">
                Folders ({{ Auth::user()->foldersWithAccess()->where('id', '!=', 1)->count() }})
              </p>
            </header>
            <div class="card-table">
              <div class="content">
                @if(Auth::user()->foldersWithAccess()->where('id', '!=', 1)->count() > 0)
                <form action="{{ route('deleteFolders') }}" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                {{ csrf_field() }}
                <table class="table is-fullwidth is-striped">
                  <thead>
                      <tr>
                        <th><input class="checkbox" onClick="toggle(this,'folder[]')" name="checkall" type="checkbox"></th>
                        <th></th>
                        <th>Folder Name</th>
                        <th>Created On</th>
                        <th>Last Updated</th>
                        <th># of Files</th>
                        <th>Description</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach (Auth::user()->foldersWithAccess()->where('id', '!=', 1) as $subfolder)
                      <tr>
                        <td width="5%"><input class="checkbox" name="folder[]" value="{{ $subfolder->id }}" type="checkbox"></td>
                        <td width="5%"><i class="fa fa-folder-o"></i></td>
                        <td><a href="{{ route('folder', [ 'folder' => $subfolder ]) }}">{{ $subfolder->name }}</a></td>
                        <td>{{ $subfolder->created_at }}</td>
                        <td>{{ $subfolder->last_updated }}</td>
                        <td>{{ $subfolder->files()->count() }}</td>
                        <td>{{ $subfolder->description }}</td>
                      </tr>
                    @endforeach

                  </tbody>
                </table>
                @else
                  <div style="padding:20px">
                    <p>N/A</p>
                  </div>
                @endif

                @if(Auth::user()->hasRole("Site Manager"))
                  <div style="padding:20px">
                      <p>
                        <a href="{{ route('folderCreate')}} " class="button is-warning is-small">Create a new folder</a>
                        @if(\App\Folder::all()->where('id', '!=', 1)->count() > 0)
                        <button class="button is-danger is-small" onclick="return confirm('Are you sure you want to delete the selected folders?');">Delete Selected Folders</button>
                        </form>
                        @endif
                      </p>
                  </div>
                @endif

              </div>
            </div>
          </div>
          <br />


          @if(Auth::user()->hasRole("Site Manager"))
          <div class="card events-card">
            <header class="card-header">
              <p class="card-header-title">
                Recycle Bin
              </p>
            </header>
            <div class="card-table">
              <div class="content">
                  @include('folders.files')
              </div>
            </div>
          </div>
          @endif

        </div>


        <div class="column is-3">
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

function toggle(source, name) {
  checkboxes = document.getElementsByName(name);
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>

@endsection
