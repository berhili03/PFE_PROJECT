<!-- resources/views/admin/users/consommateurs.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">Gestion des consommateurs</h1>
            <p class="text-muted">Liste de tous les consommateurs enregistrés sur la plateforme</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Ajouter un consommateur
            </a>
        </div>
    </div>

    <!-- Onglets de navigation -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.users.index') }}">Tous les utilisateurs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.users.commercants') }}">Commerçants</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.users.consommateurs') }}">Consommateurs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ route('admin.users.create') }}">Ajouter un compte</a>
        </li>
    </ul>

    <!-- Recherche -->
    <div class="card mb-4">
        <div class="card-body">
            <form class="search-form" action="{{ route('admin.users.consommateurs') }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Rechercher un consommateur..." name="search" value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Date de naissance</th>
                            <th>Téléphone</th>
                            <th>Date d'inscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar rounded-circle me-3" style="background: linear-gradient(45deg, {{ $colorPalettes[crc32($user->name) % count($colorPalettes)]['from'] }}, {{ $colorPalettes[crc32($user->name) % count($colorPalettes)]['to'] }});">
                                        <span class="text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $user->name }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->created_at)
                                    {{ $user->created_at->format('d/m/Y') }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $user->tel ?: 'Non renseigné' }}</td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-info me-2" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce consommateur?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $users->links() }}
    </div>
</div>

<style>
    .avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
</style>
@endsection