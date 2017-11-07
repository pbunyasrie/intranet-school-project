@extends('layouts.app')

@section('content')
    <div class="column is-9">
      <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
          <li><a href="../">Home</a></li>
          <li><a href="{{ route('folders') }}" aria-current="page">Folder List</a></li>
          <li class="is-active"><a href="#" aria-current="page">Edit Folder</a></li>
        </ul>
      </nav>

      <br /><br />

      <section class="info-tiles">

          <div class="card">
            <header class="card-header">
              <p class="card-header-title">
                Edit folder
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
                    <button class="button is-primary">Update</button>
                  </form>
              </div>
            </div>
          </div>
      </section>

@endsection


@section('footer_js')


@endsection
