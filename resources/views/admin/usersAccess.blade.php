@extends('layouts.app')

@section('content')
    <div class="column is-9">
      <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
          <li><a href="../">Home</a></li>
          <li><a href="{{ route('adminUsers') }}" aria-current="page">Users (Administration)</a></li>
          <li class="is-active"><a href="#" aria-current="page">{{ $user->name }}</a></li>
        </ul>
      </nav>

      <p>
        <h1 class="title">{{ $user->name }} ({{ $user->roles()->first()->name }})</h1>
        <h2 class="subtitle">{{ $user->email }}</h2>
      </p>

      <section class="info-tiles">
          <div class="card">
            <header class="card-header">
              <p class="card-header-title">
                Folders that the user currently has access to
              </p>
            </header>
            <div class="card-content">
              <div class="content">
                  
                @if(\App\Folder::all()->where('id', '!=', 1)->count() > 1)
                <table class="table is-fullwidth is-striped">
                 <thead>
                      <tr>
                        <th><input class="checkbox" onClick="toggle(this,'folder')" name="checkall" type="checkbox"></th>
                        <th></th>
                        <th>Folder Name</th>
                        <th>Description</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach (\App\Folder::all()->where('id', '!=', 1) as $folder)
                      <tr>
                        <td width="5%"><input class="checkbox" name="folder" value="{{ $folder->id }}" type="checkbox"></td>
                        <td width="5%"><i class="fa fa-folder-o"></i></td>
                        <td>{{ $folder->name }}</td>
                        <td>{{ $folder->description }}</td>
                      </tr>
                    @endforeach

                  </tbody>
                </table>

                <button class="button is-danger is-small" onclick="return confirm('Are you sure you want to revoke access from the selected folders?');">Revoke access from selected folders</button>

                @else
                  <p>No folders yet.</p>
                @endif

              </div>
            </div>
          </div>

          <br />

          <div class="card">
            <header class="card-header">
              <p class="card-header-title">
                Folders that the user currently doesn't have access to
              </p>
            </header>
            <div class="card-content">
              <div class="content">
                  
                @if(\App\Folder::all()->where('id', '!=', 1)->count() > 1)
                <table class="table is-fullwidth is-striped">
                 <thead>
                      <tr>
                        <th><input class="checkbox" onClick="toggle(this,'folder')" name="checkall" type="checkbox"></th>
                        <th></th>
                        <th>Folder Name</th>
                        <th>Description</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach (\App\Folder::all()->where('id', '!=', 1) as $folder)
                      <tr>
                        <td width="5%"><input class="checkbox" name="folder" value="{{ $folder->id }}" type="checkbox"></td>
                        <td width="5%"><i class="fa fa-folder-o"></i></td>
                        <td>{{ $folder->name }}</td>
                        <td>{{ $folder->description }}</td>
                      </tr>
                    @endforeach

                  </tbody>
                </table>

                <button class="button is-info is-small" onclick="return confirm('Are you sure you want to give access to the selected folders?');">Give access to selected folders</button>

                @else
                  <p>No folders yet.</p>
                @endif

              </div>
            </div>
          </div>



      </section>

      <br />



@endsection


@section('footer_js')
<script>
  function toggle(source, name) {
  checkboxes = document.getElementsByName(name);
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>
@endsection
