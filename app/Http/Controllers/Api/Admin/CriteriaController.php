<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Criteria::all()
        ]);
    }

    public function store(
        Request $request
    ) {
        $validated =
            $request->validate([

                'kode' =>
                'required|unique:criterias',

                'nama' =>
                'required|string|max:255',

                'bobot' =>
                'required|numeric',

                'tipe' =>
                'required|in:benefit,cost',

                'deskripsi' =>
                'nullable|string'
            ]);

        $criteria =
            Criteria::create(
                $validated
            );

        return response()->json([
            'success' => true,
            'message' =>
            'Kriteria berhasil dibuat',
            'data' =>
            $criteria
        ]);
    }

    public function show(
        Criteria $criteria
    ) {
        return response()->json([
            'success' => true,
            'data' =>
            $criteria
        ]);
    }

    public function update(
        Request $request,
        Criteria $criteria
    ) {
        $criteria->update(
            $request->all()
        );

        return response()->json([
            'success' => true,
            'message' =>
            'Kriteria berhasil diupdate',
            'data' =>
            $criteria
        ]);
    }

    public function destroy($id)
    {
        $criteria =
            Criteria::findOrFail($id);

        $criteria->delete();

        return response()->json([
            'success' => true,
            'message' =>
            'Kriteria berhasil dihapus'
        ]);
    }
}
