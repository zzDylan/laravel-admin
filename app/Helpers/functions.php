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
 * @param type $url
 * @return string
 */
function is_active($url) {
    if (url($url) == Request::url()) {
        return 'active open';
    }
    return '';
}
