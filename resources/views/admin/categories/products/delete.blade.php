@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="admin-delete-container">
        <!-- En-tête avec actions -->
        <div class="admin-header">
            <div class="admin-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.property.index') }}">Produits</a></li>
                        <li class="breadcrumb-item"><a href="{{ url()->previous() }}">{{ $produit->nomProduit }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Supprimer</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Carte de confirmation -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h2>Confirmation de suppression</h2>
                <span class="product-id">ID: {{ $produit->id }}</span>
            </div>
            <div class="admin-card-body">
                <div class="delete-confirmation">
                    <div class="delete-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="delete-message">
                        <h3>Êtes-vous sûr de vouloir supprimer ce produit ?</h3>
                        <p>Cette action est irréversible et supprimera définitivement le produit <strong>{{ $produit->nomProduit }}</strong> ainsi que toutes les données associées.</p>
                        
                        <div class="product-summary">
                            <div class="product-summary-item">
                                <span class="label">Nom du produit :</span>
                                <span class="value">{{ $produit->nomProduit }}</span>
                            </div>
                            <div class="product-summary-item">
                                <span class="label">Marque :</span>
                                <span class="value">{{ $produit->marque }}</span>
                            </div>
                            <div class="product-summary-item">
                                <span class="label">Prix :</span>
                                <span class="value">{{ number_format($produit->prix, 2) }} €</span>
                            </div>
                            <div class="product-summary-item">
                                <span class="label">Catégorie :</span>
                                <span class="value">{{ $produit->category_name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="delete-actions">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Annuler</a>
                    <form action="{{ route('admin.property.destroy', $produit) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Confirmer la suppression</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
.admin-delete-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
    max-width: 800px;
    margin: 0 auto;
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
    color: var(--admin-danger);
}

.product-id {
    font-size: 0.9rem;
    color: var(--admin-text-light);
    font-weight: 500;
}

.admin-card-body {
    padding: 20px;
}

/* Contenu de confirmation */
.delete-confirmation {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 30px;
}

.delete-icon {
    font-size: 2.5rem;
    color: var(--admin-danger);
    flex-shrink: 0;
}

.delete-message h3 {
    font-size: 1.2rem;
    margin-bottom: 10px;
    color: var(--admin-danger);
}

.delete-message p {
    margin-bottom: 20px;
    color: var(--admin-text);
}

.product-summary {
    background-color: #f9f9f9;
    border-radius: var(--admin-border-radius);
    padding: 15px;
    margin-top: 15px;
}

.product-summary-item {
    display: flex;
    padding: 8px 0;
    border-bottom: 1px solid var(--admin-border);
}

.product-summary-item:last-child {
    border-bottom: none;
}

.product-summary-item .label {
    width: 150px;
    font-weight: 600;
    color: var(--admin-text);
}

.product-summary-item .value {
    flex-grow: 1;
    color: var(--admin-text);
}

/* Actions */
.delete-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
}

/* Responsive */
@media (max-width: 768px) {
    .delete-confirmation {
        flex-direction: column;
        text-align: center;
    }
    
    .delete-icon {
        margin-bottom: 10px;
    }
    
    .product-summary-item {
        flex-direction: column;
    }
    
    .product-summary-item .label {
        width: 100%;
        margin-bottom: 5px;
    }
    
    .delete-actions {
        flex-direction: column;
    }
    
    .delete-actions .btn {
        width: 100%;
        margin-bottom: 10px;
    }
}
</style>
@endsection