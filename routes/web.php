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
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MerchantController;
use App\Http\Controllers\CommentController;

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

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::resource('property', PropertyController::class);

    Route::resource('categories', CategoryController::class);
    Route::get('/categories/{category}/delete', [CategoryController::class, 'confirmDelete'])->name('categories.delete');
    
    // Nouvelle route pour afficher les produits d'un commerçant dans une catégorie
    Route::get('/merchants/{merchant}/categories/{category}/products', [MerchantController::class, 'showProducts'])->name('merchants.products');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/commercants', [AdminUserController::class, 'commercants'])->name('users.commercants');
    Route::get('/users/consommateurs', [AdminUserController::class, 'consommateurs'])->name('users.consommateurs');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
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
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

Route::middleware(['auth', 'role:Consommateur'])->group(function () {
    Route::get('/consommateur/dashboard', [ConsommateurController::class, 'index'])->name('consommateur.dashboard');
    Route::get('/products', [\App\Http\Controllers\Consommateur\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{id}', [\App\Http\Controllers\Consommateur\ProductController::class, 'show'])->name('products.show');
    Route::get('/commercants', [\App\Http\Controllers\Consommateur\CommercantController::class, 'index'])->name('consommateur.commercants.index');
    Route::get('/commercants/{id}', [\App\Http\Controllers\Consommateur\CommercantController::class, 'show'])->name('consommateur.commercants.show');
    Route::post('/commercants/{id}/suivre', [\App\Http\Controllers\Consommateur\CommercantController::class, 'suivre'])->name('consommateur.commercants.suivre');
    Route::delete('/commercants/{id}/neplussuivre', [\App\Http\Controllers\Consommateur\CommercantController::class, 'nePlusSuivre'])->name('consommateur.commercants.neplussuivre');
    Route::get('/commercants-suivis', [\App\Http\Controllers\Consommateur\CommercantController::class, 'suivis'])->name('consommateur.commercants.suivis');
});

Route::middleware(['auth', 'role:Consommateur'])->group(function () {
    Route::post('/produits/{id}/comment', [\App\Http\Controllers\Consommateur\ProductController::class, 'addComment'])->name('produits.comment');
    Route::post('/produits/{id}/like', [\App\Http\Controllers\Consommateur\ProductController::class, 'like'])->name('produits.like');
    Route::delete('/produits/{id}/unlike', [\App\Http\Controllers\Consommateur\ProductController::class, 'unlike'])->name('produits.unlike');
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

Route::middleware(['auth'])->group(function () {
    Route::post('/produits/{produit}/commentaires', [CommentController::class, 'store'])->name('commentaires.store');
    Route::put('/commentaires/{commentaire}', [CommentController::class, 'update'])->name('commentaires.update');
    Route::delete('/commentaires/{commentaire}', [CommentController::class, 'destroy'])->name('commentaires.destroy');
});