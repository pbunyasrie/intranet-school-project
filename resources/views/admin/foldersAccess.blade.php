@extends('layouts.app')

@section('content')
    <div class="column is-9">
      <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
          <li><a href="../">Home</a></li>
          <li><a href="{{ route('adminFolders') }}" aria-current="page">Folder Management</a></li>
          <li class="is-active"><a href="#" aria-current="page">{{ $folder->name }}</a></li>
        </ul>
      </nav>

      <p>
        <h1 class="title">{{ $folder->name }}</h1>
        <h2 class="subtitle">{{ $folder->description }}</h2>
      </p>
  
      <section class="info-tiles">

          <div class="card">
            <header class="card-header">
              <p class="card-header-title">
                Currently has access
              </p>
            </header>
            <div class="card-content">
              <div class="content">
                  
                <form action="{{ route('revokeFolderAccess', ['folder' => $folder->id]) }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="DELETE">
                @if($folder->usersWithAccess()->count() > 0)
                <table class="table is-fullwidth is-striped">
                  <thead>
                      <tr>
                        <th>
                          <input class="checkbox" onClick="toggle(this,'AccessUser[]')" name="checkall" type="checkbox">
                        </th>
                        <th></th>
                        <th>User Name</th>
                        <th>E-mail</th>
                        <th>Role</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach ($folder->usersWithAccess() as $user)
                      <tr>
                        <td width="5%">
                          @if($user->roles()->first()->name != "Site Manager")
                          <input class="checkbox" name="AccessUser[]" value="{{ $user->id }}" type="checkbox">
                          @endif
                        </td>
                        <td width="5%"><i class="fa fa-user-o"></i></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles()->first()->name }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>

                <button class="button is-danger is-small" onclick="return confirm('Are you sure you want to revoke access from the selected users?');">Revoke access from selected users</button>

                @else
                  <p>Nobody has access</p>
                @endif
                </form>

              </div>
            </div>
          </div>

          <br />

          <div class="card">
            <header class="card-header">
              <p class="card-header-title">
                Currently does not have access
              </p>
            </header>
            <div class="card-content">
              <div class="content">
                
                <form action="{{ route('grantFolderAccess', ['folder' => $folder->id]) }}" method="POST">
                {{ csrf_field() }}
                @if($folder->usersWithNoAccess()->count() > 0)
                <table class="table is-fullwidth is-striped">
                  <thead>
                      <tr>
                        <th><input class="checkbox" onClick="toggle(this,'noAccessUser[]')" name="checkall" type="checkbox"></th>
                        <th></th>
                        <th>User Name</th>
                        <th>E-mail</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach ($folder->usersWithNoAccess() as $user)
                      <tr>
                        <td width="5%">
                          @if($user->roles()->first()->name != "Site Manager")
                            <input class="checkbox" name="noAccessUser[]" value="{{ $user->id }}" type="checkbox">
                          @endif
                        </td>
                        <td width="5%"><i class="fa fa-user-o"></i></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                      </tr>
                    @endforeach

                  </tbody>
                </table>

                <button class="button is-info is-small" onclick="return confirm('Are you sure you want to give access to the selected users?');">Give access to selected users</button>

                @else
                  <p>Everyone has access!</p>
                @endif
                </form>

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
