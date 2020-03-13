<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
	protected $fillable = [
        'title', 'title2', 'revact', 'date', 'pubtype', 'subpubtype', 'proy',
    ];

}
