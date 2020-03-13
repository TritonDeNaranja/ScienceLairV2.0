<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	protected $fillable = [
        'id', 'name_project', 'code', 'state', 'date_start', 'date_end',
    ];
}
