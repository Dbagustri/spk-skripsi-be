<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudentProfile;
use Illuminate\Http\Request;

class StudentProfileController extends Controller
{
    public function show(Request $request)
    {
        $profile = StudentProfile::where(
            'user_id',
            $request->user()->id
        )->first();

        return response()->json([
            'success' => true,
            'message' =>
            'Profil berhasil diambil',
            'data' => $profile
        ]);
    }

    public function store(Request $request)
    {
        $validated =
            $request->validate([

                'nim' =>
                'required|string|unique:student_profiles,nim',

                'semester' =>
                'required|integer|min:1|max:14',

                'ipk' =>
                'nullable|numeric|min:0|max:4',

                'minat' =>
                'nullable|string|max:255',
            ]);

        $profile =
            StudentProfile::create([

                'user_id' =>
                $request->user()->id,

                'nim' =>
                $validated['nim'],

                'semester' =>
                $validated['semester'],

                'ipk' =>
                $validated['ipk'] ?? null,

                'minat' =>
                $validated['minat'] ?? null,
            ]);

        return response()->json([
            'success' => true,
            'message' =>
            'Profil berhasil dibuat',
            'data' => $profile
        ], 201);
    }

    public function update(
        Request $request
    ) {
        $profile =
            StudentProfile::where(
                'user_id',
                $request->user()->id
            )->first();

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' =>
                'Profil tidak ditemukan'
            ], 404);
        }

        $validated =
            $request->validate([

                'nim' =>
                'required|string|unique:student_profiles,nim,' . $profile->id,

                'semester' =>
                'required|integer|min:1|max:14',

                'ipk' =>
                'nullable|numeric|min:0|max:4',

                'minat' =>
                'nullable|string|max:255',
            ]);

        $profile->update(
            $validated
        );

        return response()->json([
            'success' => true,
            'message' =>
            'Profil berhasil diupdate',
            'data' => $profile
        ]);
    }
}
