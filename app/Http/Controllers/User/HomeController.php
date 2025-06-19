<?php

namespace App\Http\Controllers\User;

use App\Enums\CourseEnum;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $popularCourses = Course::with('user:id,name')->where('status', CourseEnum::PUBLISHED->value)->distinct()->limit(4)->get();
        $courses = Course::where('status', CourseEnum::PUBLISHED->value)->get();
        return view('user.pages.home', compact('popularCourses', 'courses'));
    }
}
