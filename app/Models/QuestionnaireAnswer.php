<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionnaireAnswer extends Model
{
    protected $fillable = [
        'user_id',
        'question_id',
        'answer_value'
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }

    public function question()
    {
        return $this->belongsTo(
            Question::class
        );
    }
}
