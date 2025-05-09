<!-- views/admin/merchants/show_products.blade.php -->
@extends('layouts.admin')

@section('title', 'Produits de ' . $merchant->name . ' dans ' . $category->name)

@section('content')
<div class="merchant-products-container">
    <div class="merchant-header">
        <div class="title-section">
            <a href="{{ route('admin.categories.show', $category) }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Retour à la catégorie
            </a>
            <h1>{{ $merchant->name }} - {{ $category->name }}</h1>
        </div>
    </div>

    <div class="products-section">
        <h2>Liste des produits ({{ $products->total() }})</h2>
        
        @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
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
                            <a href="{{ route('admin.property.show', $product->id) }}" class="btn-view">
                                <i class="fas fa-eye"></i> Voir
                            </a>
                            <a href="{{ route('admin.property.edit', $product->id) }}" class="btn-edit">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <form action="{{ route('admin.property.destroy', $product->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
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
                <p>Aucun produit pour ce commerçant dans cette catégorie.</p>
            </div>
        @endif
    </div>
</div>

<style>
.merchant-products-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.merchant-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.title-section {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.btn-back {
    text-decoration: none;
    color: #666;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 14px;
    margin-bottom: 5px;
}

.btn-back:hover {
    color: #333;
}

.products-section {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-bottom: 30px;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.product-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.product-image {
    height: 180px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
}

.product-image img {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
}

.no-image {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    color: #ccc;
    font-size: 24px;
}

.product-info {
    padding: 15px;
}

.product-info h4 {
    margin: 0 0 10px 0;
    font-size: 16px;
    color: #333;
}

.product-meta {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 14px;
}

.product-price {
    font-weight: bold;
    color: #e74c3c;
}

.product-brand {
    color: #777;
}

.product-actions {
    padding: 15px;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 5px;
    border-top: 1px solid #eee;
}

.btn-view, .btn-edit, .btn-delete {
    padding: 5px 10px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 12px;
    display: inline-flex;
    align-items: center;
    gap: 3px;
    cursor: pointer;
}

.btn-view {
    background-color: #3498db;
    color: white;
}

.btn-edit {
    background-color: #f39c12;
    color: white;
}

.btn-delete {
    background-color: #e74c3c;
    color: white;
    border: none;
}

.delete-form {
    display: inline;
}

.empty-products {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 50px 0;
    color: #aaa;
    text-align: center;
}

.pagination-container {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

@media (max-width: 768px) {
    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    }
    
    .product-actions {
        flex-direction: column;
    }
}
</style>
@endsection