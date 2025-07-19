<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    @include('layouts.header')

    <!-- Section Tableau -->
    <section class="admin-table-section" id="pending-requests">
        <h2>Demandes en attente de validation</h2>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Nom Entreprise</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->nom_entreprise }}</td>
                        <td class="actions-cell">
                            <form action="" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn-action btn-approve">✓ Approuver</button>
                            </form>
                            <form action="" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn-action btn-reject">✗ Rejeter</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <!-- Section Statistiques -->
    <section class="admin-stats-section">
        <h1>Tableau de bord administrateur</h1>
        
        <div class="stats-cards">
            <div class="stat-card">
                <h3>Demandes en attente</h3>
                <p class="stat-value"></p>
                <a href="#pending-requests" class="stat-link">Voir</a>
            </div>
            
            <div class="stat-card">
                <h3>Stands approuvés</h3>
                <p class="stat-value"></p>
                <a href="#approved-stands" class="stat-link">Voir</a>
            </div>
        </div>
    </section>
</body>
</html>