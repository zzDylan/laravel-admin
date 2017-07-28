<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller {

    public function test() {
        \Debugbar::enable();
        $credentials = ['username' => 'test', 'password' => '111'];
        $test = Auth::guard('admin')->attempt($credentials);
        dd($test);
    }

}
