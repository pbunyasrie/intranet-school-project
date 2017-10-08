@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!

                    <br />
                    Your role: {{ Auth::user()->roles()->get()[0]->name }}

                    <hr />

                    <h2>Search</h2>
                    <form id="elasticScout" action="/SearchQuery" method="get">
                         <div class="mysearchbar">
                             <input name="search" value="@if(!empty($query)){{ $query }}@endif" placeholder="Search...">
                         </div>
                        <input type="submit" value="Search" />
                    </form>

                    <hr />

                    <h2>Upload</h2>
                     @if (count($errors) > 0)
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                 
                    <form action="/upload" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        Files (can attach more than one):
                        <br />
                        <input type="file" name="files[]" multiple />
                        <br /><br />
                        <input type="submit" value="Upload" />
                    </form>

                    <hr />

                    @if(!empty($files) && !empty($query))
                    <h2>Files found</h2>
                        <ul>
                        @foreach($files as $file)
                            <li><strong><a href="{{ route('download', [ 'filename' => $file->filename ]) }}">{{ $file->filename }}</a></strong>
                            <br />
                            {{ $file->getContentsExcerpt($query) }}
                                </li>
                        @endforeach
                        </ul>
                    @endif

                    @if(!empty($files) && empty($query))
                    <h2>Files uploaded</h2>
                        <ul>
                        @foreach($files as $file)
                            <li><a href="{{ route('download', [ 'filename' => $file->filename ]) }}">{{ $file->filename }}</a></li>
                        @endforeach
                        </ul>
                    @endif


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
