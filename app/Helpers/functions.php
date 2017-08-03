<?php

/**
 * 将提示消息闪存到session中
 * @param type $type
 * @param type $message
 */
function admin_toastr($type,$message){
    $toastr = ['type'=>$type,'message'=>$message];
    \Illuminate\Support\Facades\Session::flash('toastr', $toastr);
}


function is_pjax(){
    if(Request::header('X-PJAX')){
        return true;
    }
    return false;
}