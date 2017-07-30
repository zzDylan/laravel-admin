<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model {

    protected $table = 'admin_menu';

    public function hasChildren() {
        if(self::where('parent_id', $this->id)->first()){
            return true;
        }
        return false;
    }
    
    public function children(){
        return self::where('parent_id', $this->id)->get();
    }
    
}
