<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommendation_results', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('alternative_id')
                ->constrained()
                ->onDelete('cascade');

            $table->decimal(
                'q1_score',
                10,
                4
            );

            $table->decimal(
                'q2_score',
                10,
                4
            );

            $table->decimal(
                'final_score',
                10,
                4
            );

            $table->integer('ranking');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendation_results');
    }
};
