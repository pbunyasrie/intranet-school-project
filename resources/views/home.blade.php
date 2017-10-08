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

                    <form id="elasticScout" action="/SearchQuery" method="get">
                         <div class="mysearchbar">
                             <input name="search" value="{{ $query }}" placeholder="Search...">
                         </div>
                    </form>


                    @if(!empty($files))
                        @foreach($files as $file)
                            <h1>{{ $file->filename }} </h1>
                            Metadata: <br />
                            {{ $file->metadata }}
                            <br /><br />
                            Contents: <br />
                            {{ $file->contents }}
                        @endforeach
                    @endif


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
