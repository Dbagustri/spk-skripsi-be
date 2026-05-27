<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with(
            'criteria'
        )->get();

        return response()->json([
            'success' => true,
            'message' =>
            'Daftar pertanyaan berhasil diambil',
            'data' => $questions
        ]);
    }
}
