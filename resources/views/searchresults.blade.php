@extends('layouts.app')

@section('content')

<div class="column is-6">
  <nav class="breadcrumb" aria-label="breadcrumbs">
    <ul>
      <li><a href="../">Home</a></li>
      <li class="is-active"><a href="#" aria-current="page">Search results for "{{ $query }}"</a></li>
    </ul>
  </nav>

      @if(!empty($folders) && !empty($query))
          <strong>Found {{ count($folders) }} folders</strong>
          <br />
          <ul>
          @foreach($folders as $folder)
              <li><strong><a href="{{ route('folder', [ 'folder' => $folder->id ]) }}">{{ $folder->name }}</a></strong>
                <p>
                  <em>Created on {{ $folder->created_at }}</em>
                </p>
                <p>
                  <blockquote>{{ $folder->description }}</blockquote>
                </p>
                <br />
              </li>
          @endforeach
          </ul>
      @else
        <strong>Found 0 folders</strong>
      @endif
      <br />

      @if(!empty($files) && !empty($query))
          <strong>Found {{ count($files) }} files</strong>
          <br />
          <ul>
          @foreach($files as $file)
              <li><strong><a class="button is-warning is-small" href="{{ route('folder', ['folder' => ($file->folder()->first())->id ]) }}"><i class="fa fa-folder"></i> {{ ($file->folder()->first())->name }}</a> <a href="{{ route('download', [ 'filename' => $file->filename ]) }}">{{ $file->filename }}</a></strong>
                <p>
                  <em>Uploaded on {{ $file->created_at }}</em>
                </p>
                <p>
                  <blockquote>{{ $file->getContentsExcerpt($query) }}</blockquote>
                </p>
                <br />
              </li>
          @endforeach
          </ul>
      @else
        <strong>Found 0 files</strong>
      @endif

</div>

<div class="column is-3">
  <div class="card">
    <header class="card-header">
      <p class="card-header-title">
        Filter
      </p>
    </header>
    <div class="card-content">
      <div class="content">
        <form id="elasticScout" action="{{ route('search') }}" method="get">
          <input name="query" type="hidden" value="{{ $query }}">
          Document type:
          <br />
          <div class="select">
            <select name="type">
              <option @if(!$type) selected @endif value="">Everything</option>
              @foreach (\App\File::all()->pluck('extension')->unique() as $extension)
                  <option value="{{ $extension }}" @if($type && $type == $extension) selected @endif>{{ $extension }}</option>
              @endforeach
            </select>
          </div>

          <br /><br />
          
          <button class="button is-primary">Filter</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection