@extends('layouts.admin')

@section('title', 'Gestion des catégories')

@section('content')
<div class="categories-container">
    <!-- Titre et bouton d'ajout -->
    <div class="categories-header">
        <h1>Gestion des catégories</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn-add-category">
            <i class="fas fa-plus"></i> Ajouter une catégorie
        </a>
    </div>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="alert-success" id="success-alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Affichage des catégories en cercles -->
    <div class="categories-circles">
        @forelse($categories as $category)
            <div class="category-item">
                <div class="category-circle" style="background-color: {{ $category->color ?? '#3498db' }}">
                    @if($category->image)
                        <div class="category-image" style="background-image: url({{ asset('storage/' . $category->image) }})"></div>
                    @elseif($category->icon)
                        <i class="fas {{ $category->icon }}"></i>
                    @else
                        <span class="category-initial">{{ strtoupper(substr($category->name, 0, 1)) }}</span>
                    @endif
                </div>
                <div class="category-details">
                    <h3 class="category-name">{{ $category->name }}</h3>
                    <span class="category-count">{{ $category->products_count }} produits</span>
                </div>
                <div class="category-actions">
                    <a href="{{ route('admin.categories.show', $category) }}" class="btn-view" title="Voir">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn-edit" title="Modifier">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="{{ route('admin.categories.delete', $category) }}" class="btn-delete" title="Supprimer">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="empty-categories">
                <i class="fas fa-tags fa-3x"></i>
                <p>Aucune catégorie n'a été créée. Commencez par en ajouter une !</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    .categories-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .categories-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .categories-header h1 {
        color: #333;
        font-size: 24px;
        margin: 0;
    }

    .btn-add-category {
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border-radius: 4px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: background-color 0.3s;
    }

    .btn-add-category:hover {
        background-color: #45a049;
    }

    .btn-add-category i {
        margin-right: 5px;
    }

    .alert-success {
        background-color: #dff0d8;
        color: #3c763d;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid #d6e9c6;
        border-radius: 4px;
        animation: fadeOut 5s forwards;
    }

    @keyframes fadeOut {
        0% { opacity: 1; }
        80% { opacity: 1; }
        100% { opacity: 0; }
    }

    /* Nouveau style pour l'affichage en cercles */
    .categories-circles {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        justify-content: center;
    }

    .category-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 150px;
        position: relative;
        text-align: center;
        margin-bottom: 15px;
    }

    .category-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        color: white;
        font-size: 30px;
        transition: transform 0.3s, box-shadow 0.3s;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    
    .category-item:hover .category-circle::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
    }

    .category-circle:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .category-image {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
    }

    .category-initial {
        font-weight: bold;
        font-size: 40px;
    }

    .category-details {
        width: 100%;
    }

    .category-name {
        margin: 0 0 5px;
        font-size: 16px;
        font-weight: 600;
        color: #333;
    }

    .category-count {
        display: block;
        font-size: 14px;
        color: #666;
    }

    /* Nouveaux styles pour les boutons d'action */
    .category-actions {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 10px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 10;
    }
    
    .category-item:hover .category-actions {
        opacity: 1;
    }

    .btn-view, .btn-edit, .btn-delete {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .btn-view {
        background-color: #3498db;
    }

    .btn-view:hover {
        background-color: #2980b9;
        transform: translateY(-3px);
    }

    .btn-edit {
        background-color: #f39c12;
    }

    .btn-edit:hover {
        background-color: #d35400;
        transform: translateY(-3px);
    }

    .btn-delete {
        background-color: #e74c3c;
    }

    .btn-delete:hover {
        background-color: #c0392b;
        transform: translateY(-3px);
    }

    .delete-form {
        margin: 0;
    }

    .empty-categories {
        width: 100%;
        text-align: center;
        padding: 40px;
        background-color: #f9f9f9;
        border-radius: 10px;
        color: #777;
    }

    .empty-categories i {
        margin-bottom: 15px;
        color: #ddd;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation pour le message de succès
    const alertSuccess = document.getElementById('success-alert');
    if (alertSuccess) {
        setTimeout(() => {
            alertSuccess.style.opacity = '0';
            setTimeout(() => {
                alertSuccess.style.display = 'none';
            }, 500);
        }, 4500);
    }
    
    // Redirige vers la page de détails lors du clic sur le cercle
    document.querySelectorAll('.category-circle').forEach(circle => {
        circle.addEventListener('click', function() {
            const categoryItem = this.closest('.category-item');
            const viewLink = categoryItem.querySelector('.btn-view');
            if (viewLink) {
                window.location.href = viewLink.getAttribute('href');
            }
        });
    });
});
</script>
@endsection