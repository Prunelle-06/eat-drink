<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @if (Session::has('success'))
        <p>{{ Session::get('success') }}</p>
    @endif
    <h1>Merci pour votre inscription</h1>
    <p>Votre demande de stand a bien été enregistré</p>
    <p>Un administrateur va l'examiner.Vous recevrez un email une fois approuvé</p>
</body>
</html>