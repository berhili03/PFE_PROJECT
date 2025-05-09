@extends('layouts.admin')

@section('content')

<link rel="stylesheet" href="{{ asset('css/suivreCommercant.css') }}">


{{-- ================== CONTENU PRINCIPAL ================== --}}
<div class="commercants-container">
    {{-- Titre de la page --}}
    <h1 class="commercants-title">Commerçants que vous suivez</h1>

    {{-- Vérifie si des commerçants sont suivis --}}
    @if($commercantsSuivis->count() > 0)

    {{-- Grille des cartes commerçants --}}
    <div class="commercants-cards-grid">
        @foreach($commercantsSuivis as $commercant)
        <div class="commercant-card">
            <div class="commercant-card-body">
                {{-- Nom du commerçant --}}
                <h5 class="commercant-name">{{ $commercant->name }}</h5>

                {{-- Adresse du commerçant --}}
                <p class="commercant-address">{{ $commercant->adresse }}</p>

                {{-- Boutons d’action --}}
                <div class="action-buttons">
                    {{-- Lien vers la page de produits du commerçant --}}
                    <a href="{{ route('admin.commercants.show', $commercant->id) }}" class="btn-view-products">
                        Voir les produits
                    </a>

                    {{-- Formulaire pour arrêter de suivre ce commerçant --}}
                    <form action="{{ route('admin.commercants.neplussuivre', $commercant->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-unfollow">Ne plus suivre</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="commercants-pagination">
        {{ $commercantsSuivis->links() }}
    </div>

    @else
    {{-- Message si aucun commerçant n’est suivi --}}
    <div class="no-commercants-alert">
        Vous ne suivez aucun commerçant pour le moment.  
        <a href="{{ route('admin.commercants.index') }}">Parcourir les commerçants</a>
    </div>
    @endif
</div>

@endsection
