<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Redirect;

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
            return redirect()->intended('admin');
        }

        return Redirect::back()->withInput()->withErrors(['username' => '账号或者密码错误']);
    }

    public function getLogout(){
        Auth::guard('admin')->logout();
        return redirect('admin');
    }
    
}
