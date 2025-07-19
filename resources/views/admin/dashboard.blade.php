<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    @include('layouts.header')

    <section class="container-dashboard-admin">
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
                        @foreach($pendingRequests as $user)
                        <tr>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->nom_entreprise }}</td>
                            <td class="actions-cell">
                                <form action="{{ route('admin.approve', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-action btn-approve">✓ Approuver</button>
                                </form>
                                <form action="{{ route('admin.reject', $user->id) }}" method="POST" class="d-inline">
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
            <h2>Tableau de bord administrateur</h2>
            
            <div class="stats-cards">
                <div class="stat-card">
                    <h3>Demandes en attente</h3>
                    <p class="stat-value">{{ $pendingCount }}</p>
                    <a href="#pending-requests" class="stat-link">Voir</a>
                </div>
                
                <div class="stat-card">
                    <h3>Stands approuvés</h3>
                    <p class="stat-value">{{ $approvedCount }}</p>
                    <a href="#approved-stands" class="stat-link">Voir</a>
                </div>
            </div>
        </section>
    </section>


    @include('layouts.footer')
</body>
</html>