<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Mail;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;


class CommentsController extends Controller
{

    protected $validationRules = [
        'url' => 'required',
        'comment' => 'required|max:255',
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       // $this->sendEmailNotification();

        Log::info('Showing commentt to save .', ['id' => $request->input('comment')]);
        Log::info('Showing url to save .', ['id' => $request->input('url')]);
        Log::info('Showing commentable_id to save .', ['id' => $request->input('commentable_id')]);
        Log::info('Showing commentable_type to save .', ['id' => $request->input('commentable_type')]);
        //checking validation

        $messages = [
            'comment.required' => 'Comment is required!',
        ];

        $validation = Validator::make($request->all(), $this->validationRules, $messages);
        //$validator = Validator::make($postData, $rules, $messages);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors());
         // return redirect()->back()->withErrors( $validator )->withInput();
        }

        //saving data
        if(Auth::check()){
            $comment=comment::create([
             'body'=>$request->input('comment'),
             'user_id'=>Auth::user()->id,
             'url'=>$request->input('url'),
             'commentable_id'=>$request->input('commentable_id'),
             'commentable_type'=>$request->input('commentable_type'),
            ]);

            if($comment){

                return back()->with('success','comment created successfully');
         
            }else{
                return back()->WithInput()->with('errors','An error occured while creating your request');

            }
        }
        return back()->WithInput()->with('errors','Please login');
        
    }


    private function sendEmailNotification()
    {

         try
         {
    
            $data['username']='ayobami';
            $data['userphonenumber']='08058021076';
            $data['units']='10';
            Mail::send('emails.testemail',$data, function($message)
            {
                $message->to("ayfadipe@gmail.com")
                ->bcc('fadipehayy@yahoo.com')
                ->from('info@sleeksoft.com')
                ->subject('Email Testing!');
                //$message->attach($pathToFile);
            });
        }
        catch(Exception $e)
        {
            return redirect()->back()->withErrors( "Unable to send emails. Pls try again") ->withInput();
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
