<?php

/**
 * 将提示消息闪存到session中
 * @param type $type
 * @param type $message
 */
function admin_toastr($type, $message) {
    $toastr = ['type' => $type, 'message' => $message];
    \Illuminate\Support\Facades\Session::flash('toastr', $toastr);
}

/**
 * 判断左侧菜单是否active
 * @param type $menu_id
 * @return string
 */
function is_active($menu_id) {
    $menuModel = config('admin.database.menu_model');
    $currentUrl = url(config('admin.prefix').'/'.$menuModel::find($menu_id)->uri);
    $allChildrenUrls = $menuModel::allChildrenUrls($menu_id);
    if (in_array(Request::url(), $allChildrenUrls) || Request::url() == $currentUrl) {
        return 'active open';
    }
    return '';
}

/**
 * 返回定时器报错页面
 * @param type $type
 * @param type $message
 * @return view
 */
function jump($message, $jumpUrl = '/admin', $type = 'error') {
	return view('jump', ['type' => $type, 'jumpUrl' => $jumpUrl, 'message' => $message]);
}