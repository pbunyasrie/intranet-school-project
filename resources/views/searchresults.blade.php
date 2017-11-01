@extends('layouts.app')

@section('content')

<div class="column is-9">
  <nav class="breadcrumb" aria-label="breadcrumbs">
    <ul>
      <li><a href="../">Home</a></li>
      <li class="is-active"><a href="#" aria-current="page">Search results for "{{ $query }}"</a></li>
    </ul>
  </nav>

      @if(!empty($files) && !empty($query))
          <strong>Found {{ count($files) }} files</strong>
          <br />
          <ul>
          @foreach($files as $file)
              <li><strong><a href="{{ route('download', [ 'filename' => $file->filename ]) }}">{{ $file->filename }}</a></strong>
                <br />
                {{ $file->getContentsExcerpt($query) }}
                <br /><br />
              </li>
          @endforeach
          </ul>
      @else
        <strong>Found 0 files</strong>
      @endif

</div>

@endsection