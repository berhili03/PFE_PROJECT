@extends('layouts.admin') {{-- Change si nécessaire --}}

@section('title', 'Gestion des produits')

@section('content')

    {{-- Affichage du message de succès --}}
    @if(session('success'))
        <div class="custom-alert-success" id="success-alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-container">

        {{-- Titre et formulaire de filtre --}}
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="product-table-title">@yield('title')</h1>
            <table> <tr> <td></td> </tr>
                    <tr> <td></td> </tr>
                    <tr> <td></td> </tr>
                    <tr> <td></td> </tr>
            </table>
            <form action="{{ route('admin.property.index') }}" method="GET" class="product-filter-form">
                <div class="product-filter-group">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Rechercher un produit..." 
                        class="product-filter-input"
                    >
                    <input 
                        type="text" 
                        name="commercant" 
                        value="{{ request('commercant') }}" 
                        placeholder="Nom du commerçant..." 
                        class="product-filter-input"
                    >

                    <select name="categorie" class="product-filter-select">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('categorie') === $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="product-filter-button">🔍 Filtrer</button>
                </div>
            </form>
            <table> <tr> <td></td> </tr>
                    <tr> <td></td> </tr>
                   
         

        {{-- Tableau des produits --}}
        <table class="table product-table">
            <thead>
                <tr>
                    <th style="text-align: center;">ID</th>
                    <th style="text-align: center;">Commerçant</th>
                    <th style="text-align: center;">Nom produit</th>
                    <th style="text-align: center;">Description</th>
                    <th style="text-align: center;">Catégorie</th>
                    <th style="text-align: center;">Marque</th>
                    <th style="text-align: center;">Image</th>
                    <th style="text-align: center;">Prix</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($properties->count())
                    @foreach($properties as $propriete)
                        <tr>
                            <td>{{ $propriete->id }}</td>
                            <td>{{ $propriete->user->name }}</td>
                            <td>{{ $propriete->nomProduit }}</td>
                            <td>{{ $propriete->description }}</td>
                            <td>{{ $propriete->category_name }}</td>
                            <td>{{ $propriete->marque }}</td>
                            <td>
                                @if($propriete->image)
                                    <img 
                                        src="{{ asset('storage/' . $propriete->image) }}" 
                                        alt="Image du produit" 
                                        width="60"
                                    >
                                @else
                                    <span>Aucune image</span>
                                @endif
                            </td>
                            <td>{{ number_format($propriete->prix, 0, ',', ' ') }} mad</td>
                            <td>
                                <div class="product-action-buttons">
                                    <a href="{{ route('admin.property.edit', $propriete) }}" class="btn edit-product-btn">Éditer</a>

                                    <form action="{{ route('admin.property.destroy', $propriete) }}" method="POST" class="product-delete-form">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="btn delete-product-btn">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" class="text-center">Aucune propriété trouvée !</td>
                    </tr>
                @endif
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="pagination">
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

@endsection
