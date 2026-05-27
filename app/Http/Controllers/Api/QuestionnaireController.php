<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QuestionnaireAnswer;
use App\Services\WaspasService;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    public function submit(
        Request $request,
        WaspasService $waspasService
    ) {
        $validated =
            $request->validate([
                'answers' =>
                'required|array',

                'answers.*.question_id' =>
                'required|exists:questions,id',

                'answers.*.answer_value' =>
                'required|integer|min:1|max:5'
            ]);

        $user =
            $request->user();

        // hapus jawaban lama
        QuestionnaireAnswer::where(
            'user_id',
            $user->id
        )->delete();

        // simpan jawaban baru
        foreach (
            $validated['answers']
            as $answer
        ) {

            QuestionnaireAnswer::create([
                'user_id' =>
                $user->id,

                'question_id' =>
                $answer['question_id'],

                'answer_value' =>
                $answer['answer_value'],
            ]);
        }

        // hitung rekomendasi
        $result =
            $waspasService
            ->calculate(
                $user->id
            );

        return response()->json([
            'success' => true,
            'message' =>
            'Kuesioner berhasil disimpan',
            'recommendation' =>
            $result
        ]);
    }
}
