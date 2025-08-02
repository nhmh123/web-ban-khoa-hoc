<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Enums\CourseEnum;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use App\Http\Controllers\Controller;
use LaravelLang\StarterKits\Plugins\React;

class HomeController extends Controller
{
    public function index()
    {
        $popularCourses = Course::with('user:id,name')->where('status', CourseEnum::PUBLISHED->value)->distinct()->limit(4)->get();
        $courses = Course::where('status', CourseEnum::PUBLISHED->value)->get();
        return view('user.pages.home', compact('popularCourses', 'courses'));
    }

    public function showCourseOfCategory(Request $request, $slugPath)
    {
        $slugs = array_reverse(explode('/', $slugPath));
        // $categories = CourseCategory::whereIn('cc_slug', $slugs)->get();
        // foreach ($slugs as $slug) {
        $category = CourseCategory::where([
            ['cc_slug', $slugs[0]],
            ['status', '=', 1]
        ])->first();

        if ($category && $category->courses()->exists()) {
            $coursesQuery = $category->courses()->with('user');

            $sortBy = 'created_at';
            $sortOrder = 'asc';

            if ($request->has('sortBy')) {
                switch ($request->sortBy) {
                    case 'lastest':
                        $sortOrder = 'desc';
                        break;
                    case 'price_low':
                        $sortBy = 'original_price';
                        break;
                    case 'price_high':
                        $sortBy = 'original_price';
                        $sortOrder = 'desc';
                        break;
                    default:
                        break;
                }
            }

            if ($request->has('rating')) {
                $rating = (float) $request->rating;
                $coursesQuery->where('rating', '>=', $rating);
            }

            if ($request->has('duration')) {
                $coursesQuery->where(function ($query) use ($request) {
                    foreach ($request->duration as $value) {
                        [$min, $max] = explode('-', $value);
                        $minSeconds = (int)$min * 3600;
                        $maxSeconds = (int)$max * 3600;
                        $query->orWhereBetween('duration', [$minSeconds, $maxSeconds]);
                    }
                });
            }

            $courses = $coursesQuery->orderBy($sortBy, $sortOrder)->paginate(6);

            return view('user.pages.courses-by-category', compact('category', 'courses'));
        }
        // }
        return view('user.pages.courses-by-category', [
            'courses' => collect(),
            'category' => $category,
            'message' => 'Không tìm thấy khóa học nào trong các danh mục này'
        ]);
    }

    public function search(Request $request)
    {
        $courseQuery = Course::where('status', CourseEnum::PUBLISHED->value);
        $sortBy = 'created_at';
        $sortOrder = 'asc';

        if ($request->has('q')) {
            $searchKey = Str::of($request->query('q'))->trim();
            $courseQuery->whereRaw("name LIKE N'%{$searchKey}%'");
        }

        if ($request->has('sortBy')) {
            switch ($request->sortBy) {
                case 'lastest':
                    $sortOrder = 'desc';
                    break;
                case 'price_low':
                    $sortBy = 'original_price';
                    break;
                case 'price_high':
                    $sortBy = 'original_price';
                    $sortOrder = 'desc';
                    break;
                default:
                    break;
            }
        }

        if ($request->has('rating')) {
            $rating = (float) $request->rating;
            $courseQuery->where('rating', '>=', $rating);
        }

        if ($request->has('duration')) {
            $courseQuery->where(function ($query) use ($request) {
                foreach ($request->duration as $value) {
                    [$min, $max] = explode('-', $value);
                    $minSeconds = (int)$min * 3600;
                    $maxSeconds = (int)$max * 3600;
                    $query->orWhereBetween('duration', [$minSeconds, $maxSeconds]);
                }
            });
        }

        $courses = $courseQuery->orderBy($sortBy, $sortOrder)->paginate(6);
        return view('user.pages.search', compact('courses'));
    }
}
