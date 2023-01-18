<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Columns extends Model
{

    protected $table = "columns";
	
	public function cards()
    {
        return $this->hasMany('App\Models\Cards', 'column_id');
    }
	
}
