
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
    
        <div class="panel panel-default">
            <div class="panel-heading">Companies <a class="pull-right btn btn-primary btn-sm" href="/companies/create">Create New</a></div>
            <div class="panel-body">
                <ul class="list-group">
                @foreach($companies as $company)
                    <li class="list-group-item"><a href="/companies/{{ $company->id }}">{{$company->name}}</a></li>
                @endforeach
               </ul>
            </div>
        </div>

    </div>
</div>

@endsection()