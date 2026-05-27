<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' =>
            Question::with(
                'criterias'
            )->get()
        ]);
    }

    public function store(
        Request $request
    ) {
        $validated =
            $request->validate([

                'pertanyaan' =>
                'required|string',

                'criteria_id' =>
                'required|exists:criterias,id',

                'bobot' =>
                'nullable|integer|min:1'
            ]);

        $question =
            Question::create([
                'pertanyaan' =>
                $validated['pertanyaan'],

                'criteria_id' =>
                $validated['criteria_id'],

                'bobot' =>
                $validated['bobot'] ?? 1
            ]);

        return response()->json([
            'success' => true,
            'message' =>
            'Pertanyaan berhasil dibuat',
            'data' =>
            $question
        ]);
    }

    public function show(
        Question $question
    ) {
        return response()->json([
            'success' => true,
            'data' =>
            $question->load(
                'criterias'
            )
        ]);
    }

    public function update(
        Request $request,
        Question $question
    ) {
        $question->update(
            $request->all()
        );

        return response()->json([
            'success' => true,
            'message' =>
            'Pertanyaan berhasil diupdate',
            'data' =>
            $question
        ]);
    }

    public function destroy(
        Question $question
    ) {
        $question->delete();

        return response()->json([
            'success' => true,
            'message' =>
            'Pertanyaan berhasil dihapus'
        ]);
    }
}
