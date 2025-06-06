<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';

    protected $primaryKey = 'article_id';

    protected $fillable = [
        'title',
        'content',
        'duration',
        'lec_id',
    ];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class, 'lec_id', 'lec_id');
    }
}
