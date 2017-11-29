<?php

namespace App\Http\Controllers;

use App\Project;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //getting the list of project
        if(Auth::check()){

            $projects=Project::where('user_id',Auth::user()->id)->get();
            return View('projects.index',['projects'=>$projects]);
        }
        return view('Auth.login');
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($company_id = null)
    {
        Log::info('Showing Company Id: '.$company_id); 
        $companies= null;
        if(!$company_id){
            $companies=Company::where('user_id',Auth::user()->id)->get();
        }
        return view('projects.create',['company_id'=>$company_id,'companies'=> $companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*
         User id is present in Auth and also in request
         for Auth
         'user_id'=>Auth::user()->id
         for Request
         'user_id'=>$request->user()->id
         'company_id',
        'days'

        */
        Log::info('@ store controller Showing Company Id: '.$request->input('company_id'));
        if(Auth::check()){
            $project=Project::create([
             'name'=>$request->input('name'),
             'description'=>$request->input('description'),
             'company_id' =>$request->input('company_id'),
             'user_id'=>Auth::user()->id
            ]);

            if($project){
                return redirect()->route('projects.show',['project'=>$project->id])
                ->with('success','project created successfully');
         
            }else{
                return back()->WithInput()->with('errors','An error occured while creating your request');

            }
        }
        return back()->WithInput()->with('errors','Please login');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        Log::info('Showing project Id: '.$project->id);
        Log::info('Showing project Id to show details for.', ['id' => $project->id]);

        $project=Project::where('id',$project->id)->first();
        //$project=project::find($project->id);
        $comments = $project->comments;
       return view('projects.show', ['project'=>$project, 'comments'=> $comments ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
        Log::info('Showing project Id to edit for.', ['id' => $project->id]);
        $project=Project::find($project->id);
        Log::info('Showing fetched project data.', ['name' => $project->name]);
        return view('projects.edit',['project'=>$project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        Log::info('Showing project Id to update.', ['id' => $project->id]);
        Log::info('Showing project Name to update.', ['Name' => $request->input('name')]);
        Log::info('Showing project Description to update.', ['Description' => $request->input('description')]);
        $projectupdate=Project::where('id',$project->id)
                        ->update([
                        'name'=>$request->input('name'),
                        'description'=>$request->input('description')
                        ]);
        if($projectupdate){

            $notification = array(
                'message' => 'info found data!',
                'alert-type' => 'success'
            );

            return redirect()->route('projects.show',['project'=>$project->id])
            ->with('success','project updated successfully');
        }
        //redirect
        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
        Log::info('Showing project Id to destroy.', ['id' => $project->id]);
        $deleteproject=Project::find($project->id);
        if($deleteproject->delete()){

            return redirect()->route('projects.index') ->with('success','project deleted successfully');
        }
        return back()->withInput()->with('error','An error occured while processing your request');
    }
}
