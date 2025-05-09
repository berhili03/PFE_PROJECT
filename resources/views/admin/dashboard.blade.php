@extends('layouts.admin')

@section('content')

        
        <div class="admin-stats-grid">
            <div class="admin-stat-card admin-stat-merchants">
                <p class="admin-stat-label">Commerçants</p>
                <p class="admin-stat-value">{{ $commercantCount }} inscrits</p>

            </div> <div class="admin-stat-card admin-stat-users">
                <p class="admin-stat-label">Consommateurs</p>
                <p class="admin-stat-value">{{ $consommateurCount }} inscrits</p>
            </div>
            <div class="admin-stat-card admin-stat-products">
                <p class="admin-stat-label">Produits</p>
                <p class="admin-stat-value">{{ $produitCount }} disponibles</p>
            </div>
            <div class="admin-stat-card admin-stat-growth">
                <p class="admin-stat-label">Statistiques</p>
                <p class="admin-stat-value">+5% croissance</p>
            </div>
        </div>
    </div>

   
@endsection
