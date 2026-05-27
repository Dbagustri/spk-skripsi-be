<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'bobot',
        'tipe',
        'deskripsi'
    ];

    public function alternativeCriteria()
    {
        return $this->hasMany(
            AlternativeCriteria::class
        );
    }

    public function questions()
    {
        return $this->hasMany(
            Question::class
        );
    }
}
