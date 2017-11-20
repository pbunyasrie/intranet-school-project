@extends('layouts.app')

@section('content')
    <div class="column is-9">
      <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
          <li><a href="../">Home</a></li>
          <li class="is-active"><a href="#" aria-current="page">Send Message</a></li>
        </ul>
      </nav>

  

      <section class="info-tiles">

          <div class="card">
            <header class="card-header">
              <p class="card-header-title">
                Message
              </p>
            </header>
            <div class="card-content">
              <div class="content">
                  
                <textarea class="textarea" placeholder="Write your message here..." rows="10"></textarea>

              </div>
            </div>
          </div>
      </section>

      <br />

      <div class="columns">
        <div class="column is-6">
          <section class="info-tiles">

              <div class="card">
                <header class="card-header">
                  <p class="card-header-title">
                    Send to users with the following roles
                  </p>
                </header>
                <div class="card-content">
                  <div class="content">
                      
                    <table class="table is-fullwidth is-striped">
                      <thead>
                          <tr>
                            <th><input class="checkbox" onClick="toggle(this,'role')" name="checkall" type="checkbox"></th>
                            <th></th>
                            <th>Role</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach (\App\Role::all() as $role)
                          <tr>
                            <td width="5%"><input class="checkbox" name="role" value="{{ $role->id }}" type="checkbox"></td>
                            <td width="5%"><i class="fa fa-user-o"></i></td>
                            <td>{{ $role->name }}</td>
                          </tr>
                        @endforeach

                      </tbody>
                    </table>


                  </div>
                </div>
              </div>
          </section>

      </div>
      <div class="column is-6">
        <section class="info-tiles">

            <div class="card">
              <header class="card-header">
                <p class="card-header-title">
                  Send to users with access to the following folders
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

                  @else
                    <p>No folders yet.</p>
                  @endif

                </div>
              </div>
            </div>
        </section>
      </div>
    </div>


    <button class="button is-primary" onclick="return confirm('Are you sure you want to send the message?');">Send Message</button>

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
