<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        //如果是异步请求则返回json数据
        if ($request->ajax()) {
            $userModel = config('admin.database.users_model');
            if ($request->input('search')) {
                $users =$userModel::where('username', 'like', $request->input('search').'%')->offset($request->input('offset'))->limit($request->input('limit'))->get();
                $total = $userModel::where('username', 'like', $request->input('search').'%')->count();
            } else {
                $users = $userModel::offset($request->input('offset'))->limit($request->input('limit'))->get();
                $total = $userModel::count();
            }
            $userData = [];
            foreach ($users as $key => $user) {
                $userData[$key]['id'] = $user->id;
                $userData[$key]['username'] = $user->username;
                $userData[$key]['roles'] = $user->roles->pluck('name')->toArray();
                $userData[$key]['created_at'] = (string) $user->created_at;
                $userData[$key]['updated_at'] = (string) $user->updated_at;
            }
            return [
                'total' => $total,
                'rows' => $userData
            ];
        }
        //如果是同步请求，返回视图
        return view('admin.user.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $userModel = config('admin.database.users_model');
        $userModel::destroy($id);
        return ['status' => 1, 'msg' => '删除成功!'];
    }

    /**
     * 批量删除
     * @param Request $request
     */
    public function batchDestroy(Request $request) {
        $rule = [
            'ids' => 'required|array',
        ];
        $input = $request->all();
        Validator::make($input, $rule)->validate();
        $userModel = config('admin.database.users_model');
        $userModel::destroy($input['ids']);
        return ['status' => 1, 'msg' => '删除成功!'];
    }

}
