
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
    
        <div class="panel panel-default">
            <div class="panel-heading">projects <a class="pull-right btn btn-primary btn-sm" href="/projects/create">Create New</a></div>
            <div class="panel-body">
                <ul class="list-group">
                @foreach($projects as $project)
                    <li class="list-group-item"><a href="/projects/{{ $project->id }}">{{$project->name}}</a></li>
                @endforeach
               </ul>
            </div>
        </div>

    </div>
</div>

@endsection()