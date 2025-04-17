<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ConsommateurController;
use App\Http\Controllers\CommercantController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;

use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route pour afficher le profil de l'admin
Route::get('/admin/profile', [ProfileController::class, 'showAdmin'])->name('profile.admin.show');

// Route pour afficher le profil du commerçant
Route::get('/commercant/profile', [ProfileController::class, 'showCommercant'])->name('profile.commercant.show');

// Route pour afficher le profil du consommateur
Route::get('/consommateur/profile', [ProfileController::class, 'showConsommateur'])->name('profile.consommateur.show');









Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {


    // Route pour afficher l'édition du profil de l'admin
    Route::get('/admin/profile/edit', [ProfileController::class, 'editAdmin'])->name('profile.admin.edit');
    // Route pour afficher l'édition du profil du commerçant
    Route::get('/commercant/profile/edit', [ProfileController::class, 'editCommercant'])->name('profile.commercant.edit');
    // Route pour afficher l'édition du profil du consommateur
    Route::get('/consommateur/profile/edit', [ProfileController::class, 'editConsommateur'])->name('profile.consommateur.edit');



    // Route pour mettre à jour le profil de l'admin
    Route::patch('/admin/profile/edit', [ProfileController::class, 'updateAdmin'])->name('profile.admin.update');

    // Route pour mettre à jour le profil du commerçant
    Route::patch('/commercant/profile/edit', [ProfileController::class, 'updateCommercant'])->name('profile.commercant.update');

    // Route pour mettre à jour le profil du consommateur
    Route::patch('/consommateur/profile/edit', [ProfileController::class, 'updateConsommateur'])->name('profile.consommateur.update');




    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';




Route::post('/login', [AuthenticatedSessionController::class, 'store']);



// Routes admin (si nécessaire)
Route::prefix('admin')->name('admin.')->group(function(){
    Route::resource('property',App\Http\Controllers\Admin\PropertyController::class)->except(['show']);
});



Route::prefix('commercant')->name('commercant.')->group(function(){
    Route::resource('property',App\Http\Controllers\Commercant\PropertyController::class)->except(['show']);
});



// Autres routes
Route::get('/property-form', [PropertyController::class, 'showForm']);




Route::get('/', function () {
    return view('home');
});




// Sécurité par rôle
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:Consommateur'])->group(function () {
    Route::get('/consommateur/dashboard', [ConsommateurController::class, 'index'])->name('consommateur.dashboard');
});

Route::middleware(['auth', 'role:Commercant'])->group(function () {
    Route::get('/commercant/dashboard', [CommercantController::class, 'index'])->name('commercant.dashboard');
});





// Affiche le formulaire "Mot de passe oublié"
Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

// Envoie le lien de réinitialisation par mail
Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

// Affiche le formulaire de réinitialisation
Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

// Met à jour le mot de passe dans la base
Route::post('reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');



    // Route pour supprimer le compte de l'utilisateur
Route::delete('/user/delete', [UserController::class, 'destroy'])->name('user.delete')->middleware('auth');


//remember me 

