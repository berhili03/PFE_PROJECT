<!-- resources/views/admin/users/index.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">Gestion des comptes</h1>
            <p class="text-muted">Liste de tous les utilisateurs de la plateforme</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Ajouter un compte
            </a>
        </div>
    </div>
    <!-- Onglets de navigation -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.users.index') }}">Tous les utilisateurs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.users.commercants') }}">Commerçants</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ route('admin.users.consommateurs') }}">Consommateurs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ route('admin.users.create') }}">Ajouter un compte</a>
        </li>
    </ul>
    <!-- Filtres et recherche -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-8">
                    <form class="search-form" action="{{ route('admin.users.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Rechercher un utilisateur..." name="search" value="{{ request('search') }}">
                            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="role-filter">
                        <option value="">Tous les rôles</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Commercant" {{ request('role') == 'Commercant' ? 'selected' : '' }}>Commerçant</option>
                        <option value="Consommateur" {{ request('role') == 'Consommateur' ? 'selected' : '' }}>Consommateur</option>
                    </select>
                </div>
            </div>
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
                            <th>Rôle</th>
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
                                        @if($user->role == 'Commercant' && $user->store_name)
                                            <small class="text-muted">{{ $user->store_name }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role == 'admin')
                                    <span class="badge bg-primary">Admin</span>
                                @elseif($user->role == 'Commercant')
                                    <span class="badge bg-success">Commerçant</span>
                                @elseif($user->role == 'Consommateur')
                                    <span class="badge bg-info">Consommateur</span>
                                @endif
                            </td>
                            <td>
                                @if($user->created_at)
                                    {{ $user->created_at->format('d/m/Y') }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-info me-2" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur?')">
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

@section('scripts')
<script>
    // Script pour le filtre par rôle
    document.getElementById('role-filter').addEventListener('change', function() {
        const role = this.value;
        let url = new URL(window.location);
        
        if (role) {
            url.searchParams.set('role', role);
        } else {
            url.searchParams.delete('role');
        }
        
        window.location.href = url.toString();
    });
</script>
@endsection