<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation de mot de passe</title>
</head>
<body>
    <h2>Bonjour {{ $user->name ?? 'Utilisateur' }},</h2>

    <p>Vous avez demandé à réinitialiser votre mot de passe. Cliquez sur le bouton ci-dessous :</p>

    <p>
        <a href="{{ $url }}" style="display:inline-block;padding:10px 20px;background-color:#3490dc;color:#fff;text-decoration:none;border-radius:5px;">
            Réinitialiser le mot de passe
        </a>
    </p>

    <p>Si vous n'avez pas fait cette demande, ignorez simplement ce message.</p>

    <p>Merci,<br>L'équipe {{ config('app.name') }}</p>
</body>
</html>
