<?php
class ConnexionVue
{
    private $titre;
    private $contenue;
    private $templateChemin;
    private $message;
    public function __construct($titre = "Connexion", $contenue = "", $templateChemin = 'template.php')
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
        $email = isset($_COOKIE['email']) ? $_COOKIE['email'] : '';
        $mdp = isset($_COOKIE['mdp']) ? $_COOKIE['mdp'] : '';
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
    <?php if ($this->message) {
                echo "<p>" . htmlspecialchars($this->message) . "</p>";
            } ?>
    <div class="container">
        <div class="wrap">
            <section class="login">
                <div class="centre-titre">
                    <p>Connexion</p>
                </div>
                <form method="POST" action="?action=verifierConnexion">
                    <div class="inputBox">
                        <ion-icon name="mail"></ion-icon>
                        <input type="email" id="email" name="email" placeholder="E-mail" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                    <div class="inputBox">
                        <ion-icon name="eye"></ion-icon>
                        <input type="password" id="mdp" name="mdp" placeholder="Mot de passe" value="<?php echo htmlspecialchars($mdp); ?>" required>
                    </div>
                    <div class="forgot">
                        <input type="checkbox" id="rememberMe" name="rememberMe"
                            <?php echo isset($_COOKIE['email']) ? 'checked' : ''; ?>>
                        <label for="rememberMe">Se souvenir de moi</label>
                    </div>
                    <button type="submit">Connexion</button>
                    <div class="register">
                        <span>Pas encore inscrit ? </span>
                        <a href="?action=inscription">Inscrivez-Vous</a>
                    </div>
                    <div class="Important"><span>login admin : admin123@gmail.com</span></br>
                        <span>mdp admin : admin</span>
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