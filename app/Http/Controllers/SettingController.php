<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        // dd($settings);
        return view('admin.pages.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'favicon' => 'nullable|image|mimes:png,ico,svg|max:2048',
        ]);

        $settings = [
            'meta.site_name' => $request->input('site_name'),
            'meta.title' => $request->input('meta_title'),
            'meta.description' => $request->input('meta_description'),
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        // if ($request->hasFile('favicon')) {
        //     $file = $request->file('favicon');
        //     $path = $file->store('public/favicon');
        //     $url = Storage::url($path);

        //     Setting::updateOrCreate(
        //         ['key' => 'favicon'],
        //         ['value' => $url]
        //     );
        // }

        return redirect()->back()->with('success', 'Đã cập nhật cấu hình SEO thành công.');
    }

    public function emailSettingEdit()
    {
        return view('admin.pages.settings.email-edit');
    }

    public function emailSettingUpdate(Request $request)
    {
        $request->validate([
            'MAIL_HOST' => 'required|string|max:255',
            'MAIL_PORT' => 'required|integer',
            'MAIL_USERNAME' => 'required|string|max:255',
            'MAIL_PASSWORD' => 'required|string|max:255',
            'MAIL_FROM_ADDRESS' => 'required|email|max:255',
            'MAIL_FROM_NAME' => 'required|string|max:255',
        ]);

        $settings = [
            'mail.host' => $request->input('MAIL_HOST'),
            'mail.port' => $request->input('MAIL_PORT'),
            'mail.username' => $request->input('MAIL_USERNAME'),
            'mail.password' => str_replace(' ', '', $request->input('MAIL_PASSWORD')),
            'mail.from_address' => $request->input('MAIL_FROM_ADDRESS'),
            'mail.from_name' => $request->input('MAIL_FROM_NAME'),
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Cấu hình email đã được cập nhật thành công.');
    }

    public function contactSettingEdit()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.pages.settings.contact-edit', compact('settings'));
    }
    public function contactSettingUpdate(Request $request)
    {
        $request->validate([
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_address' => 'nullable|string|max:255',
        ]);

        $settings = [
            'contact.email' => $request->input('contact_email'),
            'contact.phone' => $request->input('contact_phone'),
            'contact.address' => $request->input('contact_address'),
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Cấu hình liên hệ đã được cập nhật thành công.');
    }

    public function socialSettingEdit()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.pages.settings.social-edit');
    }

    public function socialSettingUpdate(Request $request)
    {
        $request->validate([
            'facebook' => 'nullable|url|max:255',
            'x' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'instargram' => 'nullable|url|max:255',
        ]);

        $settings = [
            'social.facebook' => $request->input('facebook'),
            'social.x' => $request->input('x'),
            'social.linkedin' => $request->input('linkedin'),
            'social.instagram' => $request->input('instagram'),
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Cấu hình mạng xã hội đã được cập nhật thành công.');
    }
}
