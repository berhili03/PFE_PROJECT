@extends('layouts.admin')
<!-- pour consulter commercant -->
@section('content')

<link rel="stylesheet" href="{{ asset('css/consulterCommercant.css') }}">

<div class="container py-5">
    <div class="section-header mb-5">
        <h1 class="section-title">Commerçants</h1>
        <p class="section-subtitle">Découvrez tous nos commerçants partenaires</p>
    </div>
    
    <!-- Formulaire de recherche corrigé -->
    <div class="search-container mb-5">
        <form action="{{ route('admin.commercants.index') }}" method="GET" class="search-form">
            <div class="search-input-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" class="search-input" placeholder="Rechercher un commerçant..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="search-button">Rechercher</button>
        </form>
    </div>
    
    <div class="merchants-grid">
        @foreach($commercants as $commercant)
        <div class="merchant-card">
            <div class="merchant-icon">
                <i class="fas fa-store"></i>
            </div>
            <div class="merchant-details">
                <h3 class="merchant-name">{{ $commercant->name }}</h3>
                <p class="merchant-address"><i class="fas fa-map-marker-alt"></i> {{ $commercant->adresse }}</p>
                @if($commercant->tel)
                <p class="merchant-phone"><i class="fas fa-phone"></i> {{ $commercant->tel }}</p>
                @endif
            </div>
            <a href="{{ route('admin.commercants.show', $commercant->id) }}" class="merchant-link">
                Voir les produits <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        @endforeach
    </div>
    
    <div class="pagination-container mt-5">
        {{ $commercants->links() }}
    </div>
</div>


@endsection