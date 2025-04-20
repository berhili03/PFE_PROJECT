@extends('layouts.consommateur')

@section('content')
<div class="container py-5">
    <div class="product-detail-container">
        <!-- Bouton retour amélioré -->
        <div class="back-button-container">
            <a href="{{ url()->previous() }}" class="btn-back" title="Retour aux produits">
                <span class="back-arrow">&laquo;</span>
                <span class="back-text">Retour aux produits</span>
            </a>
        </div>
        
        <div class="row product-content-row">
            <!-- Colonne image -->
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="product-gallery">
                    <div class="main-image-wrapper">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="main-product-image" alt="{{ $product->nomProduit }}">
                        @else
                            <div class="no-image">
                                <i class="fas fa-camera"></i>
                                <p>Image non disponible</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Colonne information produit -->
            <div class="col-lg-6">
                <div class="product-info">
                    <div class="info-label">Marque</div>
                    <div class="product-brand">{{ $product->marque }}</div>
                    
                    <h1 class="product-name">{{ $product->nomProduit }}</h1>
                    
                    <div class="info-label">Catégorie</div>
                    <div class="product-category">
                        <span class="category-tag">{{ $product->category_name }}</span>
                    </div>
                    
                    <div class="info-label">Prix</div>
                    <div class="product-price">
                        <span class="current-price">{{ number_format($product->prix, 2) }} mad</span>
                        @if(isset($product->old_price) && $product->old_price > $product->prix)
                            <span class="discount-badge">-{{ round((1 - $product->prix / $product->old_price) * 100) }}%</span>
                        @endif
                    </div>
                    
                   
                    
                    <div class="product-description-container mt-5">
                        <h3 class="section-title">Description</h3>
                        <div class="product-description">
                            {{ $product->description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Réinitialisation et base */
    .product-detail-container {
        font-family: 'Roboto', 'Open Sans', sans-serif;
        color: #333;
        position: relative;
        background: linear-gradient(135deg, #ffffff 0%, #f7f9fc 100%);
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    
    /* Bouton retour amélioré */
    .back-button-container {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 100;
    }
    
    .btn-back {
        display: flex;
        align-items: center;
        background-color: #f0f4f8;
        border-radius: 30px;
        padding: 8px 15px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.08);
        color: #2d3748;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
    }
    
    .btn-back:hover {
        background-color: #e2e8f0;
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(0,0,0,0.12);
    }
    
    .back-arrow {
        font-size: 1.4rem;
        line-height: 1;
        margin-right: 8px;
        font-weight: bold;
    }
    
    .back-text {
        display: none;
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    .btn-back:hover .back-text {
        display: inline;
    }
    
    /* Contenu principal */
    .product-content-row {
        margin-top: 20px;
    }
    
    /* Galerie d'images */
    .product-gallery {
        background-color: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid #f0f0f0;
    }
    
    .main-image-wrapper {
        height: 450px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        position: relative;
    }
    
    .main-product-image {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
        transition: transform 0.3s ease;
    }
    
    .main-product-image:hover {
        transform: scale(1.03);
    }
    
    .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: #f7f9fc;
        color: #a0aec0;
        border-radius: 8px;
    }
    
    .no-image i {
        font-size: 3rem;
        margin-bottom: 15px;
    }
    
    /* Informations produit */
    .product-info {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid #f0f0f0;
        height: 100%;
    }
    
    .info-label {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #718096;
        margin-bottom: 5px;
        font-weight: 500;
    }
    
    .product-brand {
        display: inline-block;
        background-color: #4a5568;
        color: white;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 6px 12px;
        border-radius: 6px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        font-weight: 500;
    }
    
    .product-name {
        font-size: 2.2rem;
        font-weight: 700;
        margin: 15px 0 25px;
        color: #1a202c;
        line-height: 1.2;
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 15px;
    }
    
    .product-category {
        margin-bottom: 25px;
    }
    
    .category-tag {
        background-color: #ebf4ff;
        color: #4299e1;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        display: inline-block;
        border: 1px solid #bee3f8;
        font-weight: 500;
    }
    
    /* Prix */
    .product-price {
        margin: 20px 0 30px;
        display: flex;
        align-items: center;
    }
    
    .current-price {
        font-size: 2.2rem;
        font-weight: 700;
        color: #2d3748;
        background: linear-gradient(135deg, #3182ce 0%, #63b3ed 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .old-price {
        font-size: 1.2rem;
        text-decoration: line-through;
        color: #a0aec0;
        margin-left: 15px;
    }
    
    .discount-badge {
        background: linear-gradient(135deg, #e53e3e 0%, #fc8181 100%);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        margin-left: 15px;
        font-size: 0.9rem;
        font-weight: 600;
        box-shadow: 0 2px 5px rgba(229, 62, 62, 0.3);
    }
    
    /* Actions produit */
    .product-actions {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }
    
    .wishlist-button {
        background: linear-gradient(135deg, #f6f8fa 0%, #e2e8f0 100%);
        border: 1px solid #e2e8f0;
        border-radius: 50%;
        height: 50px;
        width: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 3px 6px rgba(0,0,0,0.05);
    }
    
    .wishlist-button:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 5px 12px rgba(0,0,0,0.12);
    }
    
    .wishlist-button i {
        font-size: 1.3rem;
        color: #4a5568;
        transition: all 0.3s ease;
    }
    
    .wishlist-button:hover i {
        color: #e53e3e;
    }
    
    /* Description */
    .section-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: #2d3748;
        position: relative;
        padding-bottom: 10px;
    }
    
    .section-title:after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 3px;
        background: linear-gradient(135deg, #3182ce 0%, #63b3ed 100%);
        border-radius: 3px;
    }
    
    .product-description {
        line-height: 1.8;
        color: #4a5568;
        font-size: 1rem;
        padding: 15px;
        background-color: #f8fafc;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }
    
    /* Responsive */
    @media (max-width: 991px) {
        .main-image-wrapper {
            height: 350px;
        }
        
        .product-name {
            font-size: 1.8rem;
        }
        
        .current-price {
            font-size: 1.7rem;
        }
        
        .product-detail-container {
            padding: 20px;
        }
    }
    
    @media (max-width: 767px) {
        .product-actions {
            flex-wrap: wrap;
        }
        
        .wishlist-button {
            margin-top: 15px;
        }
        
        .back-button-container {
            top: 10px;
            right: 10px;
        }
        
        .product-info {
            padding: 15px;
        }
    }
</style>
@endsection