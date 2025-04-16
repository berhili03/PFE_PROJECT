<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <!-- Lien vers le fichier CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
@extends('layouts.commercant')

    @section('content')
    <div class="profil-container">
        <h2 class="profil-titre">👤 Mon Profil</h2>

        <div class="profil-carte">
            <p><strong>Nom complet :</strong> {{ $user->name }}</p>
            <p><strong>Email :</strong> {{ $user->email }}</p>
            <p><strong>Date de naissance :</strong> {{ $user->dateNaissance }}</p>
            <p><strong>Adresse :</strong> {{ $user->adresse }}</p>
            <p><strong>Rôle :</strong> {{ $user->role }}</p>
            <p><strong>Téléphone :</strong> {{ $user->tel }}</p>
        </div>

        <div class="profil-boutons-actions">
            <a href="{{ route('profile.commercant.edit') }}" class="profil-bouton-modifier">✏️ Modifier le profil</a>

            <form method="POST" action="{{ route('user.delete') }}" id="deleteForm">
                @csrf
                @method('DELETE')
                <button type="submit" class="profil-bouton-supprimer">🗑 Supprimer le compte</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('deleteForm').addEventListener('submit', function(event) {
            event.preventDefault();
            if (confirm('Es-tu sûr de vouloir supprimer ton compte ?')) {
                this.submit();
            }
        });
    </script>
    @endsection
</body>
</html>
