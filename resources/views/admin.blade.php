<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header>
    
    </header>

    <main class="admin-dashboard">
        <h2>Tableau de bord admin</h2><br>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Entreprise</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Akouavi D.</td>
                    <td>akouavi@email.com</td>
                    <td>Akou Délices</td>
                    <td>
                        <button class="btn-approve">Approuver</button>
                        <button class="btn-reject">Rejeter</button>
                    </td>
                </tr>
                <tr>
                    <td>Marius T.</td>
                    <td>marius@food.com</td>
                    <td>Le Petit Goût</td>
                    <td>
                        <button class="btn-approve">Approuver</button>
                        <button class="btn-reject">Rejeter</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </main>
</body>
</html>