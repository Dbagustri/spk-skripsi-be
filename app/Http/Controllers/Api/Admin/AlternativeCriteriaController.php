<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Alternative;
use App\Models\AlternativeCriteria;
use App\Models\Criteria;

class AlternativeCriteriaController
extends Controller
{
    /**
     * Display admin scoring
     * for all alternatives
     */
    public function index()
    {
        $alternatives =
            Alternative::with([
                'criteria.criterion'
            ])->get();

        return response()->json([
            'success' => true,
            'data' => $alternatives
        ]);
    }

    /**
     * Show single alternative
     */
    public function show(
        Alternative $alternative
    ) {

        $alternative->load([
            'criteria.criterion'
        ]);

        return response()->json([
            'success' => true,
            'data' => $alternative
        ]);
    }

    /**
     * Update admin scoring
     */
    public function update(
        Request $request,
        Alternative $alternative
    ) {

        $validated =
            $request->validate([

                'scores' =>
                'required|array|min:1',

                'scores.*.criteria_id' =>
                'required|exists:criterias,id',

                'scores.*.nilai' =>
                'required|integer|min:1|max:5',
            ]);

        foreach (
            $validated['scores']
            as $score
        ) {

            $criteria =
                Criteria::find(
                    $score['criteria_id']
                );

            // hanya admin criteria
            if (
                $criteria &&
                $criteria->source
                === 'admin'
            ) {

                AlternativeCriteria::updateOrCreate(
                    [
                        'alternative_id' =>
                        $alternative->id,

                        'criteria_id' =>
                        $score['criteria_id']
                    ],
                    [
                        'nilai' =>
                        $score['nilai']
                    ]
                );
            }
        }

        $alternative->load([
            'criteria.criterion'
        ]);

        return response()->json([
            'success' => true,

            'message' =>
            'Alternative criteria updated successfully',

            'data' =>
            $alternative
        ]);
    }
}
