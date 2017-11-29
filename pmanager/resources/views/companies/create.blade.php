@extends('layouts.app')
@section('content')

<div class="col-sm-9 col-md-9 col-lg-9 pull-left">
  
  <div class="row col-sm-12 col-md-12 col-lg-12" style="background:white; margin:10px">
    <form method="post" action="{{route('companies.store')}}">
                     {{csrf_field()}}
        <div class="form-group">
            <label for="company_name">Name</label>
              <input placeholder="Enter name" 
              id="company_name"  
              required 
              name="name"
              type="text"
              spellcheck="false"
              class="form-control">
              
        </div>

        <div class="form-group">
          <label for="company_description">Name</label>
            <textarea 
            placeholder="Enter description" 
            style="resize:vertical"
            id="company_description"
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

<div class="col-sm-3 col-md-3  col-lg3 pull-right">
        
          <div class="sidebar-module">
            <h4>Company Actions</h4>
            <ol class="list-unstyled">  <li><a href="/companies">All Company</a></li>
            </ol>
          </div>
         
        </div>
        @endsection()