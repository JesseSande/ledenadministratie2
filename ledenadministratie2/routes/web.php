<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContributionOverviewController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\MembershipTypeController;
use App\Http\Controllers\FiscalYearController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\MemberYearController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect('/contribution_overview');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes voor iedereen die is ingelogd
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Contributie overzicht routes
    Route::get('/contribution_overview', [ContributionOverviewController::class, 'index'])->name('contribution.overview');
    Route::get('/contribution_overviews', [ContributionOverviewController::class, 'index'])->name('contribution_overviews.index');

    // Familie routes
    Route::get('/families', [FamilyController::class, 'index'])->name('families.index');
    Route::get('/families/create', [FamilyController::class, 'create'])->name('families.create');
    Route::post('/families', [FamilyController::class, 'store'])->name('families.store');
    Route::get('/families/{family}/edit', [FamilyController::class, 'edit'])->name('families.edit');
    Route::put('/families/{family}', [FamilyController::class, 'update'])->name('families.update');
    Route::delete('/families/{family}', [FamilyController::class, 'destroy'])->name('families.destroy');

    // Familieleden routes
    Route::get('/families/{family}/members', [FamilyMemberController::class, 'index'])->name('family_members.index');
    Route::get('/families/{family}/members/create', [FamilyMemberController::class, 'create'])->name('family_members.create');
    Route::post('/families/{family}/members', [FamilyMemberController::class, 'store'])->name('family_members.store');
    Route::get('/families/{family}/members/{familyMember}/edit', [FamilyMemberController::class, 'edit'])->name('family_members.edit');
    Route::put('/families/{family}/members/{familyMember}', [FamilyMemberController::class, 'update'])->name('family_members.update');
    Route::delete('/families/{family}/members/{familyMember}', [FamilyMemberController::class, 'destroy'])->name('family_members.destroy');
    
    // Lidmaatschappen routes
        // Route om de lidmaatschappen van het gekozen boekjaar weer te geven
    Route::get('/membership_types', [MembershipTypeController::class, 'index'])->name('membership_types.index');
        // Stap 1: Boekjaar kiezen
    Route::get('/membership_types/create', [MembershipTypeController::class, 'createStep1'])->name('membership_types.create_step1');
        // Stap 2: Controleer of er al lidmaatschappen zijn voor het gekozen boekjaar en toon het formulier voor het aanmaken van lidmaatschappen
    Route::post('/membership_types/create/step2', [MembershipTypeController::class, 'createStep2'])->name('membership_types.create_step2');
        // Opslaan van de lidmaatschappen
    Route::post('/membership_types/store', [MembershipTypeController::class, 'store'])->name('membership_types.store');
        // Bewerken en updaten van de lidmaatschappen
    Route::get('/membership_types/{fiscal_year}/edit', [MembershipTypeController::class, 'edit'])->name('membership_types.edit');
    Route::put('/membership_types/{fiscal_year}', [MembershipTypeController::class, 'update'])->name('membership_types.update');
    
    // Member_year routes (contributies familielid bekijken)
    Route::get('/family_members/{family_member}/contributions', [MemberYearController::class, 'index'])->name('member_years.index');
    Route::get('/member_years/{family_member}/create', [MemberYearController::class, 'create'])->name('member_years.create');    Route::post('/member_years/{family_member}/store', [MemberYearController::class, 'store'])->name('member_years.store');
    Route::post('/member_years/{family_member}/store', [MemberYearController::class, 'store'])->name('member_years.store');
    Route::delete('/member_years/{memberYear}', [MemberYearController::class, 'destroy'])->name('member_years.destroy');
    
    // Boekjaren routes
    Route::get('/fiscal_years', [FiscalYearController::class, 'index'])->name('fiscal_years.index');
    Route::get('/fiscal_years/create', [FiscalYearController::class, 'create'])->name('fiscal_years.create');
    Route::post('/fiscal_years', [FiscalYearController::class, 'store'])->name('fiscal_years.store');

    // Contributie basisbedrag routes
    Route::get('/contributions', [ContributionController::class, 'index'])->name('contributions.index');
    Route::get('/contributions/create', [ContributionController::class, 'create'])->name('contributions.create');
    Route::post('/contributions', [ContributionController::class, 'store'])->name('contributions.store');
    Route::get('/contributions/{contribution}/edit', [ContributionController::class, 'edit'])->name('contributions.edit');
    Route::put('/contributions/{contribution}', [ContributionController::class, 'update'])->name('contributions.update');
    
});

require __DIR__.'/auth.php';