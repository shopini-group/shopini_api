<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Activity_Log;
use App\Models\Contact;
use App\Models\Staff;
use App\Models\User;
use App\Notifications\SendEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
     
    public function __construct(SendEmail $sendEmail)
    {
        $this->sendEmail = $sendEmail;
    }

    public function Admin_login(Request $request)
        {

          
            $validator = \Validator::make($request->all(), [
                'email' => ['required', 'string', 'email'],
                'password' => ['required', 'string'],
                'remember_me' => ['boolean']
            ]);

            if ($validator->fails())
                return response()->json(['message' => $validator->errors()->all(),'error'=>true], 400);
                
                $admin = Staff::where('email',request('email'))->first();


                if($admin == null)
                {
                   return $this->Check_Admin_Validation('Non Existing User');
                }


                if(!$admin || !Hash::check($request["password"],$admin->password))
                {
                   return $this->Check_Admin_Validation('Failed Login Attempt');
                }


                if($admin->active == 0){
                   return $this->Check_Admin_Validation('Inactive User ');
                }

                

                if($admin->two_factor_auth_enabled == 1){
                    $payload = [
                        'staff_firstname' =>$admin->firstname ,
                        'two_factor_auth_code' => $this->UpdateTwoAuthCode($admin->staffid),
                        'email_signature' =>config('app.signature'),
                    ];

                 $this->sendEmail->SendNotificationIn_Email('email.two_auth_email_template', $admin->email, $payload);

                 return response(
                    array(
                        'success'=>true,
                        'message'=>'An email has been sent to '.request('email').' with verification code to verify your login',
                        ),200);
                }

                $token = $admin->createToken('usertoken')->plainTextToken;
                return response(
                    array(
                        'success'=>true,
                        'message'=>'Admin Successfully Logged In!',
                        'user'=>$admin,
                        'token'=>$token,
                        ),200);
             
               
    }

    public function User_login(Request $request)
        {

            $validator = \Validator::make($request->all(), [
                'email' => ['required', 'string', 'email'],
                'password' => ['required', 'string'],
                'remember_me' => ['boolean']
            ]);

            if ($validator->fails())
                return response()->json(['message' => $validator->errors()->all(),'error'=>true], 400);
                $contact = Contact::where('email',$request['email'])->first();

          

                if(!$contact || !Hash::check($request["password"],$contact->password))
                {
                    return response(
                        array(
                            'success'=>false,
                            'message'=>'Invalid username or password',
                            ),400);
                }

                if($contact->active == 0){
                    return response(
                        array(
                            'success'=>false,
                            'message'=>'Inactive Account',
                            ),400);
                }

                $token = $contact->createToken('contacttoken')->plainTextToken;
            
                return response(
                    array(
                        'success'=>true,
                        'message'=>'User Successfully Logged In!',
                        'user'=>$contact,
                        'token'=>$token,
                        ),200);
    }



    public function InsertLog($description, $staff = null)
    {
      $log = new   Activity_Log();
      $log->description = $description;
      $log->staffid = $staff;
      $log->date = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
      $log->save();
    }

    public function UpdateTwoAuthCode($staff_id)
    {
        $staff = Staff::where('staffid',$staff_id)->first();
        $staff->two_factor_auth_code = bin2hex(openssl_random_pseudo_bytes(4));
        $staff->save();
        return  $staff->two_factor_auth_code ;
  

    }


    public function Confirm_Two_Factor_Code()
    {
        $admin = Staff::where('email',request('email'))
        ->where('two_factor_auth_code',request('two_factor_auth_code'))
        ->first();
        
        if($admin == null)
        {
            return response(
                array(
                    'success'=>false,
                    'message'=>'Code Expire Send Two Auth Code Again',
                    ),400);
        }
        $admin->last_ip = request()->ip();
        $admin->last_login =  \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        $admin->save();


        $token = $admin->createToken('usertoken')->plainTextToken;

                return response(
                    array(
                        'success'=>true,
                        'message'=>'Two Factor verified and Super Admin Successfully Logged In! ',
                        'user'=>$admin,
                        'token'=>$token,
                        ),200);

    }


    public function Check_Admin_Validation($user_message)
    {

        $this->InsertLog($user_message.' Tried to Login  [Email: ' . request('email') . ', Is Staff Member: Yes, IP: ' . request()->ip(). ']');
        return response(
            array(
                'success'=>false,
                'message'=>$user_message,
                ),400);
    }


}
