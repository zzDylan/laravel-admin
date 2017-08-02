<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model {

    protected $guarded = [];
    protected $table = 'admin_menu';

    public function hasChildren() {
        return self::where('parent_id', $this->id)->exists();
    }

    public function childrens() {
        return self::where('parent_id', $this->id)->get();
    }

    public function roles() {
        return $this->belongsToMany(config('admin.database.roles_model'), config('admin.database.role_menu_table'), 'menu_id', 'role_id');
    }

    public static function recursionNestable($nestableArr, $parent_id = 0) {
        foreach ($nestableArr as $key => $nestable) {
            $menu = self::find($nestable['id']);
            $menu->order = $key;
            $menu->parent_id = $parent_id;
            $menu->save();
            if (!empty($nestable['children'])) {
                self::recursionNestable($nestable['children'], $nestable['id']);
            }
        }
        return true;
    }

}
