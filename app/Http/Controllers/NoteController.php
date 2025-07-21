<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use App\Models\Note;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function getUserLectureNote(Request $request)
    {
        $notes = Note::with('lecture')->where('user_id', Auth::id())
            ->where('lec_id', $request->input('lec_id'))
            ->orderBy('created_at', 'desc')
            ->get();

        if ($notes->isEmpty()) {
            $notes = null;
        }

        if ($request->ajax()) {
            return ApiHelper::success(200, $notes, 'Ghi chú đã được tải thành công.');
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'lecture' => 'required|exists:lectures,lec_id',
        ]);

        try {
            $note = Note::create([
                'content' => $request->input('content'),
                'lec_id' => $request->input('lecture'),
                'user_id' => Auth::id(),
            ]);

            if ($request->ajax()) {
                return ApiHelper::success(200, $note, 'Ghi chú đã được lưu thành công.');
            }
        } catch (\Throwable $th) {
            return ApiHelper::error(500, 'Lỗi khi lưu ghi chú: ' . $th->getMessage());
        }
    }
    public function update(Request $request, Note $note)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        try {
            $note->update([
                'content' => $request->input('content'),
            ]);

            if ($request->ajax()) {
                return ApiHelper::success(200, $note, 'Ghi chú đã được cập nhật thành công.');
            }
        } catch (\Throwable $th) {
            return ApiHelper::error(500, 'Lỗi khi cập nhật ghi chú: ' . $th->getMessage());
        }
    }
    public function destroy(Request $request, Note $note)
    {
        try {
            Note::where('id', $note->id)->where('user_id', Auth::id())->delete();
            if ($request->ajax()) {
                return ApiHelper::success(200, null, 'Ghi chú đã được xóa thành công.');
            }
        } catch (\Throwable $th) {
            return ApiHelper::error(500, 'Lỗi khi xóa ghi chú: ' . $th->getMessage());
        }
    }
}
