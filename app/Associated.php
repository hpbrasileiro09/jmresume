<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Associated extends Model
{

    protected $fillable = [
        'phone', 
        'published', 
        'department_id',
        'user_id',
        'marked',
    ];

	protected $guarded = ['id'];

	public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

	public function department()
    {
        return $this->hasOne(Department::class, 'id', 'department_id');
    }

    public function keys() 
    {
        return $this->hasMany(AssociatedKey::class);
    }

}
