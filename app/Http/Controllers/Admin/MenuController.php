<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class MenuController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $menuModel = config('admin.database.menu_model');
        $roleModel = config('admin.database.roles_model');
        $menus = $menuModel::where('parent_id', 0)->orderBy('order')->get();
        $roles = $roleModel::all();
        return view('admin.menu.index', [
            'menus' => $menus,
            'roles' => $roles
        ]);
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
        $menuModel = config('admin.database.menu_model');
        $menu = $menuModel::create([
                    'parent_id' => $input['parent_id'],
                    'title' => $input['title'],
                    'icon' => $input['icon'],
                    'uri' => $input['uri']
        ]);
        $roleModel = config('admin.database.roles_model');
        foreach ($input['roles'] as $role) {
            $roleModel::create([
                'role_id' => $role,
                'menu_id' => $menu->id
            ]);
        }
        admin_toastr('success', '添加成功');
        return redirect(config('admin.prefix') . '/menu');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $menuModel = config('admin.database.menu_model');
        $roleModel = config('admin.database.roles_model');
        $menus = $menuModel::where('parent_id', 0)->orderBy('order')->get();
        $roles = $roleModel::all();
        $menu = $menuModel::find($id);
        return view('admin.menu.edit', [
            'menus' => $menus,
            'roles' => $roles,
            'menuRoles' => array_column($menu->roles->toArray(), 'id'),
            'targetMenu' => $menu
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
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
        $menuModel = config('admin.database.menu_model');
        $allChildrenIds = $menuModel::allChildrenIds($id);
        if (in_array($input['parent_id'], $allChildrenIds) || $id == $input['parent_id']) {
            admin_toastr('error', '父级选择错误');
            return back()->withInput();
        }
        $menu = $menuModel::find($id);
        $menu->update([
            'parent_id' => $input['parent_id'],
            'title' => $input['title'],
            'icon' => $input['icon'],
            'uri' => $input['uri']
        ]);
        admin_toastr('success', '更新成功');
        return redirect(config('admin.prefix') . '/menu');
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
