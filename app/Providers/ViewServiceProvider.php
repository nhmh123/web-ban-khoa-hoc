<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\Slider;
use App\Models\Setting;
use App\Models\CourseCategory;
use App\Enums\StaticPageTypeEnum;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('user.partials.main-menu', function ($view) {
            $categories = CourseCategory::select('cc_id', 'cc_name', 'cc_slug', 'parent_id')
                ->with(['children' => function ($query) {
                    $query->select('cc_id', 'cc_name', 'cc_slug', 'parent_id');
                }])
                ->where('status', 1)
                ->whereNull('parent_id')
                ->get();
            return  $view->with('categories', $categories);
        });

        view()->composer('user.partials.header', function ($view) {
            $rootCategories = CourseCategory::select('cc_id', 'cc_name', 'cc_slug', 'parent_id')
                ->where('status', 1)
                ->whereNull('parent_id')
                ->get();
            return $view->with('rootCategories', $rootCategories);
        });

        view()->composer('user.partials.footer', function ($view) {
            $settings = Setting::pluck('value', 'key')->toArray();

            $companyPages = Page::where('type', 'company')
                ->where('is_active', true)
                ->get();

            $legalPages = Page::where('type', 'legal')
                ->where('is_active', true)
                ->get();

            $view->with([
                'settings' => $settings,
                'companyPages' => $companyPages,
                'legalPages' => $legalPages
            ]);
        });

        view()->composer('user.partials.slider',function($view){
            $sliders = Slider::orderBy('order', 'asc')->get();
            $maxOrder = Slider::max('order') ?? 0;
            return $view->with(compact('sliders', 'maxOrder'));
        });

        view()->composer('*', function ($view) {
            $settings = Setting::pluck('value', 'key')->toArray();
            $view->with('settings', $settings);
        });
    }
}
