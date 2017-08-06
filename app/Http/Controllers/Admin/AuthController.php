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
        Validator::make($credentials, [
            'username' => 'required',
            'password' => 'required',
        ])->validate();
        if (Auth::guard('admin')->attempt($credentials)) {
            return ['status'=>1,'msg'=>'登录成功!'];
        }

        return ['status'=>0,'msg'=>'账号或者密码错误!'];
    }

    public function getLogout() {
        Auth::guard('admin')->logout();
        return redirect('admin');
    }

    public function test() {
        $admin = Auth::guard('admin')->user();
        dd($admin->roles);
    }

}
