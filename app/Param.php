<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Param extends Model
{

    protected $fillable = [
		'label',
		'value',
		'default',
		'dt_params',
    ];

	protected $guarded = ['id'];

}
