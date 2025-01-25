<?php

require_once 'AbstractControleur.php';
require_once 'vue/PanierVue.php';
require_once 'modele/PanierModele.php';

class PanierControleur extends AbstractControleur
{
    private $panierModele;
    public function __construct()
    {
        $this->panierModele = new PanierModele();
    }
    protected function affichePage($vue)
    {
        $vue->affiche();
    }
    public function afficherPanier()
    {
        $vue = new PanierVue();
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $panier = $this->panierModele->getPanierParUtilisateur($userId);
            $vue->setPanier($panier);
        }
        $this->affichePage($vue);
    }
    public function supprimerDuPanier($produitId)
    {
        //suppr les produits du panier quand cliqué
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $this->panierModele->supprimerProduitDuPanier($userId, $produitId);
        }
    
        header('Location: ?action=panier');
        exit();
    }

}