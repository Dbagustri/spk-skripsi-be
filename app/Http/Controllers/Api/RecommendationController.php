<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WaspasService;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function calculate(
        Request $request,
        WaspasService $waspasService
    ) {
        $userId =
            $request->user()->id;

        $result =
            $waspasService
            ->calculate($userId);

        return response()->json([
            'success' => true,
            'message' =>
            'Rekomendasi berhasil dihitung',
            'data' => $result
        ]);
    }

    public function history(
        Request $request
    ) {
        $results =
            $request->user()
            ->recommendationResults()
            ->with('alternative')
            ->orderBy(
                'ranking'
            )
            ->get();

        return response()->json([
            'success' => true,
            'data' => $results
        ]);
    }
}
