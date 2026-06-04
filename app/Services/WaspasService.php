<?php

namespace App\Services;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\QuestionnaireAnswer;
use App\Models\AlternativeCriteria;
use App\Models\RecommendationResult;

class WaspasService
{
    public function calculate(
        int $userId
    ) {

        $criterias =
            Criteria::all();

        $alternatives =
            Alternative::all();

        // =====================
        // DECISION MATRIX
        // =====================

        $matrix = [];

        foreach (
            $alternatives
            as $alternative
        ) {

            foreach (
                $criterias
                as $criteria
            ) {

                // USER
                if (
                    $criteria->source
                    === 'user'
                ) {

                    $value =
                        QuestionnaireAnswer::where(
                            'user_id',
                            $userId
                        )
                        ->where(
                            'alternative_id',
                            $alternative->id
                        )
                        ->where(
                            'criteria_id',
                            $criteria->id
                        )
                        ->value('nilai') ?? 1;
                }

                // ADMIN
                else {

                    $value =
                        AlternativeCriteria::where(
                            'alternative_id',
                            $alternative->id
                        )
                        ->where(
                            'criteria_id',
                            $criteria->id
                        )
                        ->value('nilai') ?? 1;
                }

                $matrix[$alternative->kode][$criteria->kode] = $value;
            }
        }

        // =====================
        // NORMALIZATION
        // =====================

        $normalized = [];

        foreach (
            $criterias
            as $criteria
        ) {

            $column = [];

            foreach (
                $alternatives
                as $alternative
            ) {

                $column[] =
                    $matrix[$alternative->kode][$criteria->kode];
            }

            $max =
                max($column);

            $min =
                min($column);

            foreach (
                $alternatives
                as $alternative
            ) {

                $value =
                    $matrix[$alternative->kode][$criteria->kode];

                if (
                    $criteria->tipe
                    === 'benefit'
                ) {

                    $normalized[$alternative->kode][$criteria->kode] =
                        round(
                            $value
                                / $max,
                            4
                        );
                } else {

                    $normalized[$alternative->kode][$criteria->kode] =
                        round(
                            $min
                                / $value,
                            4
                        );
                }
            }
        }

        // =====================
        // WSM + WPM
        // =====================

        $wsmResults = [];
        $wpmResults = [];
        $waspasResults = [];

        foreach (
            $alternatives
            as $alternative
        ) {

            $wsm = 0;
            $wpm = 1;

            foreach (
                $criterias
                as $criteria
            ) {

                $r =
                    $normalized[$alternative->kode][$criteria->kode];

                $w =
                    $criteria->bobot;

                // WSM
                $wsm +=
                    $w * $r;

                // WPM
                $wpm *=
                    pow(
                        $r,
                        $w
                    );
            }

            $wsm =
                round(
                    $wsm,
                    5
                );

            $wpm =
                round(
                    $wpm,
                    5
                );

            $score =
                round(
                    (
                        0.5
                        * $wsm
                    )
                        +
                        (
                            0.5
                            * $wpm
                        ),
                    5
                );

            $wsmResults[] = [
                'alternative' =>
                $alternative->kode,

                'value' =>
                $wsm
            ];

            $wpmResults[] = [
                'alternative' =>
                $alternative->kode,

                'value' =>
                $wpm
            ];

            $waspasResults[] = [
                'alternative_id' =>
                $alternative->id,

                'kode' =>
                $alternative->kode,

                'nama_topik' =>
                $alternative
                    ->nama_topik,

                'score' =>
                $score,
            ];
        }

        // SORT
        usort(
            $waspasResults,
            fn(
                $a,
                $b
            ) =>
            $b['score']
                <=>
                $a['score']
        );

        foreach (
            $waspasResults
            as $index => &$item
        ) {

            $item['rank']
                =
                $index + 1;
        }

        return [

            'decision_matrix' =>
            $matrix,

            'normalized_matrix' =>
            $normalized,

            'wsm' =>
            $wsmResults,

            'wpm' =>
            $wpmResults,

            'ranking' =>
            $waspasResults,

            'recommendation' =>
            $waspasResults[0]
        ];
    }
    public function calculateFromSession(
        int $sessionId
    ) {

        $ranking =
            RecommendationResult::with(
                'alternative'
            )
            ->where(
                'recommendation_session_id',
                $sessionId
            )
            ->orderBy('rank')
            ->get();

        return [

            'recommendation' => [

                'nama_topik' =>
                $ranking
                    ->first()
                    ?->alternative
                    ?->nama_topik,

                'kompetensi_lulusan' =>
                $ranking
                    ->first()
                    ?->alternative
                    ?->kompetensi_lulusan,

                'score' =>
                $ranking
                    ->first()
                    ?->score,
            ],

            'ranking' =>
            $ranking->map(
                function ($item) {

                    return [

                        'rank' =>
                        $item->rank,

                        'kode' =>
                        $item
                            ->alternative
                            ->kode,

                        'nama_topik' =>
                        $item
                            ->alternative
                            ->nama_topik,

                        'score' =>
                        $item->score,
                    ];
                }
            )
        ];
    }
}
