<?php

namespace App\Services;

use App\Models\Criteria;
use App\Models\Alternative;
use App\Models\QuestionnaireAnswer;
use App\Models\RecommendationResult;

class WaspasService
{
    public function calculate($userId)
    {
        // ==========================
        // 1. Ambil data
        // ==========================

        $criteria = Criteria::all();

        $alternatives = Alternative::with(
            'criteria.criterion'
        )->get();

        $answers = QuestionnaireAnswer::with(
            'question'
        )
            ->where('user_id', $userId)
            ->get();

        // ==========================
        // 2. Bentuk bobot user
        // ==========================

        $userWeights = [];

        foreach ($criteria as $criterion) {

            $filtered = $answers->filter(
                function ($answer)
                use ($criterion) {

                    return
                        $answer->question
                        ->criteria_id
                        ==
                        $criterion->id;
                }
            );

            // rata-rata jawaban per kriteria
            $avg =
                $filtered->avg(
                    'answer_value'
                ) ?? 1;

            $userWeights[$criterion->id] = $avg;
        }

        // normalisasi bobot user
        $totalWeight =
            array_sum(
                $userWeights
            );

        foreach (
            $userWeights
            as $key => $weight
        ) {
            $userWeights[$key] =
                $weight
                /
                $totalWeight;
        }

        // ==========================
        // 3. Cari nilai max/min
        // ==========================

        $criteriaStats = [];

        foreach ($criteria as $criterion) {

            $values = [];

            foreach (
                $alternatives
                as $alternative
            ) {

                foreach (
                    $alternative->criteria
                    as $item
                ) {

                    if (
                        $item->criteria_id
                        ==
                        $criterion->id
                    ) {

                        $values[] =
                            $item->nilai;
                    }
                }
            }

            $criteriaStats[$criterion->id] = [
                'max' =>
                max($values),

                'min' =>
                min($values),

                'type' =>
                $criterion->tipe
            ];
        }

        // ==========================
        // 4. Hitung WASPAS
        // ==========================

        $results = [];

        foreach (
            $alternatives
            as $alternative
        ) {

            $q1 = 0;
            $q2 = 1;

            foreach (
                $alternative->criteria
                as $item
            ) {

                $criteriaId =
                    $item->criteria_id;

                $weight =
                    $userWeights[$criteriaId];

                $value =
                    $item->nilai;

                $type =
                    $criteriaStats[$criteriaId]['type'];

                // ==================
                // Normalisasi
                // ==================

                if (
                    $type
                    ===
                    'benefit'
                ) {

                    $normalized =
                        $value
                        /
                        $criteriaStats[$criteriaId]['max'];
                } else {

                    $normalized =
                        $criteriaStats[$criteriaId]['min']
                        /
                        $value;
                }

                // ==================
                // WSM
                // ==================

                $q1 +=
                    $normalized
                    * $weight;

                // ==================
                // WPM
                // ==================

                $q2 *= pow(
                    $normalized,
                    $weight
                );
            }

            // ==================
            // Final Qi
            // ==================

            $finalScore =
                (0.5 * $q1)
                +
                (0.5 * $q2);

            $results[] = [

                'alternative_id' =>
                $alternative->id,

                'nama_topik' =>
                $alternative
                    ->nama_topik,

                'q1_score' =>
                round(
                    $q1,
                    4
                ),

                'q2_score' =>
                round(
                    $q2,
                    4
                ),

                'final_score' =>
                round(
                    $finalScore,
                    4
                ),
            ];
        }

        // ==========================
        // 5. Ranking
        // ==========================

        usort(
            $results,
            fn($a, $b) =>
            $b['final_score']
                <=>
                $a['final_score']
        );

        // ==========================
        // 6. Simpan history
        // ==========================

        RecommendationResult::where(
            'user_id',
            $userId
        )->delete();

        foreach (
            $results
            as $index => $result
        ) {

            RecommendationResult::create([

                'user_id' =>
                $userId,

                'alternative_id' =>
                $result['alternative_id'],

                'q1_score' =>
                $result['q1_score'],

                'q2_score' =>
                $result['q2_score'],

                'final_score' =>
                $result['final_score'],

                'ranking' =>
                $index + 1,
            ]);
        }

        return $results;
    }
}
