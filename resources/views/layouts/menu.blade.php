

<!-- START MENU -->

  <div class="column is-3">
    <aside class="menu">

      @include('layouts.search')

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
          <a>Users</a>
        </li>
        <li>
          <a>Configuration</a>
        </li>
      </ul>
      @endif

        <br />
        <a class="button is-warning" href="{{ route('logout') }}"
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

