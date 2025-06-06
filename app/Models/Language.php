<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'name',
        'iso_639-1',
    ];
    protected $primaryKey = 'lang_id';
    
    public function courses()
    {
        return $this->hasMany(Course::class, 'language_id', 'lang_id');
    }
}
