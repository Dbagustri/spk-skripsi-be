<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\QuestionnaireController;
use App\Http\Controllers\Api\RecommendationController;
use App\Http\Controllers\Api\Admin\AlternativeController;
use App\Http\Controllers\Api\Admin\CriteriaController;
use App\Http\Controllers\Api\Admin\AlternativeCriteriaController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\ResultController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {

    Route::post(
        '/register',
        [AuthController::class, 'register']
    );

    Route::post(
        '/login',
        [AuthController::class, 'login']
    );

    Route::middleware(
        'auth:sanctum'
    )->group(function () {

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

/*
|--------------------------------------------------------------------------
| USER API (Mahasiswa + Admin)
|--------------------------------------------------------------------------
*/

Route::middleware(
    'auth:sanctum'
)->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/me',
        [AuthController::class, 'me']
    );

    /*
    |--------------------------------------------------------------------------
    | Read Only
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/criteria',
        [CriteriaController::class, 'index']
    );

    Route::get(
        '/alternatives',
        [AlternativeController::class, 'index']
    );

    /*
    |--------------------------------------------------------------------------
    | Questionnaire
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/questionnaire',
        [
            QuestionnaireController::class,
            'index'
        ]
    );

    Route::post(
        '/questionnaire',
        [
            QuestionnaireController::class,
            'submit'
        ]
    );

    /*
    |--------------------------------------------------------------------------
    | Recommendation / WASPAS
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/recommendation',
        [
            RecommendationController::class,
            'calculate'
        ]
    );

    Route::get(
        '/recommendation/latest',
        [
            RecommendationController::class,
            'latest'
        ]
    );

    Route::get(
        '/recommendation/history',
        [
            RecommendationController::class,
            'history'
        ]
    );

    Route::get(
        '/recommendation/detail',
        [
            RecommendationController::class,
            'detail'
        ]
    );

    Route::get(
        '/recommendation/history/{id}',
        [
            RecommendationController::class,
            'historyDetail'
        ]
    );
});

/*
|--------------------------------------------------------------------------
| ADMIN API
|--------------------------------------------------------------------------
*/

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

        /*
        |--------------------------------------------------------------------------
        | Criteria CRUD
        |--------------------------------------------------------------------------
        */
        /*
|--------------------------------------------------------------------------
| Users
|--------------------------------------------------------------------------
*/

        Route::get(
            '/users',
            [UserController::class, 'index']
        );

        /*
|--------------------------------------------------------------------------
| Results
|--------------------------------------------------------------------------
*/

        Route::get(
            '/results',
            [ResultController::class, 'index']
        );

        Route::apiResource(
            'criteria',
            CriteriaController::class
        );

        /*
        |--------------------------------------------------------------------------
        | Alternatives CRUD
        |--------------------------------------------------------------------------
        */

        Route::apiResource(
            'alternatives',
            AlternativeController::class
        );

        /*
        |--------------------------------------------------------------------------
        | Alternative Criteria Scoring
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/alternative-criteria',
            [
                AlternativeCriteriaController::class,
                'index'
            ]
        );

        Route::put(
            '/alternative-criteria/{alternative}',
            [
                AlternativeCriteriaController::class,
                'update'
            ]
        );
    });
