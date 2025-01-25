<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/template.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <title>Formations du Chef</title>
</head>

<body>
    <header>
        <div class="topnav">
            <div class="left">
                <h1>FORMATIONS DU CHEF</h1>
            </div>
            <div class="logo">
            </div>
            <div class="center">
            <a href="?action=accueil">Accueil</a>
            <a href="?action=inscription">Inscriptions</a>
            <?php if (isset($_SESSION['email_utilisateur'])): ?>
            <a href="?action=deconnexion">Déconnexion</a> <!-- Lien de déconnexion -->
            <?php else: ?>
            <a href="?action=connexion">Se connecter</a> <!-- Lien de connexion -->
            <?php endif; ?>
            <a href="?action=panier">Panier</a>
            <?php if (isset($_SESSION['email_utilisateur']) && $_SESSION['email_utilisateur'] === 'admin123@gmail.com'): ?>
            <a href="?action=admin">Admin</a>
            <?php endif; ?>
        </div>
        </div>
    </header>
    <main>
        <?= $contenue ?? ''; ?>
    </main>
</body>
<footer>
    <p>© 2024 VALENTIN FOUILLOUD - RAPHAEL GUICHET - UCA - IUT - INFO</p>
</footer>
</html>