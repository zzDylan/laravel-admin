<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    protected $table = 'admin_roles';

    public function permissions() {
        return $this->belongsToMany('App\Models\Permission', 'admin_role_permissions', 'role_id', 'permission_id');
    }

    public function Admins() {
        return $this->belongsToMany('App\Models\Admin', 'admin_role_users', 'role_id', 'user_id');
    }

    public function menus(){
        return $this->belongsToMany('App\Models\Menu', 'admin_role_menu', 'role_id', 'menu_id');
    }
    
}
