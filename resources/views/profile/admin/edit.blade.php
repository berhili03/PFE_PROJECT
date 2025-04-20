@extends('layouts.admin')

@section('content')
    <div class="profil-page-container">
        <h2 class="profil-page-title">{{ __('Modifier mon profil') }}</h2>
        
        <div class="profil-sections">
            <!-- Mise à jour des informations du profil -->
            <div class="profil-form-section">
                <h3>{{ __('Mettre à jour les informations du profil') }}</h3>
                @include('profile.consommateur.update')
            </div>

            <!-- Mise à jour du mot de passe -->
            <div class="profil-form-section">
                <h3>{{ __('Mettre à jour le mot de passe') }}</h3>
                @include('profile.partials.update-password-form')
            </div>

            <!-- Suppression du compte -->
            <div class="profil-form-section-delete">
                <h3>{{ __('Supprimer le compte') }}</h3>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
/* Style général de la page profil */
.profil-page-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1.5rem;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.profil-page-title {
    color: #2c3e50;
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 2rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #3498db;
}

/* Layout des sections */
.profil-sections {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
}

@media (min-width: 768px) {
    .profil-sections {
        grid-template-columns: repeat(2, 1fr);
    }
    
    /* Pour que la section suppression soit sur toute la largeur */
    .profil-form-section-delete {
        grid-column: 1 / -1;
    }
}

/* Style des sections de formulaire */
.profil-form-section, .profil-form-section-delete {
    background-color: #ffffff;
    border-radius: 8px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.profil-form-section:hover, .profil-form-section-delete:hover {
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
}

.profil-form-section h3, .profil-form-section-delete h3 {
    font-size: 1.25rem;
    color: #2c3e50;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #e9ecef;
}

/* Style spécifique pour la section suppression */
.profil-form-section-delete {
    background-color: #fff8f8;
    border: 1px solid #f8d7da;
}

.profil-form-section-delete h3 {
    color: #721c24;
    border-bottom-color: #f5c6cb;
}

/* Style des formulaires */
form {
    margin-top: 1rem;
}

/* Style des champs de formulaire */
input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 0.75rem;
    margin-bottom: 1rem;
    border: 1px solid #ced4da;
    border-radius: 4px;
    font-size: 1rem;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
    border-color: #3498db;
    outline: none;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.25);
}

/* Style des boutons */
button, 
.button {
    display: inline-block;
    font-weight: 500;
    text-align: center;
    vertical-align: middle;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    transition: all 0.15s ease-in-out;
    cursor: pointer;
}

.primary-button {
    color: #fff;
    background-color: #3498db;
    border: 1px solid #3498db;
}

.primary-button:hover {
    background-color: #2980b9;
    border-color: #2980b9;
}

.danger-button {
    color: #fff;
    background-color: #e74c3c;
    border: 1px solid #e74c3c;
}

.danger-button:hover {
    background-color: #c0392b;
    border-color: #c0392b;
}

.secondary-button {
    color: #6c757d;
    background-color: transparent;
    border: 1px solid #6c757d;
}

.secondary-button:hover {
    color: #fff;
    background-color: #6c757d;
}

/* Messages de confirmation et d'erreur */
.success-message {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
    padding: 0.75rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: 0.25rem;
}

.error-message {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
    padding: 0.75rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: 0.25rem;
}

/* Animation pour les messages de confirmation */
@keyframes fadeOut {
    from {opacity: 1;}
    to {opacity: 0;}
}

.fade-out {
    animation: fadeOut 2s forwards;
}</style>
@endsection