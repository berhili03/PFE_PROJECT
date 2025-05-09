<!-- resources/views/admin/users/create.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">Gestion des comptes</h1>
            <p class="text-muted">Ajouter un nouveau compte utilisateur</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour à la liste
            </a>
        </div>
    </div>
    <!-- Onglets de navigation -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.users.index') }}">Tous les utilisateurs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.users.commercants') }}">Commerçants</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ route('admin.users.consommateurs') }}">Consommateurs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active " href="{{ route('admin.users.create') }}">Ajouter un compte</a>
        </li>
    </ul>


    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">Nom complet</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Nouveaux champs ajoutés: sexe, téléphone -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sexe" class="form-label">Genre</label>
                            <select class="form-select @error('sexe') is-invalid @enderror" id="sexe" name="sexe" required>
                                <option value="">Sélectionner un genre</option>
                                <option value="Homme" {{ old('sexe') == 'Homme' ? 'selected' : '' }}>Homme</option>
                                <option value="Femme" {{ old('sexe') == 'Femme' ? 'selected' : '' }}>Femme</option>
                            </select>
                            @error('sexe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tel" class="form-label">Téléphone</label>
                            <input type="tel" class="form-control @error('tel') is-invalid @enderror" id="tel" name="tel" value="{{ old('tel') }}" required>
                            @error('tel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Nouveau champ ajouté: adresse -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="adresse" class="form-label">Adresse</label>
                            <textarea class="form-control @error('adresse') is-invalid @enderror" id="adresse" name="adresse" rows="3" required>{{ old('adresse') }}</textarea>
                            @error('adresse')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role" class="form-label">Rôle utilisateur</label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                <option value="">Sélectionner un rôle</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="Commercant" {{ old('role') == 'Commercant' ? 'selected' : '' }}>Commerçant</option>
                                <option value="Consommateur" {{ old('role') == 'Consommateur' ? 'selected' : '' }}>Consommateur</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6 merchant-fields" style="display: none;">
                        <div class="form-group">
                            <label for="store_name" class="form-label">Nom de la boutique</label>
                            <input type="text" class="form-control @error('store_name') is-invalid @enderror" id="store_name" name="store_name" value="{{ old('store_name') }}">
                            @error('store_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
               
                
                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Créer le compte
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Afficher/masquer les champs spécifiques aux commerçants
    document.getElementById('role').addEventListener('change', function() {
        const merchantFields = document.querySelectorAll('.merchant-fields');
        const isCommerçant = this.value === 'Commercant';
        
        merchantFields.forEach(field => {
            field.style.display = isCommerçant ? 'block' : 'none';
        });
        
        // Rendre les champs requis ou non selon le rôle
        const storeNameInput = document.getElementById('store_name');
        if (storeNameInput) {
            storeNameInput.required = isCommerçant;
        }
    });
    
    // Initialiser l'affichage au chargement de la page
    window.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        if (roleSelect.value === 'Commercant') {
            const merchantFields = document.querySelectorAll('.merchant-fields');
            merchantFields.forEach(field => {
                field.style.display = 'block';
            });
            
            const storeNameInput = document.getElementById('store_name');
            if (storeNameInput) {
                storeNameInput.required = true;
            }
        }
    });
</script>
@endsection