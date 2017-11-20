@extends('layouts.app')

@section('content')
    <div class="column is-9">
      <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
          <li><a href="../">Home</a></li>
          <li class="is-active"><a href="#" aria-current="page">Folder Management</a></li>
        </ul>
      </nav>

  
      <section class="info-tiles">

          <div class="card">
            <header class="card-header">
              <p class="card-header-title">
                Folder Administration
              </p>
            </header>
            <div class="card-content">
              <div class="content">
                  
                @if(\App\Folder::all()->where('id', '!=', 1)->count() > 0)
                <table class="table is-fullwidth is-striped">
                  <thead>
                      <tr>
                        <th><input class="checkbox" onClick="toggle(this,'folder')" name="checkall" type="checkbox"></th>
                        <th></th>
                        <th>Folder Name</th>
                        <th># of Files</th>
                        <th>Created On</th>
                        <th>Last Updated</th>
                        <th>Description</th>
                        <th>User Access</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach (\App\Folder::all()->where('id', '!=', 1) as $folder)
                      <tr>
                        <td width="5%"><input class="checkbox" name="folder" value="{{ $folder->id }}" type="checkbox"></td>
                        <td width="5%"><i class="fa fa-folder-o"></i></td>
                        <td><a href="{{ route('folder', ['folder' => $folder->id]) }}">{{ $folder->name }}</a></td>
                        <td>{{ $folder->files()->count() }}</td>
                        <td>{{ $folder->created_at }}</td>
                        <td>{{ $folder->last_updated }}</td>
                        <td>{{ $folder->description }}</td>
                        <td><a class="button is-small is-warning" href="{{ route('adminFoldersAccess', ['folder' => $folder->id])}}">Manage user access</a></td>
                      </tr>
                    @endforeach

                  </tbody>
                </table>

                <button class="button is-danger is-small" onclick="return confirm('Are you sure you want to delete the selected users?');">Delete Selected Folders</button>

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
