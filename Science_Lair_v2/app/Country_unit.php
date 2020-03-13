<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country_unit extends Model
{
 	protected $fillable = [
        'namegroup', 'unit', 'country',
    ];
}
