@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <!-- En-tête du profil commerçant -->
    <div class="profile-header mb-5 d-flex justify-content-between align-items-center">
        <h1 class="merchant-name">{{ $commercant->name }}</h1>
        
        @if($estSuivi)
        <form action="{{ route('admin.commercants.neplussuivre', $commercant->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-unfollow">Ne plus suivre</button>
        </form>
        @else
        <form action="{{ route('admin.commercants.suivre', $commercant->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn-follow">Suivre ce commerçant</button>
        </form>
        @endif
    </div>
    
    <!-- Carte d'information -->
    <div class="info-card mb-5">
        <div class="info-card-body">
            <h5 class="info-card-title">Informations</h5>
            <div class="info-item">
                <i class="fas fa-map-marker-alt info-icon"></i>
                <p><strong>Adresse:</strong> {{ $commercant->adresse }}</p>
            </div>
            <div class="info-item">
                <i class="fas fa-phone info-icon"></i>
                <p><strong>Téléphone:</strong> {{ $commercant->tel }}</p>
            </div>
        </div>
    </div>
    
    <!-- En-tête des produits -->
    <div class="products-header mb-4">
        <h2 class="products-title">Produits <span class="products-count">{{ $produits->total() }}</span></h2>
    </div>
    
    <!-- Grille de produits -->
    <div class="product-grid">
        @foreach($produits as $produit)
        <div class="product-item">
            <div class="product-card">
                @if($produit->image)
                <div class="product-image-container">
                    <img src="{{ asset('storage/' . $produit->image) }}" class="product-image" alt="{{ $produit->nomProduit }}">
                </div>
                @endif
                <div class="product-details">
                    <h5 class="product-title">{{ $produit->nomProduit }}</h5>
                    <p class="product-brand">{{ $produit->marque }}</p>
                    <div class="product-footer">
                        <p class="product-price">{{ number_format($produit->prix, 2) }} €</p>
                        <a href="{{ route('products.show', $produit->id) }}" class="btn-details">Détails</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    <div class="pagination-container mt-5">
        {{ $produits->links() }}
    </div>
</div>

<style>
/* Variables de couleurs */
:root {
    --primary-color: #3498db;
    --primary-hover: #2980b9;
    --danger-color: #e74c3c;
    --danger-hover: #c0392b;
    --text-color: #333;
    --text-muted: #777;
    --card-bg: #fff;
    --border-color: #eaeaea;
    --bg-light: #f8f9fa;
    --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    --border-radius: 8px;
}

/* Styles globaux */
body {
    color: var(--text-color);
    font-family: 'Poppins', sans-serif;
    background-color: var(--bg-light);
}

.container {
    max-width: 1200px;
}

/* En-tête du profil */
.profile-header {
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border-color);
}

.merchant-name {
    font-size: 2.5rem;
    font-weight: 600;
    color: var(--text-color);
    margin: 0;
}

.btn-follow, .btn-unfollow {
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-follow {
    background-color: var(--primary-color);
    color: white;
}

.btn-follow:hover {
    background-color: var(--primary-hover);
    transform: translateY(-2px);
}

.btn-unfollow {
    background-color: white;
    color: var(--danger-color);
    border: 1px solid var(--danger-color);
}

.btn-unfollow:hover {
    background-color: var(--danger-color);
    color: white;
    transform: translateY(-2px);
}

/* Carte d'information */
.info-card {
    background-color: var(--card-bg);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    border: none;
}

.info-card-body {
    padding: 25px;
}

.info-card-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 20px;
    color: var(--primary-color);
}

.info-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.info-icon {
    color: var(--primary-color);
    margin-right: 15px;
    font-size: 1.2rem;
}

/* En-tête des produits */
.products-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.products-title {
    font-size: 1.8rem;
    font-weight: 600;
}

.products-count {
    background-color: var(--primary-color);
    color: white;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 1rem;
    margin-left: 10px;
}

/* Grille de produits - MODIFIÉ */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.product-item {
    width: 100%;
}

.product-card {
    background-color: var(--card-bg);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    border: none;
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.product-image-container {
    height: 160px;
    overflow: hidden;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: contain; /* Changé de 'cover' à 'contain' pour afficher l'image complète */
    transition: transform 0.3s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.product-details {
    padding: 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.product-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 8px;
    color: var(--text-color);
}

.product-brand {
    color: var(--text-muted);
    font-size: 0.9rem;
    margin-bottom: 15px;
}

.product-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
}

.product-price {
    font-weight: 700;
    font-size: 1.2rem;
    color: var(--primary-color);
    margin: 0;
}

.btn-details {
    background-color: var(--primary-color);
    color: white;
    padding: 8px 15px;
    border-radius: 4px;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-details:hover {
    background-color: var(--primary-hover);
    transform: translateY(-2px);
}

/* Pagination */
.pagination-container {
    display: flex;
    justify-content: center;
}

.pagination {
    display: flex;
    padding-left: 0;
    list-style: none;
    border-radius: 0.25rem;
}

.page-link {
    color: var(--primary-color);
    padding: 12px 18px;
    margin: 0 5px;
    border-radius: var(--border-radius);
    border: none;
    background-color: white;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
}

.page-link:hover {
    background-color: var(--primary-color);
    color: white;
}

.page-item.active .page-link {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

/* Responsive */
@media (max-width: 768px) {
    .product-grid {
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    }
}

@media (max-width: 576px) {
    .profile-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .product-grid {
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    }
}
</style>
@endsection