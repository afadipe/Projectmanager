@extends('layouts.app')
@section('content')


<div class="row col-sm-9 col-md-9 col-lg-9 pull-left">
  <div class="well well-lg">
    <h1>{{$project->name}}</h1>
    <p class="lead">{{$project->description}}.</p>
    
  </div>

  <div class="row  col-md-12 col-lg-12 col-sm-12" style="background: white; margin: 10px; ">
  <!-- <li><a href="/projects/create" class="pull-right btn btn-primary btn-sm">Add Project</
        -->
        @include('partials.comments')
       <br/>

       <div class="row container-fluid">
            <form method="post" action="{{route('comments.store')}}">
                          {{csrf_field()}}
              

              <div class="form-group">
                <label for="comment_content">Comment</label>
                  <textarea 
                  placeholder="Enter Comment" 
                  style="resize:vertical"
                  id="comment_content"
                  class="form-control" 
                  name="comment"
                  type="textarea"
                  rows="3" spellcheck="false"></textarea>
            </div>
            <div class="form-group">
                  <label for="comment_url">url(proof of work done)</label>
                  <textarea 
                  placeholder="Enter url" 
                  style="resize:vertical"
                  id="comment_url"
                  class="form-control" 
                  required 
                  name="url"
                  type="textarea"
                  rows="2" spellcheck="false"></textarea>
                  
              </div>

              <input type="hidden" name="commentable_type" value="APP\project">
              <input type="hidden" name="commentable_id" value="{{$project->id}}">
          <button type="submit" class="btn btn-primary">Submit</button>
          </form>
       
       </div>


     
  </div>
</div>

<div class="col-sm-3 col-md-3  col-lg-3 pull-right">
        
          <div class="sidebar-module">
            <h4>Company Actions</h4>
            <ol class="list-unstyled">
              <li><a href="/projects/{{$project->id}}/edit">Edit</a></li>
              <li><a href="/projects/create">Add Project</a></li>
              <li><a href="/projects">My Project</a></li>
              <br/>

              @if($project->user_id==Auth::user()->id)
              <li>  
              <a   
              href="#"
                  onclick="
                  var result = confirm('Are you sure you wish to delete this Project?');
                      if( result ){
                              event.preventDefault();
                              document.getElementById('delete-form').submit();
                      }
                          "
                          >
                  Delete
              </a>

              <form id="delete-form" action="{{ route('projects.destroy',[$project->id]) }}" 
                method="POST" style="display: none;">
                        <input type="hidden" name="_method" value="delete">
                        {{ csrf_field() }}
              </form>
              
              </li>
              @endif
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

