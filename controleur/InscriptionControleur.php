<?php
$controllerChemin = dirname(__DIR__) . '/controleur/';

require_once $controllerChemin . '../modele/InscriptionModele.php';
require_once $controllerChemin . 'AbstractControleur.php';
require_once $controllerChemin . '../vue/InscriptionVue.php';

require_once 'AbstractControleur.php';
require_once 'vue/InscriptionVue.php';
require_once 'modele/InscriptionModele.php';

class InscriptionControleur extends AbstractControleur
{
    public function affichePage($vue)
    {
        $vue->affiche();
    }
    public function afficherFormulaire()
    {
        $vue = new InscriptionVue();
        $this->affichePage($vue);
    }
    public function ajouterUtilisateur()
    {


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $mdp = $_POST['mdp'];

            $modele = new InscriptionModele();
            $success = $modele->ajouterUtilisateur($nom, $prenom, $email, $mdp);

            $vue = new InscriptionVue();
            $vue->setMessage($success ? "Inscription réussie !" : "Erreur lors de l'inscription.");
            $this->affichePage($vue);
        }
    }


}
