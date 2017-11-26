@extends('layouts.app')

@section('content')
    <div class="column is-9">
      <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
          <li><a href="../">Home</a></li>
          <li class="is-active"><a href="#" aria-current="page">Recycle Bin</a></li>
        </ul>
      </nav>

      <div class="columns">
        <div class="column is-12">

          @if(Auth::user()->hasRole("Site Manager"))
          <div class="card events-card">
            <header class="card-header">
              <p class="card-header-title">
                Recycle Bin
              </p>
            </header>
            <div class="card-table">
              <div class="content">
                  @include('folders.files')
              </div>
            </div>
          </div>
          @endif

        </div>

      </div>
    </div>

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
