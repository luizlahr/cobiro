<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table= "menus";

    protected $fillable = [
        "name", "max_children"
    ];

    protected $hidden = [
        "created_at", "updated_at"
    ];

    public function items()
    {
        return $this->hasMany("App\Models\Item");
    }
}
