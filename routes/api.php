<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RecommendationController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\QuestionnaireController;
use App\Http\Controllers\Api\StudentProfileController;
use App\Http\Controllers\Api\Admin\AlternativeController;
use App\Http\Controllers\Api\Admin\QuestionController as AdminQuestionController;
use App\Http\Controllers\Api\Admin\CriteriaController;

// AUTH 

Route::prefix('auth')->group(function () {

    Route::post(
        '/register',
        [AuthController::class, 'register']
    );

    Route::post(
        '/login',
        [AuthController::class, 'login']
    );

    Route::middleware('auth:sanctum')
        ->group(function () {

            Route::get(
                '/profile',
                [AuthController::class, 'profile']
            );

            Route::post(
                '/logout',
                [AuthController::class, 'logout']
            );
        });
});


// MAHASISWA API

Route::middleware('auth:sanctum')
    ->group(function () {

        Route::get(
            '/questions',
            [QuestionController::class, 'index']
        );

        Route::post(
            '/questionnaire',
            [QuestionnaireController::class, 'submit']
        );

        Route::get(
            '/recommendation',
            [RecommendationController::class, 'calculate']
        );

        Route::get(
            '/recommendation/history',
            [RecommendationController::class, 'history']
        );

        // Student Profile
        Route::prefix(
            'student-profile'
        )->group(function () {

            Route::get(
                '/',
                [
                    StudentProfileController::class,
                    'show'
                ]
            );

            Route::post(
                '/',
                [
                    StudentProfileController::class,
                    'store'
                ]
            );

            Route::put(
                '/',
                [
                    StudentProfileController::class,
                    'update'
                ]
            );
        });
    });


// ADMIN API
Route::prefix('admin')
    ->middleware([
        'auth:sanctum',
        'role:admin'
    ])
    ->group(function () {

        Route::get(
            '/test',
            function () {

                return response()->json([
                    'message' =>
                    'Admin only'
                ]);
            }
        );

        Route::apiResource(
            'criteria',
            CriteriaController::class
        );

        Route::apiResource(
            'alternatives',
            AlternativeController::class
        );

        Route::apiResource(
            'questions',
            AdminQuestionController::class
        );
    });
