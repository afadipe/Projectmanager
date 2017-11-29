<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Support\Facades\Log;

use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Mail;
use Session;
use GuzzleHttp\Exception\RequestException;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        //$postData= $data->all();
        // setting up custom error messages for the field validation
        $messages = ['name.required' => 'Enter  Name',
        'email.email' => 'Enter a valid email address',
        'email.required' => 'Enter email address',
        'password.required' => 'You need a password',
        'confirm_password.required' => 'You need confirm password',
        'email.unique' => 'The email  '.' '. $data['email']. ' has already been taken. Please enter another email'
        ];
         
       $rules = ['name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password'=> 'required|string|min:6|confirmed',
            ];

         $validationcheck = Validator::make($data, $rules, $messages);
         if( $validationcheck->fails() ) {
        // Validator fails, return to the previous page with the errors
             return redirect()->back()->withErrors( $validator )->withInput();
           }


        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => bcrypt($data['password']),
        // ]);

        $User=User::create([
                 'name' => $data['name'],
                 'email' => $data['email'],
                 'password' => bcrypt($data['password']),
             ]);

        if($User){

            Session::put('user_id', $User->id);
            $this->sendRegistrationMail($User);
            return $User;
     
        }else{
            return back()->WithInput()->with('errors','An error occured while creating your request');

        }

    }


    private function sendRegistrationMail($user)
    {
       // $path = Storage::putFile('userimages',$data['userimage']);
         try
         {
            $data['user']=$user;
            Mail::send('emails.registeremail', $data, function($message) use ($user)
            {
                $message->to($user->email)
                ->from('info@sleeksoft.com')
                ->subject('Welcome to Test App!');
            });
        }
        catch(Exception $e)
        {
            return redirect()->back()->withErrors( "Unable to send emails. Pls try again") ->withInput();
        }

    }

}
