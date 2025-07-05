<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'content',
        'lec_id',
        'user_id',
    ];

    public function lecture(){
        return $this->belongsTo(Lecture::class,'lec_id','lec_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
