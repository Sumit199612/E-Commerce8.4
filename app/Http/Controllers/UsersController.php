<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{

    public function userLoginRegister()
    {
        return view('users.login_register');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            // echo "<pre>"; print_r($data); die;
            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => '1'])) {
                $userStatus = User::where('email', $data['email'])->first();
                if ($userStatus->status == 0) {
                    return redirect()->back()->with('error', "Your account is not activated. Please confirm your E-mail to activate your account");
                }
                Session::put('frontSession', $data['email']);
                $logged_user_id = DB::table('users')->where(['email' => $data['email']])->get('id');

                Session::put('logged_user_id', $logged_user_id[0]);
                return redirect('/cart');
            } else {
                return redirect()->back()->with('error', "Invalid Email Id or Password");
            }
        }
    }

    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            //Check if User already exists
            $usersCount = User::where('email', $data['email'])->count();
            if ($usersCount > 0) {
                return redirect()->back()->with('error', 'This email is already exists with another account.');
            } else {
                // echo "Success"; die;
                $user = new User;
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->save();

                // Send mail to user for Successfully Registring to website.
                // $email = $data['email'];
                // $messageData = ['email' => $data['email'], 'name' => $data['name']];
                // Mail::send('emails.register', $messageData, function ($message) use ($email) {
                //     $message->to($email)->subject('Registration with Keshri Fashion');
                // });

                // Send Confirmation email to user
                $email = $data['email'];
                $messageData = ['email' => $data['email'], 'name' => $data['name'], 'code' => base64_encode($data['email'])];
                Mail::send('emails.confirmation', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Confirm your Keshri Fashion Account');
                });

                return redirect()->back()->with('success', 'Please Confirm your E-mail to activate your Account. Link is sent to your registered E-mail address.');

                if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                    Session::put('frontSession', $data['email']);
                    return redirect('/cart');
                }
            }
        }
    }

    public function forgotPassword(Request $request) {
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $usersCount = User::where(['email'=> $data['email'], 'status'=>1])->count();
            if($usersCount == 0){
                return redirect()->back()->with('error', "This email is not registered with us. Please register or enter a valid email.");
            }

            // Get user details
            $userDetails = User::where(['email'=>$data['email'], 'status'=>1])->first();

            $random_password = str_random(8);

            // Encode/Secure Password
            $newPassword = bcrypt($random_password);

            //Update Password
            User::where('email',$data['email'])->update(['password'=>$newPassword]);

            // Send new password to user email
            $email = $data['email'];
            $name = $userDetails->name;
            $messageData = [
                'email' =>$email,
                'name' =>$name,
                'password'=>$random_password];

            Mail::send('emails.forgotPassword',$messageData,function($message)use($email){
                $message->to($email)->subject('Reset Password - Keshri Fashion Account');
            });

            return redirect('/login-register')->with('success', "Please check your email for new password.");
        }
        return view('users.forgot_password');
    }

    public function chkUserPassword(Request $request)
    {
        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
        $current_password = $data['current_pwd'];
        $user_id = Auth::User()->id;
        $check_password = User::where('id', $user_id)->first();
        if (Hash::check($current_password, $check_password->password)) {
            echo "true";die;
        } else {
            echo "false";die;
        }
    }

    public function updatePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $old_pwd = User::where('id', Auth::User()->id)->first();
            $current_pwd = $data['current_pwd'];
            if (Hash::check($current_pwd, $old_pwd->password)) {
                // Update Password
                $new_pwd = bcrypt($data['new_pwd']);
                User::where('id', Auth::User()->id)->update(['password' => $new_pwd]);
                return redirect()->back()->with('success', 'Password updated successfully');
            } else {
                return redirect()->back()->with('error', 'Current password is incorrect!');
            }

        }
    }

    public function logout()
    {
        // echo "test"; die;
        Auth::logout();
        Session::forget('frontSession');
        Session::forget('session_id');
        // Session::forget('CouponAmount');
        // Session::forget('CouponCode');
        return redirect('/');
        // return redirect('/')->with('success','Logged Out Successfully');
    }

    public function checkEmail(Request $request)
    {
        $data = $request->all();
        //Check if User already exists
        $usersCount = User::where('email', $data['email'])->count();
        if ($usersCount > 0) {
            echo "false";
        } else {
            echo "true";die;
        }
    }

    public function confirmAccount($email)
    {
        $email = base64_decode($email);
        $userDetails = User::where('email', $email)->count();
        if ($userDetails > 0) {
            $userDetails = User::where('email', $email)->first();
            if ($userDetails->status == 1) {
                return redirect('login-register')->with('success', 'Your account is already activated. You can login now.');
            } else {
                User::where('email', $email)->update(['status' => 1]);
                return redirect('login-register')->with('success', 'Your E-mail account is activated. You can login now.');
            }
        } else {
            abort(404);
        }
    }

    public function account(Request $request)
    {
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id);
        // echo "<pre>"; print_r($userDetails); die;
        $countries = Country::get();

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            if (empty($data['name'])) {
                return redirect()->back()->with('error', 'Please enter ypur Name to update your account details!!!');
            }

            if (empty($data['address'])) {
                $data['address'] = '';
            }

            if (empty($data['city'])) {
                $data['city'] = '';
            }

            if (empty($data['state'])) {
                $data['state'] = '';
            }

            if (empty($data['country'])) {
                $data['country'] = '';
            }

            if (empty($data['pincode'])) {
                $data['pincode'] = '';
            }

            if (empty($data['mobile'])) {
                $data['mobile'] = '';
            }

            $user = User::find($user_id);
            $user->name = $data['name'];
            $user->address = $data['address'];
            $user->city = $data['city'];
            $user->state = $data['state'];
            $user->country = $data['country'];
            $user->pincode = $data['pincode'];
            $user->mobile = $data['mobile'];
            $user->save();
            return redirect()->back()->with('success', 'Your account has been successfully updated.');

        }
        // else{
        //     return redirect()->back()->with('error','Something went wrong!!!');
        // }

        return view('users.account')->with(compact('countries', 'userDetails'));
    }

    public function viewUsers() {
        $users = User::get();
        return view('admin.users.view_users')->with(compact('users'));
    }
}
