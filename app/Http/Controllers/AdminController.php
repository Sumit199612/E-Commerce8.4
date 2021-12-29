<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Auth;
use Illuminate\Http\Request;
use Session;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            // echo "test"; die;
            $data = $request->input();
            $adminCount = Admin::where(['username' => $data['username'], 'password' => md5($data['password']), 'status' => '1'])->count();
            if ($adminCount > 0) {
                // echo "Success"; die;
                Session::put('adminSession', $data['username']);
                return redirect('admin/dashboard');
            } else {
                // echo "Failed"; die;
                return redirect('/admin')->with('error', 'Invalid UserName or Password');
            }
        }
        return view('admin.admin_login');
    }

    public function loginApi(Request $request)
    {
        if ($request->isMethod('post')) {
            // echo "test"; die;
            $data = $request->input();
            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => '1'])) {
                // echo "Success"; die;
                // Session::put('adminSession',$data['email']);
                return redirect('admin/dashboard');
            } else {
                // echo "Failed"; die;
                return redirect('/admin')->with('error', 'Invalid UserName or Password');
            }
        }
        return response()->json([
            "status" => true,
            "data" => $data,
            "message" => "Logged In",
        ], 201);

        // return view('admin.admin_login');
    }

    public function dashboard()
    {
        // echo "test"; die;
        // if(session::has('adminSession')){
        //     // Perform All Dashboard Task
        // }else{
        //     return redirect('/admin')->with('error','Please Login to get Access');
        // }
        return view('admin.dashboard');
    }

    public function settings()
    {
        $adminDetails = Admin::where(['username' => Session::get('adminSession')])->first();
        return view('admin.settings')->with(compact('adminDetails'));
    }

    public function chkPassword(Request $request)
    {
        $data = $request->all();
        // $current_password = $data['current_pwd'];
        // $check_password = Admin::where(['username' => Session::get('adminSession')])->first();
        $adminCount = Admin::where(['username' => Session::get('adminSession'), 'password' => md5($data['current_pwd'])])->count();
        if ($adminCount == 1) {
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
            $adminCount = Admin::where(['username' => Session::get('adminSession'), 'password' => md5($data['current_pwd'])])->count();
            if ($adminCount == 1) {
                $password = md5($data['new_pwd']);
                Admin::where('username', Session::get('adminSession'))->update(['password' => $password]);
                return redirect('/admin/settings')->with('success', 'Password Updated Successfully');
            } else {
                return redirect('/admin/settings')->with('error', 'Incorrect Current Password');
            }
        }
    }

    public function logout()
    {
        // echo "test"; die;
        Session::flush();
        return redirect('/admin')->with('success', 'Logged Out Successfully');
    }
}
