

<!-- START MENU -->

  <div class="column is-3">
    <aside class="menu">

      <p class="menu-label">
        General
      </p>
      <ul class="menu-list">
        <li><a @if(\Request::route()->getName() == "dashboard") class="is-active" @endif href="{{ route('dashboard') }}">Dashboard</a></li>
        <li><a @if(\Request::route()->getName() == "folders" || \Request::route()->getName() == "folder" || \Request::route()->getName() == "folderCreate") class="is-active" @endif href="{{ route('folders') }}">Folder List</a></li>
      </ul>
      <p class="menu-label">
        My Account
      </p>
      <ul class="menu-list">
        <li>
          <a @if(\Request::route()->getName() == "settings") class="is-active" @endif href="{{ route('settings') }}">Settings</a>
        </li>
      </ul>

      @if(Auth::user()->hasRole("Site Manager"))
      <p class="menu-label">
        Administration
      </p>
      <ul class="menu-list">
        <li>
          <a @if(\Request::route()->getName() == "adminUsers" || \Request::route()->getName() == "adminUsersAccess") class="is-active" @endif href="{{ route('adminUsers') }}">User Management</a>
        </li>
        <li>
          <a @if(\Request::route()->getName() == "adminFolders" || \Request::route()->getName() == "adminFoldersAccess") class="is-active" @endif href="{{ route('adminFolders') }}">Folder Management</a>
        </li>
        <li>
          <a @if(\Request::route()->getName() == "adminSendMessage" || \Request::route()->getName() == "adminSendMessage") class="is-active" @endif href="{{ route('adminSendMessage') }}">Send Message</a>
        </li>
        <li>
          <a @if(\Request::route()->getName() == "adminLogs" || \Request::route()->getName() == "adminLogs") class="is-active" @endif href="{{ route('adminLogs') }}">Logs</a>
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

