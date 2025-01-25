<?php
class InscriptionVue
{
    private $titre;
    private $contenue;
    private $templateChemin;
    private $message;
    public function __construct($titre = "Inscription", $contenue = "", $templateChemin = 'template.php')
    {
        $this->titre = $titre;
        $this->contenue = $contenue;
        $this->templateChemin = $templateChemin;
    }
    public function setMessage($message)
    {
        $this->message = $message;
    }
    public function display()
    {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/style_connexion.css">
            <title><?php echo htmlspecialchars($this->titre); ?></title>
        </head>
        <body>
        <div class="MESSAGE">
        <?php if ($this->message) {
            echo "<p>" . htmlspecialchars($this->message) . "</p>";
        } ?>
        </div>
        <div class="container">
            <div class="wrap">
                <section class="login">
                    <div class="centre-titre">
                        <p>Inscription</p>
                    </div>
                    <form method="POST" action="?action=ajouterUtilisateur">
                        <div class="inputBox">
                            <ion-icon name="person"></ion-icon>
                            <input type="text" id="prenom" name="prenom" placeholder="Prénom" required>
                        </div>
                        <div class="inputBox">
                            <ion-icon name="person"></ion-icon>
                            <input type="text" id="nom" name="nom" placeholder="Nom" required>
                        </div>
                        <div class="inputBox">
                            <ion-icon name="mail"></ion-icon>
                            <input type="email" id="email" name="email" placeholder="E-mail" required>
                        </div>
                        <div class="inputBox">
                            <ion-icon name="eye"></ion-icon>
                            <input type="password" id="mdp" name="mdp" placeholder="Mot de passe" required>
                        </div>
                        <button type="submit">S'inscrire</button>
                        <div class="register">
                            <span>Déjà inscrit ? </span>
                            <a href="?action=connexion">Connectez-vous</a>
                        </div>
                    </form>
                    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
                </section>
            </div>
        </div>
        </body>
        </html>
        <?php
        $contenue = ob_get_clean();
        include $this->templateChemin;
    }
    public function affiche()
    {
        $this->display();
    }
}
