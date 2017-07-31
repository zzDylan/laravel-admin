<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'admin_role_permissions';
    
    public function admins(){
        return $this->belongsToMany('App\Models\Admin','admin_user_permissions','permission_id','user_id');
    }
    
    public function roles(){
        return $this->belongsToMany('App\Models\Role','admin_role_permissions','permission_id','role_id');
    }
    
}
