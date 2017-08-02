<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $menuModel = config('admin.database.menu_model');
        $menus = $menuModel::where('parent_id', 0)->get();
        return view('admin.menu.index', ['menus' => $menus]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $rule = [
            'parent_id' => 'required',
            'title' => 'required',
            'icon' => 'required',
            'uri' => 'required',
            'roles' => 'required|array',
        ];
        $messages = [
            'title.required' => '请填写菜单名',
            'icon.required' => '请选择菜单图标',
            'uri.required' => '请填写路径',
            'roles.required' => '请选择角色'
        ];
        $input = $request->all();
        $validator = Validator::make($input, $rule, $messages);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }
        $menuId = DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => $input['parent_id'],
            'title' => $input['title'],
            'icon' => $input['icon'],
            'uri' => $input['uri']
        ]);
        foreach ($input['roles'] as $role) {
            DB::table(config('admin.database.role_menu_table'))->insert([
                'role_id' => $role,
                'menu_id' => $menuId
            ]);
        }
        admin_toastr('success', '添加成功');
        return redirect('/admin/menu');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    /**
     * nestable
     * @param Request $request
     */
    public function nestable(Request $request) {
        $menuModel = config('admin.database.menu_model');
        $menuModel::recursionNestable($request->input('nestable'));
        return ['status' => 1, 'msg' => '更新成功'];
    }

}
