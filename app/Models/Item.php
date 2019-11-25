<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = "items";

    protected $fillable = [
        "name"
    ];

    protected $hidden = [
        "created_at", "updated_at"
    ];

    public function menu()
    {
        return $this->belongsTo("App\Models\Menu");
    }
}
