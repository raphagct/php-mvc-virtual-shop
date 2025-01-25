<?php

require_once 'AbstractControleur.php';
require_once 'vue/CommandeVue.php';
require_once 'modele/CommandeModele.php';
class CommandeControleur extends AbstractControleur
{
    //Toujours pareil pour tous les controleurs
    public function affichePage($vue)
    {
        $vue->affiche();
    }
    public function afficherCommande()
    {
        //Instanciation du modèle et de la vue
        $modele = new CommandeModele();
        $facture = $modele->afficherFacturation();
        $vue = new CommandeVue();

        // donne les données à manger à la vue
        $vue->setDonnees($facture);
        $this->affichePage($vue);
            
        
    }
    public function passerCommande()
    {
        //Vérif que l'user est connecté
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
    
            // Appeler la méthode pour créer la facturation
            $modele = new CommandeModele();
            $resultatFacturation = $modele->creerFacturation($userId);

            //Si la facture est bien créer alors on redirige vers la page de confirmation
            if ($resultatFacturation['succes']) {
                // Récupérer la facture pour l'envoyer par email
                $facture = $modele->afficherFacturation();

                //Si l'user n'est plus connecté alors on supprime le panier
                if (isset($_SESSION['user_id'])) {
                    $userId = $_SESSION['user_id'];
                    $modele->supprPanier($userId);
                }
                header('Location: index.php?action=confirmationCommande');
                exit();
            } else {
                // Afficher le message d'erreur en cas de succès ou de rejet
                echo "Erreur : " . $resultatFacturation['message'];
            }
        } else {
            echo "Utilisateur non connecté.";
        }
    }

    

   
}