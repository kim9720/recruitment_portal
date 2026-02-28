<?php

use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('jobs_index', [JobController::class, 'index'])->name('jobs.index');
Route::get('guest_job_show/{job}', [JobController::class, 'guestJobShow'])->name('jobs.guest_job_show');
Route::get('announcements', [AnnouncementsController::class, 'index'])->name('announcements.index');
Route::get('news', [NewsController::class, 'index'])->name('news.index');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::middleware(['role:candidate|hr|admin', 'verified'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::middleware('role:candidate')->prefix('candidate')->name('candidate.')->group(function () {
        Route::get('dashboard', [CandidateController::class, 'index'])->name('dashboard');
        //personal details routes
        Route::prefix('personal_details')->name('personal_details.')->group(function () {
            Route::get('/', [CandidateController::class, 'personalDetails'])->name('index');
            Route::get('create', [CandidateController::class, 'createPersonalDetails'])->name('create');
            Route::post('store', [CandidateController::class, 'storePersonalDetails'])->name('store');
            Route::get('edit', [CandidateController::class, 'editPersonalDetails'])->name('edit');
            Route::put('update/{id}', [CandidateController::class, 'updatePersonalDetails'])->name('update');
            Route::post('destroy/{id}', [CandidateController::class, 'destroyProfile'])->name('destroy');
        });
        //education details routes
        Route::prefix('academic_details')->name('academic_details.')->group(function () {
            Route::get('/', [CandidateController::class, 'academicDetails'])->name('index');
            Route::get('create', [CandidateController::class, 'createAcademicDetails'])->name('create');
            Route::post('store', [CandidateController::class, 'storeAcademicDetails'])->name('store');
            Route::get('edit/{id}', [CandidateController::class, 'editAcademicDetails'])->name('edit');
            Route::put('update/{id}', [CandidateController::class, 'updateAcademicDetails'])->name('update');
            Route::post('destroy/{id}', [CandidateController::class, 'destroyAcademicDetails'])->name('destroy');
        });
        //referees route
        Route::prefix('referees')->name('referees.')->group(function () {
            Route::get('/', [CandidateController::class, 'candidateReferences'])->name('index');
            // Route::get('create', [CandidateController::class, 'createCandidateReference'])->name('create');
            Route::post('store', [CandidateController::class, 'storeCandidateReference'])->name('store');
            Route::get('edit/{id}', [CandidateController::class, 'editCandidateReference'])->name('edit');
            Route::put('update/{id}', [CandidateController::class, 'updateCandidateReference'])->name('update');
            Route::post('destroy/{id}', [CandidateController::class, 'destroyCandidateReference'])->name('destroy');
        });
        //attachments routes
        Route::prefix('attachments')->name('attachments.')->group(function () {
            Route::get('/', [CandidateController::class, 'attachments'])->name('index');
            Route::post('store', [CandidateController::class, 'storeAttachment'])->name('store');
            Route::put('update/{id}', [CandidateController::class, 'updateAttachment'])->name('update');
            Route::post('destroy/{id}', [CandidateController::class, 'destroyAttachment'])->name('destroy');
        });
        //work experience routes
        Route::prefix('work_experience')->name('work_experience.')->group(function () {
            Route::get('/', [CandidateController::class, 'workExperience'])->name('index');
            Route::get('create', [CandidateController::class, 'createWorkExperience'])->name('create');
            Route::post('store', [CandidateController::class, 'storeWorkExperience'])->name('store');
            Route::get('edit/{id}', [CandidateController::class, 'editWorkExperience'])->name('edit');
            Route::put('update/{id}', [CandidateController::class, 'updateWorkExperience'])->name('update');
            Route::post('destroy/{id}', [CandidateController::class, 'destroyWorkExperience'])->name('destroy');
        });
        //vacancies routes
        Route::prefix('vacancies')->name('vacancies.')->group(function () {
            Route::get('/', [CandidateController::class, 'vacancies'])->name('index');
            Route::get('show/{id}', [CandidateController::class, 'showVacancy'])->name('show');
            Route::post('apply/{id}', [CandidateController::class, 'applyForVacancy'])->name('apply');
            Route::get('my_applications', [CandidateController::class, 'myApplications'])->name('my_applications');
        });
    });


    Route::middleware('role:hr|admin')->group(function () {
        Route::get('jobs/my-list', [JobController::class, 'jobList'])->name('jobs.list');
        Route::post('jobs', [JobController::class, 'store'])->name('jobs.store');
        Route::post('job_destroy/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
        Route::get('job_show/{job}', [JobController::class, 'show'])->name('jobs.show');

        Route::get('candidate/dashboard', [CandidateController::class, 'index'])->name('candidate.index');
        Route::get('candidates', [CandidateController::class, 'allIndex'])->name('candidates.index');
        Route::get('candidates/{candidate}', [CandidateController::class, 'show'])->name('candidate.show');

        //appication routes {candidate} binding
        Route::group(['prefix' => 'applications', 'as' => 'applications.'], function () {
            Route::get('', [ApplicationController::class, 'index'])->name('index');
            Route::get('show/{application}', [ApplicationController::class, 'show'])->name('show');
            Route::post('update_status/{application}', [ApplicationController::class, 'updateStatus'])->name('update_status');
        });
    });

    Route::middleware('role:admin')->prefix('settings')->name('settings.')->group(function () {
        Route::get('general', [SettingsController::class, 'general'])->name('general');
        Route::post('general', [SettingsController::class, 'updateGeneral'])->name('general.update');

        Route::get('users', [SettingsController::class, 'users'])->name('users');
        Route::post('users', [SettingsController::class, 'storeUser'])->name('users.store');
        Route::get('users/{user}', [SettingsController::class, 'showUser'])->name('users.show');
        Route::patch('users/{user}', [SettingsController::class, 'updateUser'])->name('users.update');
        Route::delete('users/{user}', [SettingsController::class, 'destroyUser'])->name('users.destroy');

        Route::get('permissions', [SettingsController::class, 'permissions'])->name('permissions');
        Route::post('permissions', [SettingsController::class, 'updatePermissions'])->name('permissions.update');

        Route::get('logs', [SettingsController::class, 'logs'])->name('logs');
        Route::get('logs/export', [SettingsController::class, 'exportLogs'])->name('logs.export');
    });
});

require __DIR__ . '/auth.php';
