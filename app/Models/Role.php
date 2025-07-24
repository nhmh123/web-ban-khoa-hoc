<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];
    protected $primaryKey = 'role_id';
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id');
    }
}
