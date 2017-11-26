

<!-- START MENU -->

  <div class="column is-3">


    <div class="navbar-burger burger" data-target="navMenu">
      <span></span>
      <span></span>
      <span></span>
    </div>
    
    <aside id="navMenu" class="menu navbar-menu">
      <p class="menu-label">
        General
      </p>
      <ul class="menu-list">
        <li><a @if(\Request::route()->getName() == "dashboard") class="is-active" @endif href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a @if(\Request::route()->getName() == "folders" || \Request::route()->getName() == "folder" || \Request::route()->getName() == "folderCreate") class="is-active" @endif href="{{ route('folders') }}"><i class="fa fa-folder-open"></i> Folder List</a></li>
      </ul>
      <p class="menu-label">
        My Account
      </p>
      <ul class="menu-list">
        <li>
          <a @if(\Request::route()->getName() == "settings") class="is-active" @endif href="{{ route('settings') }}"><i class="fa fa-cog"></i> Settings</a>
        </li>
      </ul>

      @if(Auth::user()->hasRole("Site Manager"))
      <p class="menu-label">
        Administration
      </p>
      <ul class="menu-list">
        <li><a @if(\Request::route()->getName() == "recycleShow") class="is-active" @endif href="{{ route('recycleShow') }}"><i class="fa fa-trash"></i> Recycle Bin</a></li>
        <li>
          <a @if(\Request::route()->getName() == "adminUsers" || \Request::route()->getName() == "adminUsersAccess") class="is-active" @endif href="{{ route('adminUsers') }}"><i class="fa fa-user"></i> User Management</a>
        </li>
        <li>
          <a @if(\Request::route()->getName() == "adminFolders" || \Request::route()->getName() == "adminFoldersAccess") class="is-active" @endif href="{{ route('adminFolders') }}"><i class="fa fa-folder"></i> Folder Management</a>
        </li>
        <li>
          <a @if(\Request::route()->getName() == "adminSendMessage" || \Request::route()->getName() == "adminSendMessage") class="is-active" @endif href="{{ route('adminSendMessage') }}"><i class="fa fa-envelope"></i> Send Message</a>
        </li>
        <li>
          <a @if(\Request::route()->getName() == "adminLogs" || \Request::route()->getName() == "adminLogs") class="is-active" @endif href="{{ route('adminLogs') }}"><i class="fa fa-history"></i> Logs</a>
        </li>
      </ul>
      @endif

        <br />
        <a class="button is-info" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
            Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </aside>
  </div>

<!-- END MENU -->

