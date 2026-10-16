<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EvidenceController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\AIController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/about', 'about')->name('about');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/upload', [EvidenceController::class, 'create'])->name('upload');
    Route::post('/evidence', [EvidenceController::class, 'store'])->name('evidence.store');
    Route::get('/evidence', [EvidenceController::class, 'index'])->name('evidence.index');
    Route::get('/evidence/{id}', [EvidenceController::class, 'show'])->name('evidence.show');
    Route::get('/evidence/{id}/preview', [EvidenceController::class, 'preview'])->name('evidence.preview');
    Route::get('/evidence/{id}/download', [EvidenceController::class, 'download'])->name('evidence.download');

    // Case Docket Management (Lawyers, Judges, Admins)
    Route::get('/cases', [CaseController::class, 'index'])->name('cases.index');
    Route::get('/cases/create', [CaseController::class, 'create'])->name('cases.create');
    Route::post('/cases', [CaseController::class, 'store'])->name('cases.store');
    Route::get('/cases/{id}', [CaseController::class, 'show'])->name('cases.show');
    Route::get('/cases/{id}/edit', [CaseController::class, 'edit'])->name('cases.edit');
    Route::put('/cases/{id}', [CaseController::class, 'update'])->name('cases.update');
    Route::delete('/cases/{id}', [CaseController::class, 'destroy'])->name('cases.destroy');
    Route::post('/cases/{id}/evidence', [CaseController::class, 'addEvidence'])->name('cases.evidence.add');
    Route::delete('/cases/{id}/evidence/{evidenceId}', [CaseController::class, 'removeEvidence'])->name('cases.evidence.remove');
    Route::patch('/cases/{id}/evidence/{evidenceId}/notes', [CaseController::class, 'updateEvidenceNote'])->name('cases.evidence.notes');
    Route::post('/cases/{id}/assign-judge', [CaseController::class, 'assignJudge'])->name('cases.assign.judge');
    Route::delete('/cases/{id}/unassign-judge', [CaseController::class, 'unassignJudge'])->name('cases.unassign.judge');
    Route::post('/cases/{id}/reorder-evidence', [CaseController::class, 'reorderEvidence'])->name('cases.evidence.reorder');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', \App\Http\Middleware\EnsureUserIsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{id}/verify', [AdminController::class, 'verifyUser'])->name('users.verify');
    Route::post('/users/{id}/reject', [AdminController::class, 'rejectUser'])->name('users.reject');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
});

// AI Features
Route::middleware('auth')->prefix('ai')->name('ai.')->group(function () {
    Route::get('/', [AIController::class, 'index'])->name('index');
    Route::get('/evidence/analyze', [AIController::class, 'evidenceAnalysis'])->name('evidence-analysis');
    Route::post('/evidence/analyze', [AIController::class, 'analyzeEvidence'])->name('evidence.analyze');
    Route::get('/evidence/{evidenceId}/results', [AIController::class, 'evidenceResults'])->name('evidence.results');
    Route::get('/cases/summarize', [AIController::class, 'caseSummary'])->name('case-summary');
    Route::post('/cases/summarize', [AIController::class, 'summarizeCase'])->name('case.summarize');
    Route::get('/cases/{caseId}/results', [AIController::class, 'caseResults'])->name('case.results');
});

require __DIR__.'/auth.php';
