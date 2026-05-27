<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecommendationResult extends Model
{
    protected $fillable = [
        'user_id',
        'alternative_id',
        'q1_score',
        'q2_score',
        'final_score',
        'ranking'
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }

    public function alternative()
    {
        return $this->belongsTo(
            Alternative::class
        );
    }
}
