@extends('layouts.app')

@section('content')
    <div class="column is-9">
      <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
          <li><a href="../">Home</a></li>
          <li><a href="{{ route('folders') }}" aria-current="page">Folder List</a></li>
          <li class="is-active"><a href="#" aria-current="page">Create Folder</a></li>
        </ul>
      </nav>

      <br /><br />

      <section class="info-tiles">

          <div class="card">
            <header class="card-header">
              <p class="card-header-title">
                Create folder
              </p>
            </header>
            <div class="card-content">
              <div class="content">
                  <form action="{{ route('folderStore') }}" method="post">
                    {{ csrf_field() }}
                    Folder name:<br>
                    <input type="text" class="input" style="width: 30%" name="name"><br>
                    Description:<br>
                    <input type="text" class="input" style="width: 30%" name="description">
                    <br /><br />
                    <button class="button is-primary">Create</button>
                  </form>
              </div>
            </div>
          </div>
      </section>

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
