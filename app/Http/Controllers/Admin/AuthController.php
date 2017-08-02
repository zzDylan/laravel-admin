<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller {

    public function getLogin() {
        if (!Auth::guard('admin')->guest()) {
            return redirect('admin');
        }
        return view('admin.login');
    }

    public function postLogin(Request $request) {
        $credentials = $request->only(['username', 'password']);

        $validator = Validator::make($credentials, [
                    'username' => 'required', 'password' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        if (Auth::guard('admin')->attempt($credentials)) {
            admin_toastr('success', '登录成功');
            if(Session::has('url.intented')){
                $url = Session::get('url.intented');
                Session::forget('url.intented');
                return redirect($url);
            }
            return redirect('admin');
        }

        return Redirect::back()->withInput()->withErrors(['username' => '账号或者密码错误']);
    }

    public function getLogout(){
        Auth::guard('admin')->logout();
        return redirect('admin');
    }
    
    public function test(){
        $admin = Auth::guard('admin')->user();
        dd($admin->roles);
    }
    
}
