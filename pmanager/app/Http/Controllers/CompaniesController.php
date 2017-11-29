<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //getting the list of company
        if(Auth::check()){

            $companies=company::where('user_id',Auth::user()->id)->get();
            return View('Companies.index',['companies'=>$companies]);
        }
        return view('Auth.login');
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
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
        */
        //
        if(Auth::check()){
            $company=company::create([
             'name'=>$request->input('name'),
             'description'=>$request->input('description'),
             'user_id'=>Auth::user()->id
            ]);

            if($company){
                return redirect()->route('companies.show',['company'=>$company->id])
                ->with('success','company created successfully');
         
            }else{
                return back()->WithInput()->with('errors','An error occured while creating your request');

            }
        }
        return back()->WithInput()->with('errors','Please login');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        Log::info('Showing company Id: '.$company->id);
        Log::info('Showing company Id to show details for.', ['id' => $company->id]);

        $company=company::where('id',$company->id)->first();
        //$company=company::find($company->id);
        return view('companies.show',['company'=>$company]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
        Log::info('Showing company Id to edit for.', ['id' => $company->id]);
        $company=company::find($company->id);
        Log::info('Showing fetched company data.', ['name' => $company->name]);
        return view('companies.edit',['company'=>$company]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        Log::info('Showing company Id to update.', ['id' => $company->id]);
        Log::info('Showing company Name to update.', ['Name' => $request->input('name')]);
        Log::info('Showing company Description to update.', ['Description' => $request->input('description')]);
        $companyupdate=company::where('id',$company->id)
                        ->update([
                        'name'=>$request->input('name'),
                        'description'=>$request->input('description')
                        ]);
        if($companyupdate){

            $notification = array(
                'message' => 'info found data!',
                'alert-type' => 'success'
            );

            return redirect()->route('companies.show',['company'=>$company->id])
            ->with('success','company updated successfully');
        }
        //redirect
        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
        Log::info('Showing company Id to destroy.', ['id' => $company->id]);
        $deletecompany=company::find($company->id);
        if($deletecompany->delete()){

            return redirect()->route('companies.index') ->with('success','company deleted successfully');
        }
        return back()->withInput()->with('error','An error occured while processing your request');
    }
}
