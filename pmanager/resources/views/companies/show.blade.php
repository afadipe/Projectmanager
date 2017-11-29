@extends('layouts.app')
@section('content')


<div class="col-sm-9 col-md-9 col-lg-9 pull-left">
  <div class="jumbotron">
    <h1>{{$company->name}}</h1>
    <p class="lead">{{$company->description}}.</p>
    
  </div>

  <div  class="row  col-md-12 col-lg-12 col-sm-12" style="background:white; margin:10px">
    <a href="/projects/create/{{$company->id}}" class="pull-right btn btn-default btn-sm">Add Project</a>
          @foreach($company->projects as $project)
          <div class="col-lg-4">
            <h2>{{$project->name}}</h2>
            <p class="text-danger">{{$project->description}}.</p>
            <p>{{$project->days}} </p>
            <p><a class="btn btn-primary" href="/projects/{{$project->id}}" role="button">View details &raquo;</a></p>
          </div>
        @endforeach  
  </div>
</div>

<div class="col-sm-3 col-md-3  col-lg3 pull-right">
        
          <div class="sidebar-module">
            <h4>Company Actions</h4>
            <ol class="list-unstyled">
              <li><a href="/companies/{{$company->id}}/edit">Edit</a></li>
              <li><a href="/projects/create/{{$company->id}}">Add Project</a></li>
              <li><a href="/companies/create">Create New Company</a></li>
              <li><a href="/companies/index">List of Company</a></li>
              <br/>
              <li>  
              <a   
              href="#"
                  onclick="
                  var result = confirm('Are you sure you wish to delete this Company?');
                      if( result ){
                              event.preventDefault();
                              document.getElementById('delete-form').submit();
                      }
                          "
                          >
                  Delete
              </a>

              <form id="delete-form" action="{{ route('companies.destroy',[$company->id]) }}" 
                method="POST" style="display: none;">
                        <input type="hidden" name="_method" value="delete">
                        {{ csrf_field() }}
              </form>

 
              
              
              </li>
            </ol>
          </div>
          <div class="sidebar-module">
            <h4>Member</h4>
            <ol class="list-unstyled">
              <li><a href="#">March 2014</a></li>
           
            </ol>
          </div>
          
        </div>
@endsection()