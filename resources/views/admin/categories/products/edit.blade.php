<!-- views/admin/categories/products/edit.blade-->
@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="admin-product-container">
        <!-- En-tête avec actions -->
        <div class="admin-header">
            <div class="admin-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.property.index') }}">Produits</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $property->exists ? 'Modifier: ' . $property->nomProduit : 'Nouveau produit' }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Carte principale du formulaire -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h2>{{ $property->exists ? 'Modifier le produit' : 'Ajouter un produit' }}</h2>
                @if($property->exists)
                    <span class="product-id">ID: {{ $property->id }}</span>
                @endif
            </div>
            <div class="admin-card-body">
                <form method="POST" action="{{ $property->exists ? route('admin.property.update', $property) : route('admin.property.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if($property->exists)
                        @method('PUT')
                    @endif

                    <div class="row">
                        <!-- Colonne image -->
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label for="image" class="form-label">Image du produit</label>
                                <div class="admin-image-upload">
                                    <div class="admin-image-preview mb-3">
                                        @if($property->image)
                                            <img src="{{ asset('storage/' . $property->image) }}" alt="Prévisualisation" id="image-preview" class="img-fluid">
                                        @else
                                            <div class="admin-image-placeholder" id="image-placeholder">
                                                <i class="fas fa-image"></i>
                                                <p>Aucune image sélectionnée</p>
                                            </div>
                                            <img src="" alt="Prévisualisation" id="image-preview" class="img-fluid d-none">
                                        @endif
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Format recommandé: JPG, PNG. Taille max: 2 MB</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Colonne informations -->
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="nomProduit" class="form-label">Nom du produit *</label>
                                        <input type="text" class="form-control @error('nomProduit') is-invalid @enderror" id="nomProduit" name="nomProduit" value="{{ old('nomProduit', $property->nomProduit) }}" required>
                                        @error('nomProduit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="marque" class="form-label">Marque *</label>
                                        <input type="text" class="form-control @error('marque') is-invalid @enderror" id="marque" name="marque" value="{{ old('marque', $property->marque) }}" required>
                                        @error('marque')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="prix" class="form-label">Prix (€) *</label>
                                        <input type="number" step="0.01" class="form-control @error('prix') is-invalid @enderror" id="prix" name="prix" value="{{ old('prix', $property->prix) }}" required>
                                        @error('prix')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="ancien_prix" class="form-label">Ancien prix (€)</label>
                                        <input type="number" step="0.01" class="form-control @error('ancien_prix') is-invalid @enderror" id="ancien_prix" name="ancien_prix" value="{{ old('ancien_prix', $property->ancien_prix) }}">
                                        @error('ancien_prix')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="categorie" class="form-label">Catégorie *</label>
                                        <select class="form-control @error('categorie') is-invalid @enderror" id="categorie" name="categorie" required>
                                            <option value="">Sélectionner une catégorie</option>
                                            @foreach($categories as $key => $value)
                                                <option value="{{ $key }}" {{ old('categorie', $property->category_name) == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('categorie')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group" id="new-category-group" style="{{ old('categorie') === 'Autre' || $property->category_name === 'Autre' ? '' : 'display: none;' }}">
                                        <label for="new_categorie" class="form-label">Nouvelle catégorie *</label>
                                        <input type="text" class="form-control @error('new_categorie') is-invalid @enderror" id="new_categorie" name="new_categorie" value="{{ old('new_categorie') }}">
                                        @error('new_categorie')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description', $property->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group text-end">
                                <a href="{{ route('admin.property.index') }}" class="btn btn-secondary me-2">Annuler</a>
                                <button type="submit" class="btn btn-primary">
                                    {{ $property->exists ? 'Mettre à jour' : 'Ajouter' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Prévisualisation de l'image
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');
    const imagePlaceholder = document.getElementById('image-placeholder');
    
    if (imageInput) {
        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('d-none');
                    if (imagePlaceholder) {
                        imagePlaceholder.classList.add('d-none');
                    }
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
    
    // Gestion de la catégorie "Autre"
    const categorieSelect = document.getElementById('categorie');
    const newCategorieGroup = document.getElementById('new-category-group');
    
    if (categorieSelect) {
        categorieSelect.addEventListener('change', function() {
            if (this.value === 'Autre') {
                newCategorieGroup.style.display = 'block';
                document.getElementById('new_categorie').setAttribute('required', 'required');
            } else {
                newCategorieGroup.style.display = 'none';
                document.getElementById('new_categorie').removeAttribute('required');
            }
        });
    }
});
</script>

<style>
/* Variables */
:root {
    --admin-primary: #3498db;
    --admin-primary-dark: #2980b9;
    --admin-secondary: #f8f9fa;
    --admin-danger: #e74c3c;
    --admin-success: #2ecc71;
    --admin-text: #333;
    --admin-text-light: #6c757d;
    --admin-border: #dee2e6;
    --admin-card-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    --admin-border-radius: 8px;
}

/* Structure générale */
.admin-product-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* En-tête avec actions */
.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

/* Carte principale */
.admin-card {
    background-color: #fff;
    border-radius: var(--admin-border-radius);
    box-shadow: var(--admin-card-shadow);
    overflow: hidden;
}

.admin-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    background-color: #f8f9fa;
    border-bottom: 1px solid var(--admin-border);
}

.admin-card-header h2 {
    font-size: 1.25rem;
    margin: 0;
    font-weight: 600;
}

.product-id {
    font-size: 0.9rem;
    color: var(--admin-text-light);
    font-weight: 500;
}

.admin-card-body {
    padding: 20px;
}

/* Section upload image */
.admin-image-upload {
    margin-bottom: 20px;
}

.admin-image-preview {
    height: 200px;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f9f9f9;
    border-radius: var(--admin-border-radius);
    overflow: hidden;
}

.admin-image-preview img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.admin-image-placeholder {
    height: 100%;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: var(--admin-text-light);
}

.admin-image-placeholder i {
    font-size: 3rem;
    margin-bottom: 10px;
}

/* Responsive */
@media (max-width: 768px) {
    .admin-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
}
</style>
@endsection