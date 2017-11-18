@extends('layouts.app')

@section('content')
    <div class="column is-9">
      <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
          <li><a href="../">Home</a></li>
          <li><a href="{{ route('folders') }}" aria-current="page">Folder List</a></li>
          <li><a href="{{ route('folder', ['folder' => $folder->id])}}">{{ $folder->name }}</a></li>
          <li class="is-active"><a href="#" aria-current="page">Edit Folder</a></li>
        </ul>
      </nav>

      <br /><br />

      <section class="info-tiles">

          <div class="card message is-warning">
            <header class="card-header message-header">
              <p class="card-header-title">
                Edit folder

                <div style="padding: 15px">
                  <form action="{{ route('folderDestroy', ['folder' => $folder->id]) }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="folder_id" value="{{ $folder->id }}">
                    <button class="button is-danger is-small" onclick="return confirm('Are you sure you want to delete this folder? Any files in this folder will not be deleted');">Delete this folder</button>
                  </form>
                </div>
              </p>
            </header>
            <div class="card-content">
              <div class="content">
                  <form action="{{ route('folderUpdate', ['folder' => $folder->id]) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
                    {{ csrf_field() }}
                    @if ($errors->has('name'))
                      <span class="help-block has-text-danger">
                          <b>{{ $errors->first('name') }}</b>
                      </span>
                    @endif
                  <label class="label">Folder name</label>
                  <p class="control">
                    <input type="text" class="input form-control" style="width: 30%" name="name" placeholder="The folder name" value="{{ $folder->name }}">
                  </p>
                  @if ($errors->has('description'))
                      <span class="help-block has-text-danger">
                          <b>{{ $errors->first('description') }}</b>
                      </span>
                    @endif
                  <label class="label">Description</label>
                  <p class="control">
                    <input type="text" class="input form-control" style="width: 30%" name="description" placeholder="A short description of this folder" value="{{ $folder->description }}">
                  </p>                   
                    <a href="{{ route('folder', ['folder' => $folder->id])}}" class="button">Cancel</a>
                    <button class="button is-primary">Update</button>
                  </form>

              </div>
            </div>
          </div>
      </section>

@endsection


@section('footer_js')


@endsection
