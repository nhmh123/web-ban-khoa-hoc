<?php

namespace App\Services;

class CourseService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getCourseCompletion($user, $course)
    {
        $totalLectures = 0;
        $totalSection = $course->sections;
        foreach ($totalSection as $section) {
            $totalLectures += $section->lectures->count();
        };
        $courseLectures = $course->sections->flatMap(function ($section) {
            return $section->lectures->pluck('lec_id');
        });
        $completedLectures = $user->lecture_progress()->where('progress', 100)->whereIn('lectures.lec_id', $courseLectures)->get();
        $completion = $totalLectures > 0 ? round($completedLectures->count() / $totalLectures * 100) : 0;

        return $completion;
    }
}
