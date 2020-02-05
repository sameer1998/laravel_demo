<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use Helper,Auth;
use Illuminate\Support\Str;
use App\models\Hotel;
use App\models\UserOtp;
use App\models\UserDevice;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use App\models\HotelRoomHistory;

class AuthController extends Controller
{

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
     * Login Api.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        $email = $request->input('email');
        $password = $request->input('password');

        $validator = Validator::make($request->all() , ['email' => 'required|email', 'password' => 'required', 'deviceType' => 'required', 'deviceToken' => 'required']);
        if ($validator->fails()){
            $errors = $validator->errors()->first();
            $content['status'] = 400;
            $content['message'] = $errors;
        }else{
            $user = Auth::attempt(['email'=>$email,'password'=>$password]);
            if($user){
               $user =  User::where(['email'=>$email])->first();
               $user->api_token = Str::random(40);
               $user->update();
            }
            if ($user != null)
              {
                          $user = $user->toArray();
                            $dataList = array(
                                'user_id' => $user['id'],
                                'deviceToken' => $request->input('deviceToken') ,
                                'deviceType' => $request->input('deviceType') ,
                                'created_at' => date('Y-m-d H:i:s')
                            );
                            $save = UserDevice::insert($dataList);
                            if ($save){
                              $content['status'] = 200;
                              $content['message'] = "successfully Logged in";
                              $content['data'] = $user;
                            }else{
                              $content['status'] = 400;
                              $content['message'] = 'Invalid Device';
                            }

                        }else{
                          $content['status'] = 400;
                              $content['message'] = 'Invalid password';
                        }
          }
        echo json_encode($content);
    }
    /**
     * forgot password Api.
     *
     * @return \Illuminate\Http\Response
     */

    public function changePassword(Request $request)
    {
        $id = $request->input('user_id');
        // print_r($request->all());
        // die();
        $userId = $request->userId;
        $user = User::find($id);
        $validator = Validator::make($request->all() , ['user_id' => 'required', 'old_password' => ['required', 'min:6', function ($attribute, $value, $fail) use ($user)
        {
            if (!\Hash::check($value, $user->password))
            {
                return $fail(__('The Old password is incorrect.'));
            }
        }
        ], 'password' => 'required|min:6', ]);

        if ($validator->fails())
        {
            $errors = $validator->errors();
            if ($errors->has('user_id'))
            {
                $msg = $errors->first('user_id');
                return api_response($msg, null, ['status' => '400']);
            }

            if ($errors->has('old_password'))
            {
                $msg = $errors->first('old_password');
                return api_response($msg, null, ['status' => '400']);
            }

            if ($errors->has('password'))
            {
                $msg = $errors->first('password');
                return api_response($msg, null, ['status' => '400']);
            }
        }
        else
        {
            if ($userId == $id)
            {
                $updateData = $arrayName = array(
                    'password' => Hash::make($request->password)
                );
                $updateQuary = User::find($id)->update($updateData);
                if ($updateQuary)
                {
                    $msg = 'Your password change successfully.';
                    return api_response($msg, null, ['status' => '200']);
                }
                else
                {
                    $msg = 'Your password is not updated.';
                    return api_response($msg, null, ['status' => '401']);
                }
            }
            else
            {
                $msg = 'Account with provided Email id not exist';
                return api_response($msg, null, ['status' => '401']);
            }
        }
    }

    public function forgotPassword(Request $request)
    {
        $email = $request->input('email');
        $validator = Validator::make($request->all() , ['email' => 'required|email', ]);
        if ($validator->fails())
        {
            $errors = $validator->errors();
            $msg = $errors->first('email');
            return api_response($msg, null, ['status' => '400']);
        }
        else
        {
            $user = User::where(['email' => $email])->where(['role_id' => '3'])
                ->first();
            if ($user != null)
            {

                $name = $user->first_name . ' ' . $user->last_name;
                $code = rand(1000, 9999);;
                $email = $user->email;
                // die();
                $totalOtp = UserOtp::where('user_id', $user->id)
                    ->count();
                if ($totalOtp > 0)
                {
                    $update = UserOtp::where('user_id', '=', $user->id)
                        ->update(['status' => 0]);
                    if ($update)
                    {

                    }
                    else
                    {
                        $msg = 'Otp is not send.Try again.';
                        return api_response($msg, null, ['status' => '500']);
                    }
                }
                $dataList = array(
                    'user_id' => $user->id,
                    'otp' => $code,
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s') ,
                );
                $save = UserOtp::insert($dataList);
                if ($save)
                {
                    Mail::to($email)->send(new SendMailable($name, $code));

                    $msg = 'Otp has been sent to your email address';
                    return api_response($msg, null, ['status' => '200']);
                }
                else
                {
                    $msg = 'Otp is not send.Try again.';
                    return api_response($msg, null, ['status' => '500']);
                }

            }
            else
            {
                $msg = 'Account with provided Email id not exist';
                return api_response($msg, null, ['status' => '400']);
            }
        }
    }
    /**
     * Otp Verification Api.
     *
     * @return \Illuminate\Http\Response
     */
    public function verifyOtp(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');
        $validator = Validator::make($request->all() , ['email' => 'required|email', 'otp' => 'required|numeric', ]);
        if ($validator->fails())
        {
            $errors = $validator->errors();
            if ($errors->has('email'))
            {
                $msg = $errors->first('email');
                return api_response($msg, null, ['status' => '400']);
            }
            if ($errors->has('otp'))
            {
                $msg = $errors->first('otp');
                return api_response($msg, null, ['status' => '400']);
            }
        }
        else
        {
            $user = User::where(['email' => $email])->first();
            if ($user != null)
            {
                $userOtp = UserOtp::where('otp', $otp)->where('user_id', $user->id)
                    ->where('status', 1)
                    ->first();
                if ($userOtp)
                {
                    $msg = 'Otp verification successful.';
                    return api_response($msg, null, ['status' => '200']);
                }
                else
                {
                    $msg = 'Invalid otp code.';
                    return api_response($msg, null, ['status' => '400']);
                }
            }
            else
            {
                $msg = 'Account with provided Email id not exist';
                return api_response($msg, null, ['status' => '400']);
            }
        }
    }
    /**
     * Reset Password Api.
     *
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(Request $request)
    {
        $email = $request->input('email');
        $newPassword = $request->input('new_password');
        $validator = Validator::make($request->all() , ['email' => 'required|email', 'new_password' => 'required|min:6', ]);
        if ($validator->fails())
        {
            $errors = $validator->errors();
            if ($errors->has('email'))
            {
                $msg = $errors->first('email');
                return api_response($msg, null, ['status' => '400']);
            }
            if ($errors->has('new_password'))
            {
                $msg = $errors->first('new_password');
                return api_response($msg, null, ['status' => '400']);
            }
        }
        else
        {
            $user = User::where(['email' => $email])->first();
            if ($user != null)
            {
                if ($user->role_id != 3)
                {
                    $msg = 'Account with provided Email id not exist';
                    return api_response($msg, null, ['status' => '400']);
                }
                else
                {
                    $update = User::where('id', '=', $user->id)
                        ->update(['password' => Hash::make($newPassword) ]);
                    if ($update)
                    {
                        $msg = 'Your password reset sucessfully.';
                        return api_response($msg, null, ['status' => '500']);
                    }
                    else
                    {
                        $msg = 'Your password is not updated.';
                        return api_response($msg, null, ['status' => '500']);
                    }
                }
            }
            else
            {
                $msg = 'Account with provided Email id not exist...!';
                return api_response($msg, null, ['status' => '400']);
            }
        }
    }
    /**
     * Logout Api.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
      $content =  array();
      $content['status'] = 412;
      $content['message'] = 'No User Found.';
        $user = Auth::user();
        if(!empty($user)) $id = $user->id;
        else $id = 0;
            $user = User::where(['id' => $id])->first();
            if ($user != null){
                $delete = UserDevice::where('user_id', $id)->delete();
                if ($delete){
                  $content['status'] = 500;
                  $content['message'] = 'You are sucessfully logout.';
                }else{
                  $content['status'] = 500;
                  $content['message'] = 'Account is not logout.';
                }
            }
       echo json_encode($content);
    }
}

