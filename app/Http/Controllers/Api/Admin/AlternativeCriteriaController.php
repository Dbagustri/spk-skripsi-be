<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alternative;
use App\Models\AlternativeCriteria;
use App\Models\Criteria;

class AlternativeCriteriaController extends Controller
{
    /**
     * Display admin scoring for all alternatives
     */
    public function index()
    {
        $alternatives = Alternative::with([
            'criteriaScores.criteria'
        ])->get();

        return response()->json([
            'success' => true,
            'data' => $alternatives
        ]);
    }

    /**
     * Update admin scoring per alternative
     */
    public function update(
        Request $request,
        Alternative $alternative
    ) {

        $request->validate([
            'scores' => 'required|array',

            'scores.*.criteria_id' =>
            'required|exists:criterias,id',

            'scores.*.nilai' =>
            'required|integer|min:1|max:5',
        ]);

        foreach (
            $request->scores
            as $score
        ) {

            // hanya admin criteria
            $criteria = Criteria::find(
                $score['criteria_id']
            );

            if (
                $criteria &&
                $criteria->source === 'admin'
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

        return response()->json([
            'success' => true,
            'message' =>
            'Alternative criteria updated successfully'
        ]);
    }
}
