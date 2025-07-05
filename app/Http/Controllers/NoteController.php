<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function getUserLectureNote(Lecture $lecture)
    {
        $notes = Note::with('lecture')->where([
            ['user_id', Auth::id()],
            ['lec_id', $lecture->lec_id],
        ])->get();
        
        if ($notes->isEmpty()) {
            $notes = null;
        }

        return response()->json(['notes' => $notes]);
    }
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'content' => [
                'required',
                function ($attribute, $value, $fail) {
                    $plainText = trim(strip_tags($value));
                    if ($plainText === '') {
                        $fail('Nội dung không được để trống.');
                    }
                },
            ],
        ])->validate();

        Note::create([
            'content' => $request->input('content'),
            'lec_id' => $request->input('lecture'),
            'user_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'Thêm ghi chú thành công']);
    }
}
