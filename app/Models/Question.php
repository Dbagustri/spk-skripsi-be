<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'pertanyaan',
        'criteria_id',
        'bobot'
    ];

    public function criterias()
    {
        return $this->belongsTo(
            Criteria::class
        );
    }

    public function answers()
    {
        return $this->hasMany(
            QuestionnaireAnswer::class
        );
    }
}
