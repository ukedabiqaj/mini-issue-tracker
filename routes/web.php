<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\IssueCommentController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\IssueTagController;
use App\Http\Controllers\IssueUserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/projects');

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});

Route::post('logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::resource('projects', ProjectController::class);
Route::get('issues-search', [IssueController::class, 'search'])->name('issues.search');
Route::resource('issues', IssueController::class);

Route::get('tags', [TagController::class, 'index'])->name('tags.index');
Route::post('tags', [TagController::class, 'store'])->name('tags.store');

Route::get('issues/{issue}/comments', [IssueCommentController::class, 'index'])->name('issues.comments.index');
Route::post('issues/{issue}/comments', [IssueCommentController::class, 'store'])->name('issues.comments.store');

Route::post('issues/{issue}/tags/{tag}', [IssueTagController::class, 'store'])->name('issues.tags.store');
Route::delete('issues/{issue}/tags/{tag}', [IssueTagController::class, 'destroy'])->name('issues.tags.destroy');

Route::post('issues/{issue}/users/{user}', [IssueUserController::class, 'store'])->name('issues.users.store');
Route::delete('issues/{issue}/users/{user}', [IssueUserController::class, 'destroy'])->name('issues.users.destroy');
