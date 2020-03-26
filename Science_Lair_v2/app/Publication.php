<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//Where _id is your manual primary key 

class Publication extends Model
{
    protected $primaryKey = 'title';
	protected $fillable = [
        'title', 'title2', 'revact', 'date', 'pubtype', 'subpubtype', 'proy',
    ];
    
}
