<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Investigator extends Model
{
    protected $fillable = [
        'name', 'passportnumber', 'state','associatedunit',
    ];

}
