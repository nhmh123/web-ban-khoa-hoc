<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    protected $table = 'course_categories';
    protected $primaryKey = 'cc_id';
    public $timestamps = true;
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'cc_name',
        'cc_slug',
        'icon_path',
        'type',
        'user_id',
        'parent_id',
        'status',
    ];

    // App\Models\CourseCategory.php

    public function getFullSlugPathAttribute(): string
    {
        $category = $this;
        $slugs = [];

        while ($category) {
            $slugs[] = $category->cc_slug;
            $category = $category->parent; // sẽ trả về null nếu không có parent
        }

        return implode('/', array_reverse($slugs)); // đảo ngược lại đúng thứ tự
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(CourseCategory::class, 'parent_id', 'cc_id');
    }

    public function children()
    {
        return $this->hasMany(CourseCategory::class, 'parent_id', 'cc_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'cat_id', 'cc_id');
    }
}
