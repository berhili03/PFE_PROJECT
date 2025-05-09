<!-- views/admin/categories/show.blade.php -->
@extends('layouts.admin')

@section('title', 'Détails de la catégorie')

@section('content')
<div class="category-details-container">
    <div class="category-header">
        <div class="category-title-section">
            <a href="{{ route('admin.categories.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Retour aux catégories
            </a>
            <h1>{{ $category->name }}</h1>
        </div>
        <div class="category-actions">
            <a href="{{ route('admin.categories.edit', $category) }}" class="btn-edit">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <a href="{{ route('admin.categories.destroy', $category) }}" class="btn-delete" title="Supprimer"
                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
                <i class="fas fa-trash"></i>
            </a>
        </div>
    </div>

    <div class="category-info-card">
        <div class="category-presentation">
            <div class="category-visual">
                @if($category->image)
                    <div class="category-image" style="background-image: url({{ asset('storage/' . $category->image) }})"></div>
                @elseif($category->icon)
                    <div class="category-icon-display" style="background-color: {{ $category->color ?? '#3498db' }}">
                        <i class="fas {{ $category->icon }}"></i>
                    </div>
                @else
                    <div class="category-icon-display" style="background-color: {{ $category->color ?? '#3498db' }}">
                        <span>{{ strtoupper(substr($category->name, 0, 1)) }}</span>
                    </div>
                @endif
            </div>
            <div class="category-meta">
                <div class="meta-item">
                    <span class="meta-label">Nom:</span>
                    <span class="meta-value">{{ $category->name }}</span>
                </div>
               
                <div class="meta-item">
                    <span class="meta-label">Couleur:</span>
                    <span class="meta-value color-preview">
                        <span class="color-swatch" style="background-color: {{ $category->color ?? '#3498db' }}"></span>
                        {{ $category->color ?? '#3498db' }}
                    </span>
                </div>
                @if($category->icon)
                <div class="meta-item">
                    <span class="meta-label">Icône:</span>
                    <span class="meta-value">
                        <i class="fas {{ $category->icon }}"></i> {{ $category->icon }}
                    </span>
                </div>
                @endif
                <div class="meta-item">
                    <span class="meta-label">Nombre de produits:</span>
                    <span class="meta-value">{{ $products->total() }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="category-products-section">
        <h2>Produits dans cette catégorie par commerçant</h2>
        
        @if($groupedProducts->count() > 0)
            <div class="merchant-boxes">
                @foreach($groupedProducts as $userId => $merchantProducts)
                    @php 
                        $merchant = $merchantProducts->first()->user;
                        $merchantName = $merchant ? $merchant->name : 'Commerçant inconnu';
                        $productCount = $merchantProducts->count();
                    @endphp
                    <div class="merchant-box">
                        <div class="merchant-header" data-toggle="collapse" data-target="#merchant-{{ $userId }}">
                            <div class="merchant-info">
                                <h3>{{ $merchantName }}</h3>
                                <span class="product-count">{{ $productCount }} produit(s)</span>
                            </div>
                            <div class="merchant-actions">
                                <a href="{{ route('admin.merchants.products', ['merchant' => $userId, 'category' => $category->id]) }}" class="btn-view-all">
                                    <i class="fas fa-list"></i> Voir tous les produits
                                </a>
                                <div class="toggle-icon">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>
                        <div class="merchant-products collapse" id="merchant-{{ $userId }}">
                            <div class="products-grid">
                                @foreach($merchantProducts->take(4) as $product)
                                    <div class="product-card">
                                        <div class="product-image">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->nomProduit }}">
                                            @else
                                                <div class="no-image">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="product-info">
                                            <h4>{{ $product->nomProduit }}</h4>
                                            <div class="product-meta">
                                                <span class="product-price">{{ number_format($product->prix, 2, ',', ' ') }} €</span>
                                                <span class="product-brand">{{ $product->marque }}</span>
                                            </div>
                                        </div>
                                        <div class="product-actions">
                                            <a href="{{ route('admin.property.show', $product->id) }}" class="btn-view-product">
                                                <i class="fas fa-eye"></i> Voir
                                            </a>
                                            <a href="{{ route('admin.property.edit', $product->id) }}" class="btn-edit-product">
                                                <i class="fas fa-edit"></i> Modifier
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if($merchantProducts->count() > 4)
                                <div class="view-more-container">
                                    <a href="{{ route('admin.merchants.products', ['merchant' => $userId, 'category' => $category->id]) }}" class="btn-view-more">
                                        Voir les {{ $merchantProducts->count() - 4 }} produits supplémentaires
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="pagination-container">
                {{ $products->links() }}
            </div>
        @else
            <div class="empty-products">
                <i class="fas fa-box-open fa-3x"></i>
                <p>Aucun produit dans cette catégorie.</p>
            </div>
        @endif
    </div>
</div>
<style>
    .category-details-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.category-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.btn-back {
    text-decoration: none;
    color: #666;
    margin-right: 15px;
}

.category-actions {
    display: flex;
    gap: 10px;
}

.btn-edit, .btn-delete {
    padding: 8px 15px;
    border-radius: 4px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.btn-edit {
    background-color: #3498db;
    color: white;
}

.btn-delete {
    background-color: #e74c3c;
    color: white;
}

.category-info-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 30px;
    padding: 20px;
}

.category-presentation {
    display: flex;
    align-items: center;
}

.category-visual {
    width: 100px;
    height: 100px;
    margin-right: 20px;
    border-radius: 8px;
    overflow: hidden;
}

.category-image {
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
}

.category-icon-display {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 40px;
}

.category-meta {
    flex: 1;
}

.meta-item {
    margin-bottom: 10px;
}

.meta-label {
    font-weight: bold;
    color: #666;
    margin-right: 10px;
}

.color-swatch {
    display: inline-block;
    width: 16px;
    height: 16px;
    border-radius: 4px;
    margin-right: 5px;
    vertical-align: middle;
}

/* Styles pour les boîtes de commerçants */
.merchant-boxes {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-bottom: 30px;
}

.merchant-box {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.merchant-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    background-color: #f8f9fa;
    cursor: pointer;
    border-bottom: 1px solid #eaeaea;
}

.merchant-info {
    display: flex;
    flex-direction: column;
}

.merchant-info h3 {
    margin: 0;
    font-size: 18px;
    color: #333;
}

.product-count {
    color: #666;
    font-size: 14px;
    margin-top: 3px;
}

.merchant-actions {
    display: flex;
    align-items: center;
    gap: 15px;
}

.btn-view-all {
    text-decoration: none;
    color: #3498db;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.toggle-icon {
    transition: transform 0.3s ease;
}

.merchant-header[aria-expanded="true"] .toggle-icon {
    transform: rotate(180deg);
}

.merchant-products {
    padding: 20px;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

.product-card {
    background: #f9f9f9;
    border-radius: 6px;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.product-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.product-image {
    height: 150px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f0f0f0;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    width: 100%;
    color: #aaa;
    font-size: 40px;
}

.product-info {
    padding: 15px;
}

.product-info h4 {
    margin: 0 0 10px 0;
    font-size: 16px;
    color: #333;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.product-meta {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
}

.product-price {
    font-weight: bold;
    color: #2ecc71;
}

.product-brand {
    color: #666;
}

.product-actions {
    display: flex;
    padding: 0 15px 15px;
    gap: 10px;
}

.btn-view-product, .btn-edit-product {
    flex: 1;
    text-align: center;
    padding: 6px 0;
    border-radius: 4px;
    text-decoration: none;
    font-size: 13px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
}

.btn-view-product {
    background-color: #3498db;
    color: white;
}

.btn-edit-product {
    background-color: #f39c12;
    color: white;
}

.view-more-container {
    text-align: center;
    margin-top: 20px;
}

.btn-view-more {
    display: inline-block;
    padding: 8px 20px;
    background-color: #f5f5f5;
    color: #3498db;
    border-radius: 4px;
    text-decoration: none;
    transition: background-color 0.2s ease;
}

.btn-view-more:hover {
    background-color: #eaeaea;
}

.pagination-container {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

.empty-products {
    text-align: center;
    padding: 50px 0;
    color: #777;
}

.empty-products i {
    margin-bottom: 15px;
}

.category-products-section h2 {
    margin-bottom: 20px;
    color: #333;
    font-size: 22px;
}

.category-title-section {
    display: flex;
    align-items: center;
}

.category-title-section h1 {
    margin: 0;
    font-size: 24px;
    color: #333;
}

/* Styles pour la pagination */
.pagination {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 5px;
}

.pagination li {
    display: inline-block;
}

.pagination li a, .pagination li span {
    display: block;
    padding: 8px 12px;
    background: #f5f5f5;
    color: #333;
    text-decoration: none;
    border-radius: 4px;
}

.pagination li.active span {
    background: #3498db;
    color: white;
}

.pagination li a:hover {
    background: #eaeaea;
}

/* Responsive styles */
@media (max-width: 768px) {
    .category-presentation {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .category-visual {
        margin-bottom: 15px;
        margin-right: 0;
    }
    
    .category-header, .merchant-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .category-actions, .merchant-actions {
        width: 100%;
        justify-content: space-between;
    }
    
    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    }
}
</style>
@endsection