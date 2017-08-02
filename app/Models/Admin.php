<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $guarded = [];
    protected $table = 'admin_users';
    
    public function roles(){
        return $this->belongsToMany(config('admin.database.roles_model'), config('admin.database.role_users_table'), 'user_id', 'role_id');
    }
    
    public function permissions() {
        return $this->belongsToMany(config('admin.database.permissions_table'), config('admin.database.user_permissions_table'), 'user_id', 'permission_id');
    }
    
    public function inRole($slug){
        return $this->roles()->where('slug',$slug)->exists();
    }
    
    public function visible($menuRoles){
        if($menuRoles->isEmpty()){
            return true;
        }
        if(!is_array($menuRoles)){
            $menuRoles = $menuRoles->toArray();
        }
        $slugArr = array_column($menuRoles, 'slug');
        foreach($slugArr as $slug){
            if($this->inRole($slug)){
                return true;
            }
        }
        return false;
    }
    
}
