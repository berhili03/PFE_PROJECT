<!-- resources/views/admin/users/edit.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">Gestion des comptes</h1>
            <p class="text-muted">Modifier les informations du compte</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour à la liste
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-4">
                <div class="avatar rounded-circle me-3" style="background: linear-gradient(45deg, {{ $colorPalettes[crc32($user->name) % count($colorPalettes)]['from'] }}, {{ $colorPalettes[crc32($user->name) % count($colorPalettes)]['to'] }});">
                    <span class="text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                </div>
                <div>
                    <h5 class="mb-0">{{ $user->name }}</h5>
                    <small class="text-muted">{{ $user->email }}</small>
                </div>
            </div>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">Nom complet</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
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
                                <option value="Homme" {{ old('sexe', $user->sexe) == 'Homme' ? 'selected' : '' }}>Homme</option>
                                <option value="Femme" {{ old('sexe', $user->sexe) == 'Femme' ? 'selected' : '' }}>Femme</option>
                            </select>
                            @error('sexe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tel" class="form-label">Téléphone</label>
                            <input type="tel" class="form-control @error('tel') is-invalid @enderror" id="tel" name="tel" value="{{ old('tel', $user->tel) }}" required>
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
                            <textarea class="form-control @error('adresse') is-invalid @enderror" id="adresse" name="adresse" rows="3" required>{{ old('adresse', $user->adresse) }}</textarea>
                            @error('adresse')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="form-label">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role" class="form-label">Rôle utilisateur</label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                <option value="">Sélectionner un rôle</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="Commercant" {{ old('role', $user->role) == 'Commercant' ? 'selected' : '' }}>Commerçant</option>
                                <option value="Consommateur" {{ old('role', $user->role) == 'Consommateur' ? 'selected' : '' }}>Consommateur</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6 merchant-fields" style="display: {{ $user->role == 'Commercant' ? 'block' : 'none' }};">
                        <div class="form-group">
                            <label for="store_name" class="form-label">Nom de la boutique</label>
                            <input type="text" class="form-control @error('store_name') is-invalid @enderror" id="store_name" name="store_name" value="{{ old('store_name', $user->store_name) }}">
                            @error('store_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
               
                
                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Enregistrer les modifications
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
</script>
@endsection