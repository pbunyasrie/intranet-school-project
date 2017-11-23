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

      <p>
        <h1 class="title">{{ $folder->name }}</h1>
        <h2 class="subtitle">{{ $folder->description }}</h2>
        <p>
          <span class="is-size-7">Created on: {{ $folder->created_at }}</span>, 
          <span class="is-size-7">Last updated on: {{ $folder->last_updated }}</span>
        </p>
      </p>
      <div class="columns">
        {{-- Don't allow the deletion of default folder --}}
        @if($folder->id != 1)
          @if(!Auth::user()->hasRole("Surveyor"))
          <div class="column is-2">
            <a href="{{ route('folderEdit', ['folder' => $folder->id]) }}" class="button is-small">Edit this folder</a>
          </div>
          @endif
        @endif
      </div>


      <div class="columns">
        <div class="column is-9">
          <div class="card events-card message is-warning">
            <header class="card-header message-header">
              <p class="card-header-title">
                Files in this folder ({{ $folder->files()->count() }})
              </p>
            </header>
            <div class="card-table">
              <div class="content">
                  @include('folders.files')
              </div>
            </div>
          </div>        
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
function toggle(source,name) {
  checkboxes = document.getElementsByName(name);
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>

@endsection
