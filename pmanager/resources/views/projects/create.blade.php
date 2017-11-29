@extends('layouts.app')
@section('content')

<div class="row col-sm-9 col-md-9 col-lg-9 pull-left"  style="background: white;">
  <h1>Create Project</h1>
  <div class="row col-sm-12 col-md-12 col-lg-12" >
    <form method="post" action="{{route('projects.store')}}">
                     {{csrf_field()}}
        <div class="form-group">
            <label for="project_name">Name</label>
              <input placeholder="Enter name" 
              id="project_name"  
              required 
              name="name"
              type="text"
              spellcheck="false"
              class="form-control">
              
        </div>  
        @if($companies == null)
        <input   
        class="form-control"
        type="hidden"
                name="company_id"
                value="{{ $company_id }}"
                 />
        </div>

        @endif

        @if($companies != null)
        <div class="form-group">
            <label for="company-content">Select company</label>

            <select name="company_id" class="form-control" > 

            @foreach($companies as $company)
                    <option value="{{$company->id}}"> {{$company->name}} </option>
                  @endforeach
            </select>
        </div>
        @endif
  

        <div class="form-group">
          <label for="project_description">Description</label>
            <textarea 
            placeholder="Enter description" 
            style="resize:vertical"
            id="project_description"
            class="form-control autosize-target text-left" 
            required 
            name="description"
            type="textarea"
            rows="5" spellcheck="false"></textarea>
      </div>
  
  
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>

<div class="col-sm-3 col-md-3  col-lg-3 pull-right">
        
          <div class="sidebar-module">
            <h4>project Actions</h4>
            <ol class="list-unstyled">  <li><a href="/projects">All Project</a></li>
            </ol>
          </div>
         
        </div>
        @endsection()