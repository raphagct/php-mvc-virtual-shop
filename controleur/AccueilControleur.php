<?php

require_once 'AbstractControleur.php';
require_once 'vue/AccueilVue.php';
require_once 'modele/AccueilModele.php';
require_once 'modele/AdminModele.php';

class AccueilControleur extends AbstractControleur
{
    // Implémentation de la méthode abstraite affichePage
    public function affichePage($vue)
    {
        // Affiche la page via la vue
        $vue->affiche();
    }

    public function afficherAccueil()
    {
        $modele = new AccueilModele();
    
        // Récupération et validation des paramètres
        //htmlspecialchars : https://www.php.net/manual/fr/function.htmlspecialchars.php    Formatage des données d'HTML à php
        //is_numeric — Détermine si une variable est un nombre ou une chaîne numériqu
        //trim — Supprime les espaces en début et fin de chaîne
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $recherche = isset($_GET['recherche']) ? htmlspecialchars(trim($_GET['recherche'])) : null;
        $trier = isset($_GET['trier']) ? htmlspecialchars(trim($_GET['trier'])) : null;

        // Pagination de 8 produits par page pour un affichage agréable, augmentation possible
        $produitsParPage = 8;
        $offset = ($page - 1) * $produitsParPage;

        //alpha pour un tri alphabétique, prix_asc pour un tri par prix croissant, prix_desc pour un tri par prix décroissant, difficulte_asc pour un tri par difficulté croissante, difficulte_desc pour un tri par difficulté décroissante
        $triValide = ['alpha', 'prix_asc', 'prix_desc', 'difficulte_asc', 'difficulte_desc'];
        
        // Gestion des données
        if (!empty($recherche)) {
            // Recherche avec pagination
            $donnees = $modele->rechercherFormations($recherche, $produitsParPage, $offset);
            $totalProduits = $modele->compterProduitsRecherche($recherche);
        } elseif (in_array($trier, $triValide)) {
            // Tri avec pagination
            $donnees = $this->getDonneesTriees($modele, $trier, $produitsParPage, $offset);
            $totalProduits = $modele->compterProduits();
        } else {
            // Cas de base : Pagination sans recherche ni tri
            $donnees = $modele->recupererFormationsAvecPagination($produitsParPage, $offset);
            $totalProduits = $modele->compterProduits();
        }

        // ceil permet d'arronduir au chiffre supérieur
        $nombrePages = ceil($totalProduits / $produitsParPage);
    
        // Boutons dynamiques
        $hasNextPage = $page < $nombrePages;
        $hasPreviousPage = $page > 1;
    
        // Préparation de la vue
        $vue = new AccueilVue();
        if (isset($_SESSION['email_utilisateur']) && $_SESSION['email_utilisateur'] === 'admin123@gmail.com') {
            $alerteStock = $modele->recupererProduitStockFaible();
            if (!empty($alerteStock)) {
                $vue->setAlerteStock($alerteStock);
            }
        }
        $vue->setDonnees($donnees);
        $vue->setPagination($page, $nombrePages, $hasPreviousPage, $hasNextPage);
        $this->affichePage($vue);
    }
    
    //Méthode pour gérer les tris avec pagination
    private function getDonneesTriees($modele, $trier, $limit, $offset)
    {
        switch ($trier) {
            case 'alpha':
                return $modele->recupererFormationsTrieesAlpha($limit, $offset);
            case 'prix_asc':
                return $modele->recupererFormationsTrieesParPrix('ASC', $limit, $offset);
            case 'prix_desc':
                return $modele->recupererFormationsTrieesParPrix('DESC', $limit, $offset);
            case 'difficulte_asc':
                return $modele->recupererFormationsTrieesParDifficulte('ASC', $limit, $offset);
            case 'difficulte_desc':
                return $modele->recupererFormationsTrieesParDifficulte('DESC', $limit, $offset);
            default:
                return [];
        }
    }
}
    