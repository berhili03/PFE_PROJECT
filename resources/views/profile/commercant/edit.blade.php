@extends('layouts.commercant')

@section('content')
    <div class="profil-page-container">
        <h2 class="profil-page-title">{{ __('Modifier mon profil') }}</h2>
        
        <div class="profil-sections">
            <!-- Mise à jour des informations du profil -->
            <div class="profil-form-section">
                <h3>{{ __('Mettre à jour les informations du profil') }}</h3>
                @include('profile.commercant.update')
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