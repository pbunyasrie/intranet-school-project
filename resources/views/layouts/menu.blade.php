

<!-- START MENU -->

  <div class="column is-3">
    <aside class="menu">

      @include('layouts.search')

      <p class="menu-label">
        General
      </p>
      <ul class="menu-list">
        <li><a @if(\Request::route()->getName() == "dashboard") class="is-active" @endif href="{{ route('dashboard') }}">Dashboard</a></li>
        <li><a>Folder List</a></li>
      </ul>
      <p class="menu-label">
        My Account
      </p>
      <ul class="menu-list">
        <li>
          <a>Settings</a>
        </li>
      </ul>

      @if(Auth::user()->roles()->get()[0]->name != "Site Manager")
      <p class="menu-label">
        Administration
      </p>
      <ul class="menu-list">
        <li>
          <a>Folders</a>
        </li>
        <li>
          <a>Files</a>
        </li>
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

