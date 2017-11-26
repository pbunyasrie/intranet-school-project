@extends('layouts.app')

@section('content')
    <div class="column is-9">
      <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
          <li><a href="../">Home</a></li>
          <li class="is-active"><a href="#" aria-current="page">User Management</a></li>
        </ul>
      </nav>

  
      <section class="info-tiles">

          <div class="card">
            <header class="card-header">
              <p class="card-header-title">
                User Administration - {{ \App\User::all()->count() }} users
              </p>
            </header>
            <div class="card-content">
              <div class="content">
                  
                @if(\App\User::all()->count() > 0)
                <form name="user-management" method="POST">
                {{ csrf_field() }}
                <table class="table is-fullwidth is-striped">
                  <thead>
                      <tr>
                        <th><input class="checkbox" onClick="toggle(this,'user[]')" name="checkall" type="checkbox"></th>
                        <th></th>
                        <th>User Name</th>
                        <th>E-mail</th>
                        <th>Role</th>
                        <th>Folder Access</tH>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach (\App\User::all()->sortBy('name') as $user)
                      <tr>
                        <td width="5%">
                            @if($user != Auth::user())
                              <input class="checkbox" name="user[]" value="{{ $user->id }}" type="checkbox">
                            @endif
                        </td>
                        <td width="5%"><i class="fa fa-user-o"></i></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                          @if($user != Auth::user())
                          <div class="select">
                            <select name="role[{{$user->id}}]">
                              <option value="">-Select role-</option>
                              @foreach (\App\Role::all() as $role)
                                @if(($user->roles()->first())->id == $role->id)
                                  <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                                @else
                                  <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endif
                              @endforeach
                            </select>
                          </div>
                          @endif
                        </td>
                        <td>
                          @if($user != Auth::user())
                            <a class="button is-small is-warning" href="{{ route('adminUsersAccess', ['user' => $user->id])}}">Manage folder access</a>
                          @endif
                        </td>
                      </tr>
                    @endforeach

                  </tbody>
                </table>


                <button class="button is-info is-small" onclick="setAction(this.form, 'PUT'); return confirm('Are you sure you want to update the selected users?');">Update Roles of Selected Users</button>

                <button class="button is-danger is-small" onclick="setAction(this.form, 'DELETE'); return confirm('Are you sure you want to delete the selected users?');">Delete Selected Users</button>

                @else
                  <p>No users yet.</p>
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

  function setAction (e, action)   
  { 
    /* Insert a hidden input into the form to set the page as a parameter. 
     */ 
    var input = document.createElement("input"); 
    input.setAttribute("type","hidden"); 
    input.setAttribute("name","_method"); 
    input.setAttribute("value",action);   
    e.appendChild(input); 

    /* Change the form's action. This doesn't chage which page is displayed, 
     * it just make the URL look right. 
     */ 
    if(action == "PUT"){
      e.action = '{{ route('updateUsers') }}';   
    }else if(name == "DELETE"){
      e.action = '{{ route('deleteUsers') }}';   
    }
    
    // element.form.submit(); 
    return false;
  }
</script>
@endsection
