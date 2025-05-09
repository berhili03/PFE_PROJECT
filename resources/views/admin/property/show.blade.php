<!-- views/admin/property/show.blade.php -->
@extends('layouts.admin')

@section('title', 'Détails du produit')

@section('content')
<div class="product-details-container">
    <div class="product-header">
        <div class="product-title-section">
            <a href="{{ url()->previous() }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <h1>{{ $property->nomProduit }}</h1>
        </div>
        <div class="product-actions">
            <a href="{{ route('admin.property.edit', $property) }}" class="btn-edit">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <form action="{{ route('admin.property.destroy', $property) }}" method="POST" style="display: inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </form>
        </div>
    </div>

    <div class="product-info-card">
        <div class="product-presentation">
            <div class="product-image-large">
                @if($property->image)
                    <img src="{{ asset('storage/' . $property->image) }}" alt="{{ $property->nomProduit }}">
                @else
                    <div class="no-image-large">
                        <i class="fas fa-image fa-3x"></i>
                        <p>Aucune image disponible</p>
                    </div>
                @endif
            </div>
            <div class="product-details">
                <div class="detail-row">
                    <span class="detail-label">Nom du produit:</span>
                    <span class="detail-value">{{ $property->nomProduit }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Marque:</span>
                    <span class="detail-value">{{ $property->marque }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Prix:</span>
                    <span class="detail-value">{{ number_format($property->prix, 2, ',', ' ') }} €</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Catégorie:</span>
                    <span class="detail-value">{{ $property->category_name ?? 'Non catégorisé' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Commerçant:</span>
                    <span class="detail-value">{{ $property->user->name ?? 'Inconnu' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Ajouté le:</span>
                    <span class="detail-value">{{ $property->created_at->format('d/m/Y à H:i') }}</span>
                </div>
                @if($property->created_at != $property->updated_at)
                <div class="detail-row">
                    <span class="detail-label">Dernière modification:</span>
                    <span class="detail-value">{{ $property->updated_at->format('d/m/Y à H:i') }}</span>
                </div>
                @endif
            </div>
        </div>
        
        <div class="product-description">
            <h3>Description</h3>
            <div class="description-content">
                {{ $property->description ?? 'Aucune description disponible.' }}
            </div>
        </div>
    </div>

    <div class="product-comments-section">
        <h3>Commentaires ({{ $comments->count() }})</h3>
        
        @if($comments->count() > 0)
            <div class="comments-list">
                @foreach($comments as $commentaire)
                    <div class="comment-card">
                        <div class="comment-header">
                            <div class="comment-user">
                                <strong>{{ $commentaire->user->name ?? 'Utilisateur inconnu' }}</strong>
                            </div>
                            <div class="comment-date">
                                {{ $commentaire->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                        <div class="comment-content">
                            {{ $commentaire->content }}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-comments">
                <i class="fas fa-comments fa-2x"></i>
                <p>Aucun commentaire pour ce produit.</p>
            </div>
        @endif
    </div>
</div>

<style>
.product-details-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.product-header {
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

.product-actions {
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
    cursor: pointer;
    border: none;
    font-size: 14px;
}

.btn-edit {
    background-color: #3498db;
    color: white;
}

.btn-delete {
    background-color: #e74c3c;
    color: white;
}

.product-info-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 30px;
}

.product-presentation {
    display: flex;
    flex-wrap: wrap;
    padding: 20px;
}

.product-image-large {
    flex: 0 0 300px;
    height: 300px;
    margin-right: 30px;
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
}

.product-image-large img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.no-image-large {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    color: #aaa;
    text-align: center;
}

.product-details {
    flex: 1;
    min-width: 300px;
}

.detail-row {
    margin-bottom: 15px;
    display: flex;
    flex-wrap: wrap;
}

.detail-label {
    font-weight: bold;
    flex: 0 0 150px;
    color: #666;
}

.detail-value {
    flex: 1;
}

.product-description {
    padding: 20px;
    border-top: 1px solid #eee;
}

.description-content {
    line-height: 1.6;
    color: #333;
    white-space: pre-line;
}

.product-comments-section {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

.comments-list {
    margin-top: 20px;
}

.comment-card {
    padding: 15px;
    border: 1px solid #eee;
    border-radius: 8px;
    margin-bottom: 15px;
}

.comment-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 14px;
}

.comment-date {
    color: #777;
}

.comment-content {
    line-height: 1.5;
}

.no-comments {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 30px;
    color: #aaa;
    text-align: center;
}

@media (max-width: 768px) {
    .product-presentation {
        flex-direction: column;
    }
    
    .product-image-large {
        margin-right: 0;
        margin-bottom: 20px;
        max-width: 100%;
    }
}
</style>
@endsection