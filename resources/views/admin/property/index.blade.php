@extends('layouts.admin')

@section('title', 'Gestion des produits')

@section('content')
    <div class="products-dashboard">
        {{-- Notification de succès --}}
        @if(session('success'))
            <div class="alert alert-success fade-in" id="success-alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="dashboard-header">
            <h1 class="dashboard-title">@yield('title')</h1>
            
            <div class="dashboard-actions">
               
            </div>
        </div>

        {{-- Filtres de recherche --}}
        <div class="filter-container">
            <form action="{{ route('admin.property.index') }}" method="GET" class="filter-form">
                <div class="filter-row">
                    <div class="filter-group">
                        <div class="input-icon">
                            <i class="fas fa-search icon-left"></i>
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}" 
                                placeholder="Rechercher un produit..." 
                                class="form-control"
                            >
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <div class="input-icon">
                            <i class="fas fa-store icon-left"></i>
                            <input 
                                type="text" 
                                name="commercant" 
                                value="{{ request('commercant') }}" 
                                placeholder="Nom du commerçant ou boutique..." 
                                class="form-control"
                            >
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <div class="input-icon">
                            <i class="fas fa-tag icon-left"></i>
                            <select name="categorie" class="form-control">
                                <option value="">Toutes les catégories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ request('categorie') === $cat ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <button type="submit" class="btn btn-filter">
                            <i class="fas fa-filter me-1"></i> Filtrer
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Tableau des produits --}}
        <div class="table-responsive">
            <table class="table products-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Commerçant</th>
                        <th>Boutique</th>
                        <th>Produit</th>
                        <th>Description</th>
                        <th>Catégorie</th>
                        <th>Marque</th>
                        <th>Image</th>
                        <th>Prix</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($properties->count())
                        @foreach($properties as $propriete)
                            <tr>
                                <td class="text-center">{{ $propriete->id }}</td>
                                <td>{{ $propriete->user->name }}</td>
                                <td>{{ $propriete->user->store_name ?: '—' }}</td>
                                <td>{{ $propriete->nomProduit }}</td>
                                <td class="description-cell">
                                    <div class="truncate-text">{{ $propriete->description }}</div>
                                </td>
                                <td>{{ $propriete->category_name }}</td>
                                <td>{{ $propriete->marque }}</td>
                                <td class="image-cell">
                                    @if($propriete->image)
                                        <img 
                                            src="{{ asset('storage/' . $propriete->image) }}" 
                                            alt="Image du produit"
                                            class="product-thumbnail"
                                        >
                                    @else
                                        <span class="no-image"><i class="fas fa-image"></i></span>
                                    @endif
                                </td>
                                <td class="price-cell">{{ number_format($propriete->prix, 0, ',', ' ') }} <span class="currency">MAD</span></td>
                                <td class="actions-cell">
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.property.edit', $propriete) }}" class="btn btn-edit" title="Éditer">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.property.destroy', $propriete) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-delete" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="10" class="text-center empty-result">
                                <i class="fas fa-box-open fs-2 mb-3"></i>
                                <p>Aucun produit trouvé</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="pagination-container">
            {{ $properties->links() }}
        </div>
    </div>

    {{-- Script pour la gestion de l'alerte de succès --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const alert = document.getElementById('success-alert');
            if (alert) {
                setTimeout(() => {
                    alert.classList.add('fade-out');
                    setTimeout(() => alert.remove(), 500);
                }, 3000);
            }
        });
    </script>
    <style>
        /*admin-style.css*/

/* ====== ADMIN DASHBOARD STYLES ====== */

/* General Styles */
:root {
    --primary-color: #3f51b5;
    --primary-hover: #303f9f;
    --secondary-color: #f50057;
    --success-color: #4caf50;
    --danger-color: #f44336;
    --warning-color: #ff9800;
    --info-color: #2196f3;
    --light-color: #f5f5f5;
    --dark-color: #212121;
    --gray-color: #9e9e9e;
    --gray-light: #e0e0e0;
    --gray-dark: #616161;
    --white: #ffffff;
    --shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    --border-radius: 6px;
    --transition: all 0.3s ease;
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: #f9f9fc;
    color: #333;
}

/* Alert Styles */
.alert {
    padding: 15px;
    border-radius: var(--border-radius);
    margin-bottom: 20px;
    position: relative;
}

.alert-success {
    background-color: rgba(76, 175, 80, 0.1);
    color: var(--success-color);
    border-left: 4px solid var(--success-color);
}

.fade-in {
    animation: fadeIn 0.5s;
}

.fade-out {
    animation: fadeOut 0.5s;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeOut {
    from { opacity: 1; transform: translateY(0); }
    to { opacity: 0; transform: translateY(-10px); }
}

/* Dashboard Header */
.products-dashboard {
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.dashboard-title {
    font-size: 24px;
    font-weight: 600;
    color: var(--dark-color);
    margin: 0;
}

.dashboard-actions {
    display: flex;
    gap: 10px;
}

.add-product-btn {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: var(--border-radius);
    font-weight: 500;
    text-decoration: none;
    transition: var(--transition);
    display: flex;
    align-items: center;
}

.add-product-btn:hover {
    background-color: var(--primary-hover);
    box-shadow: var(--shadow);
}

/* Filter Styles */
.filter-container {
    background-color: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    padding: 20px;
    margin-bottom: 25px;
}

.filter-form {
    width: 100%;
}

.filter-row {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

.filter-group {
    flex: 1;
    min-width: 200px;
}

.input-icon {
    position: relative;
}

.icon-left {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-color);
}

.form-control {
    width: 100%;
    padding: 10px 15px 10px 38px;
    border: 1px solid var(--gray-light);
    border-radius: var(--border-radius);
    font-size: 14px;
    transition: var(--transition);
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(63, 81, 181, 0.25);
    outline: none;
}

.btn-filter {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 10px 16px;
    border-radius: var(--border-radius);
    cursor: pointer;
    transition: var(--transition);
    font-weight: 500;
    display: flex;
    align-items: center;
}

.btn-filter:hover {
    background-color: var(--primary-hover);
}

/* Table Styles */
.table-responsive {
    background-color: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    margin-bottom: 25px;
}

.products-table {
    width: 100%;
    border-collapse: collapse;
}

.products-table th {
    background-color: #f5f7ff;
    color: var(--dark-color);
    font-weight: 600;
    text-align: left;
    padding: 15px;
    font-size: 14px;
    border-bottom: 2px solid var(--gray-light);
}

.products-table td {
    padding: 15px;
    border-bottom: 1px solid var(--gray-light);
    vertical-align: middle;
    font-size: 14px;
}

.products-table tr:last-child td {
    border-bottom: none;
}

.products-table tr:hover {
    background-color: #f9f9fc;
}

.description-cell {
    max-width: 250px;
}

.truncate-text {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

.image-cell {
    width: 60px; /* Réduit de 80px à 60px */
    text-align: center;
}

.product-thumbnail {
    width: 50px; /* Réduit de 60px à 50px */
    height: 50px; /* Réduit de 60px à 50px */
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid var(--gray-light);
}

.no-image {
    width: 50px; /* Réduit de 60px à 50px */
    height: 50px; /* Réduit de 60px à 50px */ 
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f5f5f5;
    border-radius: 4px;
    color: var(--gray-color);
    margin: 0 auto;
}

.price-cell {
    font-weight: 600;
    text-align: right;
}

.currency {
    color: var(--gray-color);
    font-size: 12px;
    font-weight: normal;
}

.actions-cell {
    width: 120px;
}

.action-buttons {
    display: flex;
    gap: 8px;
    justify-content: center;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
    text-decoration: none;
    border: none;
}

.btn-edit {
    background-color: var(--info-color);
    color: white;
    width: 32px; /* Réduit de 36px à 32px */
    height: 32px; /* Réduit de 36px à 32px */
    border-radius: 50%;
}

.btn-edit:hover {
    background-color: #1976d2;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.btn-delete {
    background-color: var(--danger-color);
    color: white;
    width: 32px; /* Réduit de 36px à 32px */
    height: 32px; /* Réduit de 36px à 32px */
    border-radius: 50%;
}

.btn-delete:hover {
    background-color: #d32f2f;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.empty-result {
    padding: 50px;
    text-align: center;
    color: var(--gray-color);
}

.empty-result i {
    font-size: 48px;
    margin-bottom: 15px;
    color: var(--gray-light);
}

/* Pagination Styles */
.pagination-container {
    display: flex;
    justify-content: center;
}

.pagination {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 5px;
}

.page-item {
    margin: 0 2px;
}

.page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px; /* Réduit de 36px à 32px */
    height: 32px; /* Réduit de 36px à 32px */
    border-radius: 50%;
    border: 1px solid var(--gray-light);
    background-color: var(--white);
    color: var(--dark-color);
    text-decoration: none;
    transition: var(--transition);
}

.page-item.active .page-link {
    background-color: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.page-link:hover {
    background-color: #f5f7ff;
}

.page-item.disabled .page-link {
    color: var(--gray-light);
    cursor: not-allowed;
    background-color: #f9f9f9;
}

/* ====== FORM STYLES ====== */

.product-form-wrapper {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
}

.form-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.form-title {
    font-size: 24px;
    font-weight: 600;
    color: var(--dark-color);
    margin: 0;
    display: flex;
    align-items: center;
}

.btn-back {
    display: flex;
    align-items: center;
    background-color: var(--white);
    color: var(--gray-dark);
    border: 1px solid var(--gray-light);
    padding: 8px 16px;
    border-radius: var(--border-radius);
    font-weight: 500;
    text-decoration: none;
    transition: var(--transition);
}

.btn-back:hover {
    background-color: #f5f7ff;
    color: var(--primary-color);
}

.form-card {
    background-color: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    padding: 30px;
}

.product-form {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.form-section {
    border-bottom: 1px solid var(--gray-light);
    padding-bottom: 25px;
}

.form-section:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--primary-color);
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e8eaf6;
}

.form-row {
    margin-bottom: 20px;
}

.form-row:last-child {
    margin-bottom: 0;
}

.two-columns {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: var(--dark-color);
}

.form-control-static {
    background-color: #f5f7ff;
    padding: 10px 15px;
    border: 1px solid var(--gray-light);
    border-radius: var(--border-radius);
    color: var(--gray-dark);
    font-weight: 500;
}

.form-control {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid var(--gray-light);
    border-radius: var(--border-radius);
    font-size: 14px;
    transition: var(--transition);
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(63, 81, 181, 0.25);
    outline: none;
}

.form-control.required {
    border-left: 4px solid var(--primary-color);
}

.select-wrapper {
    position: relative;
}

.select-arrow {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    border-style: solid;
    border-width: 6px 6px 0 6px;
    border-color: var(--gray-color) transparent transparent transparent;
}

.invalid-feedback {
    color: var(--danger-color);
    font-size: 12px;
    margin-top: 5px;
}

.is-invalid {
    border-color: var(--danger-color);
}

textarea.form-control {
    min-height: 120px;
    resize: vertical;
}

.image-upload-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
    margin-top: 10px;
}

.image-preview-container {
    position: relative;
    width: 150px; /* Réduit de 200px à 150px */
    height: 150px; /* Réduit de 200px à 150px */
    border-radius: var(--border-radius);
    overflow: hidden;
    border: 2px dashed var(--gray-light);
    cursor: pointer;
    transition: var(--transition);
}

.image-preview-container:hover {
    border-color: var(--primary-color);
}

.image-preview {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.image-preview:not(.has-image) {
    display: none;
}

.preview-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: var(--transition);
}

.image-preview-container:hover .preview-overlay {
    opacity: 1;
}

.preview-text {
    color: white;
    text-align: center;
    padding: 15px; /* Réduit de 20px à 15px */
}

.preview-text i {
    font-size: 24px; /* Réduit de 32px à 24px */
    margin-bottom: 8px; /* Réduit de 10px à 8px */
    display: block;
}

.image-info {
    font-size: 13px;
    color: var(--gray-color);
    margin-top: 5px;
}

.form-control-file {
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
    overflow: hidden;
}

/* Form Actions Styles */
.form-actions {
    display: flex;
    gap: 15px;
    justify-content: flex-start;
    margin-top: 30px;
}

.btn-primary {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: var(--border-radius);
    font-weight: 500;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-primary:hover {
    background-color: var(--primary-hover);
    box-shadow: var(--shadow);
}

.btn-secondary {
    background-color: var(--white);
    color: var(--gray-dark);
    border: 1px solid var(--gray-light);
    padding: 10px 20px;
    border-radius: var(--border-radius);
    font-weight: 500;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

.btn-secondary:hover {
    background-color: #f5f7ff;
    color: var(--primary-color);
}

/* Additional Product Form Styles */
#product-newCategoryField {
    display: none;
}

#product-newCategoryField.visible {
    display: block;
}

.has-preview .preview-overlay {
    opacity: 0;
}

.has-preview:hover .preview-overlay {
    opacity: 1;
}

/* Store Info Section (Profile page) */
.store-info-section {
    background-color: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    padding: 25px;
    margin-bottom: 30px;
}

.store-header {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.store-logo {
    width: 60px; /* Réduit de 80px à 60px */
    height: 60px; /* Réduit de 80px à 60px */
    border-radius: 50%;
    object-fit: cover;
    margin-right: 15px; /* Réduit de 20px à 15px */
    border: 2px solid var(--primary-color); /* Réduit de 3px à 2px */
}

.store-name {
    font-size: 22px; /* Réduit de 24px à 22px */
    font-weight: 600;
    color: var(--dark-color);
    margin: 0;
    margin-bottom: 5px;
}

.store-meta {
    color: var(--gray-color);
    font-size: 14px;
}

.store-description {
    margin-bottom: 20px;
    line-height: 1.6;
}

.store-contact-info {
    display: flex;
    gap: 20px; /* Réduit de 30px à 20px */
    flex-wrap: wrap;
    margin-top: 20px;
}

.contact-item {
    display: flex;
    align-items: center;
}

.contact-icon {
    width: 36px; /* Réduit de 40px à 36px */
    height: 36px; /* Réduit de 40px à 36px */
    background-color: #f5f7ff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-color);
    margin-right: 12px; /* Réduit de 15px à 12px */
}

.contact-text {
    display: flex;
    flex-direction: column;
}

.contact-label {
    font-size: 12px;
    color: var(--gray-color);
}

.contact-value {
    font-weight: 500;
    color: var(--dark-color);
}

/* Responsive Styles */
@media (max-width: 992px) {
    .two-columns {
        grid-template-columns: 1fr;
    }
    
    .filter-row {
        flex-direction: column;
    }
    
    .form-card {
        padding: 20px;
    }
    
    .image-preview-container {
        width: 120px; /* Encore plus petit sur mobile */
        height: 120px; /* Encore plus petit sur mobile */
    }
}

@media (max-width: 768px) {
    .dashboard-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .dashboard-actions {
        width: 100%;
    }
    
    .add-product-btn {
        width: 100%;
        justify-content: center;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 10px;
    }
    
    .btn-edit, .btn-delete {
        width: 100%;
        border-radius: var(--border-radius);
        height: auto;
        padding: 8px;
    }
    
    .products-table {
        display: block;
        overflow-x: auto;
    }
    
    .store-logo {
        width: 50px; /* Encore plus petit sur mobile */
        height: 50px; /* Encore plus petit sur mobile */
    }
    
    .product-thumbnail {
        width: 40px; /* Encore plus petit sur mobile */
        height: 40px; /* Encore plus petit sur mobile */
    }
    
    .no-image {
        width: 40px; /* Encore plus petit sur mobile */
        height: 40px; /* Encore plus petit sur mobile */
    }
}
    </style>
@endsection