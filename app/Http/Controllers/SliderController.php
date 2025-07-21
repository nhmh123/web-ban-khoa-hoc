<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('order', 'asc')->get();
        $maxOrder = Slider::max('order') ?? 0;
        return view('admin.pages.settings.slider-index', compact('sliders', 'maxOrder'));
    }

    public function create()
    {
        return view('admin.pages.settings.slider-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'order' => 'nullable|integer|min:0',
        ]);

        $order = (int) $request->input('order', 0);

        DB::beginTransaction();
        try {
            Slider::where('order', '>=', $order)->increment('order');

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                try {
                    $image->move('images/sliders', $imageName);
                    $imagePath = 'images/sliders/' . $imageName;
                } catch (\Throwable $th) {
                    return redirect()->back()->withErrors(['image' => 'Lỗi khi tải lên hình ảnh: ' . $th->getMessage()]);
                }
            }

            $slider = new Slider();
            $slider->image = $imagePath ?? '';
            $slider->order = $order;
            $slider->save();

            DB::commit();
            return redirect()->route('sliders.index')->with('success', 'Tạo slider thành công');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors([
                'error' => 'Có lỗi xảy ra: ' . $th->getMessage()
            ]);
        }

        // $existingSlider = Slider::where('order', $order)->first();
        // if ($existingSlider) {
        //     $currentMaxOrder = Slider::max('order') ?? 0;
        //     $existingSlider->order = $currentMaxOrder + 1;
        //     $existingSlider->save();
        // }

    }

    public function edit(Slider $slider)
    {
        return view('admin.pages.settings.slider-edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'order' => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                try {
                    $image->move('images/sliders', $imageName);
                    $slider->image = 'images/sliders/' . $imageName;
                } catch (\Throwable $th) {
                    return redirect()->back()->withErrors(['image' => 'Lỗi khi tải lên hình ảnh: ' . $th->getMessage()]);
                }
            }

            if ($request->filled('order')) {
                $newOrder = (int) $request->input('order');
                $currentOrder = $slider->order;

                if ($newOrder > $currentOrder) {
                    Slider::where('order', '>', $currentOrder)
                        ->where('order', '<=', $newOrder)
                        ->decrement('order');
                } elseif ($newOrder < $currentOrder) {
                    Slider::where('order', '>=', $newOrder)
                        ->where('order', '<', $currentOrder)
                        ->increment('order');
                }

                $slider->order = $newOrder;
            }

            $slider->save();
            DB::commit();
            return redirect()->route('sliders.index')->with('success', 'Cập nhật slider thành công');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors([
                'error' => 'Có lỗi xảy ra: ' . $th->getMessage()
            ]);
        }
    }

    public function destroy(Slider $slider)
    {
        try {
            $slider->delete();
            Slider::where('order', '>', $slider->order)->decrement('order');
            if (file_exists(public_path($slider->image))) {
                unlink(public_path($slider->image));
            }
            return response()->json(['success' => 'Slider đã được xoá thành công.']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Không thể xoá Slider. Vui lòng thử lại.'], 500);
        }
    }
}
