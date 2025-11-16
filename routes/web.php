<?php

use App\Http\Controllers\DashboardController;
use App\Livewire\ProjectDetails;
use App\Livewire\ProjectsPage;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


// Route::view('projects', 'projects')
//     ->middleware(['auth', 'verified'])
//     ->name('projects');



Route::view('data', 'data')
    ->middleware(['auth', 'verified'])
    ->name('data');

Route::view('tasks', 'tasks')
    ->middleware(['auth', 'verified'])
    ->name('tasks');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('/projects', ProjectsPage::class)->name('projects');
    Route::get('/projects/{projectId}', ProjectDetails::class)->name('project.details');


    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
