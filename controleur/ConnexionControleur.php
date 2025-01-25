<?php

require_once 'AbstractControleur.php';
require_once 'vue/ConnexionVue.php';
require_once 'modele/ConnexionModele.php';

class ConnexionControleur extends AbstractControleur
{
    public function affichePage($vue)
    {
        $vue->affiche();
    }

    /**
     * Affiche la page de connexion
     */
    public function afficherConnexion()
    {
        //Affiche la page de connexion si l'utilisateur n'est pas connecté
        $vue = new ConnexionVue();
        $this->affichePage($vue);
    }

    /**
     * Vérifie les informations de connexion de l'utilisateur
     */
    public function verifierConnexion()
    {
        //Permet de vérifier les infos de l'utilisateur lors de la connexion
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? null;
            $mdp = $_POST['mdp'] ?? null;
            $rememberMe = isset($_POST['rememberMe']);

            if (!$email || !$mdp) {
                $vue = new ConnexionVue();
                $vue->setMessage("Veuillez remplir tous les champs.");
                $this->affichePage($vue);
                return;
            }

            $modele = new ConnexionModele();
            $utilisateur = $modele->verifierUtilisateur($email, $mdp);
            $vue = new ConnexionVue();

            //Clear du panier lorsqu'un nouvel utilisateur se connecte
            if ($utilisateur) {
                if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== $utilisateur['id']) {
                    unset($_SESSION['panier']);
                }

                $_SESSION['user_id'] = $utilisateur['id_client'];
                $_SESSION['nom_utilisateur'] = $utilisateur['nom'];
                $_SESSION['prenom_utilisateur'] = $utilisateur['prenom'];
                $_SESSION['email_utilisateur'] = $utilisateur['email'];

                //Cookie pour maintenir la connexion
                if ($rememberMe) {
                    setcookie('email', $email, time() + (86400 * 30), "/"); //30 jours
                    setcookie('mdp', $mdp, time() + (86400 * 30), "/");
                } else {
                    setcookie('email', '', time() - 3600, "/");
                    setcookie('mdp', '', time() - 3600, "/");
                }

                header('Location: ?action=accueil');
                exit();
            } else {
                $vue->setMessage("Adresse email ou mot de passe incorrect.");
                $this->affichePage($vue);
            }
        } else {
            $this->afficherConnexion();
        }
    }

    /**
     * Déconnecte l'utilisateur et détruit la session
     */
    public function deconnexion()
    {
        session_unset();
        session_destroy();
        setcookie('email', '', time() - 3600, "/");
        setcookie('mdp', '', time() - 3600, "/");
        header('Location: ?action=connexion');
        exit();
    }
}