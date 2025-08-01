<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // protected static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($user) {
    //         $user->slug = Str::slug($user->name . ' ' . $user->id);
    //     });
    // }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id');
    }
    public function courses()
    {
        return $this->hasMany(Course::class, 'user_id', 'id');
    }
    public function enrollments()
    {
        return $this->has(Enrollment::class, 'user_id', 'id');
    }
    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'user_id', 'course_id');
    }
    public function wishlist()
    {
        return $this->belongsToMany(Course::class, 'wishlists', 'user_id', 'course_id');
    }
    public function cartItem()
    {
        return $this->hasMany(CartItem::class, 'user_id', 'id');
    }
    public function notes()
    {
        return $this->hasMany(Note::class, 'user_id', 'id');
    }

    public function canAccessLecture($lecture)
    {
        // Kiểm tra xem người dùng có quyền truy cập vào bài giảng hay không
        return $this->enrolledCourses()->where('course_id', $lecture->section->course_id)->exists();
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id', 'id');
    }

    public function hasPermission($permission)
    {
        foreach ($this->roles as $role) {
            if ($role->permissions->where('slug', $permission)->count() > 0) {
                return true;
            }
        }
        return false;
    }

    public function lecture_progress()
    {
        return $this->belongsToMany(Lecture::class, 'user_lecture_progress', 'user_id', 'lec_id')->withPivot('progress');
    }
}
