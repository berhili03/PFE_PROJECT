@extends('layouts.admin')

@section('title', 'Supprimer la catégorie')

@section('content')
<div class="delete-category-container">
    <div class="page-header">
        <div class="header-content">
            <a href="{{ route('admin.categories.index') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                <span>Retour aux catégories</span>
            </a>
            <h1 class="page-title">Supprimer la catégorie</h1>
        </div>
    </div>

    <div class="delete-card">
        <div class="delete-card-header">
            <div class="category-name-display">
                <span class="category-label">Catégorie :</span>
                <span class="category-name">{{ $category->name }}</span>
            </div>
        </div>
        
        <div class="card-content">
            <div class="card-section preview-section">
                <div class="category-preview">
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
                    <div class="category-details">
                        <div class="detail-item">
                            <span class="detail-label">Nom:</span>
                            <span class="detail-value">{{ $category->name }}</span>
                        </div>
                        @if($category->description)
                        <div class="detail-item">
                            <span class="detail-label">Description:</span>
                            <span class="detail-value">{{ $category->description }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card-section warning-section">
                <div class="warning-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="warning-message">
                    <h2>Attention - Action irréversible</h2>
                    <p>Vous êtes sur le point de supprimer définitivement cette catégorie. Cette action est <strong>irréversible</strong> et tous les produits associés n'auront plus de catégorie.</p>
                    
                    @if($productsCount > 0)
                    <div class="products-warning">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><strong>{{ $productsCount }} produits</strong> sont actuellement associés à cette catégorie.</span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card-section action-section">
                <div class="action-buttons">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-cancel">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete">
                            <i class="fas fa-trash"></i> Confirmer la suppression
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .delete-category-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 25px 15px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Header Styles */
    .page-header {
        margin-bottom: 30px;
    }

    .header-content {
        display: flex;
        flex-direction: column;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        color: #566573;
        font-size: 14px;
        text-decoration: none;
        transition: color 0.2s;
        margin-bottom: 12px;
    }

    .back-button:hover {
        color: #2c3e50;
    }

    .back-button i {
        margin-right: 8px;
        font-size: 12px;
    }

    .page-title {
        color: #2c3e50;
        font-size: 28px;
        font-weight: 600;
        margin: 0;
        padding-bottom: 15px;
        border-bottom: 2px solid #f1f1f1;
    }

    /* Card Styles */
    .delete-card {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .delete-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .delete-card-header {
        background-color: #f8f9fa;
        padding: 20px 25px;
        border-bottom: 1px solid #eaeaea;
    }

    .category-name-display {
        display: flex;
        align-items: center;
    }

    .category-label {
        font-size: 16px;
        color: #566573;
        margin-right: 8px;
    }

    .category-name {
        font-size: 20px;
        color: #2c3e50;
        font-weight: 600;
    }

    .card-content {
        padding: 0;
    }

    .card-section {
        padding: 25px;
        border-bottom: 1px solid #eaeaea;
    }

    .card-section:last-child {
        border-bottom: none;
    }

    /* Preview Section */
    .preview-section {
        background-color: #ffffff;
    }

    .category-preview {
        display: flex;
        align-items: center;
    }

    .category-visual {
        flex: 0 0 120px;
        margin-right: 25px;
    }

    .category-image, .category-icon-display {
        width: 120px;
        height: 120px;
        border-radius: 50%; /* Changé de 10px à 50% pour créer un cercle parfait */
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .category-image {
        background-size: cover;
        background-position: center;
    }

    .category-icon-display {
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 48px;
    }

    .category-details {
        flex: 1;
    }

    .detail-item {
        margin-bottom: 12px;
    }

    .detail-label {
        font-weight: 600;
        color: #566573;
        margin-right: 6px;
        min-width: 100px;
        display: inline-block;
    }

    .detail-value {
        color: #2c3e50;
    }

    /* Warning Section */
    .warning-section {
        display: flex;
        align-items: flex-start;
        background-color: #fff8f8;
    }

    .warning-icon {
        flex: 0 0 60px;
        font-size: 32px;
        color: #e74c3c;
        display: flex;
        justify-content: center;
        padding-top: 5px;
    }

    .warning-message {
        flex: 1;
    }

    .warning-message h2 {
        color: #c0392b;
        font-size: 20px;
        margin-top: 0;
        margin-bottom: 15px;
    }

    .warning-message p {
        color: #555;
        margin-bottom: 15px;
        line-height: 1.5;
    }

    .products-warning {
        background-color: #fff3cd;
        color: #856404;
        padding: 12px 15px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        margin-top: 15px;
        border-left: 4px solid #ffc107;
    }

    .products-warning i {
        margin-right: 10px;
        font-size: 18px;
    }

    /* Action Section */
    .action-section {
        background-color: #f8f9fa;
    }

    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 20px;
        border-radius: 6px;
        font-size: 15px;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        cursor: pointer;
        border: none;
    }

    .btn i {
        margin-right: 8px;
    }

    .btn-cancel {
        background-color: #ecf0f1;
        color: #7f8c8d;
        border: 1px solid #dfe6e9;
    }

    .btn-cancel:hover {
        background-color: #dfe6e9;
        color: #2c3e50;
    }

    .btn-delete {
        background-color: #e74c3c;
        color: white;
    }

    .btn-delete:hover {
        background-color: #c0392b;
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .category-preview {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .category-visual {
            margin-right: 0;
            margin-bottom: 20px;
        }

        .warning-section {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .warning-icon {
            margin-bottom: 15px;
        }

        .action-buttons {
            flex-direction: column-reverse;
            width: 100%;
        }

        .btn {
            width: 100%;
        }

        .detail-label {
            display: block;
            margin-bottom: 5px;
        }
    }
</style>
@endsection