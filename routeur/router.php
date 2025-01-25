<?php
require_once './controleur/AccueilControleur.php';
require_once './controleur/InscriptionControleur.php';
require_once './controleur/ConnexionControleur.php';
require_once './controleur/PanierControleur.php';
require_once './controleur/ArticleControleur.php';
require_once './controleur/AdminControleur.php';
require_once './controleur/CommandeControleur.php';
require_once './controleur/DeconnexionControleur.php';

class Router
{
    public function route()
    {
        // Définition de l'action par défaut
        $action = isset($_GET['action']) ? $_GET['action'] : 'accueil';
        $controleur = new AccueilControleur();
        switch ($action) {
            case 'accueil':
                $controleur->afficherAccueil();
                break;

            case 'inscription':
                $controleur = new InscriptionControleur();
                $controleur->afficherFormulaire();
                break;

            case 'ajouterUtilisateur':
                $controleur = new InscriptionControleur();
                $controleur->ajouterUtilisateur();
                break;

            case 'connexion':
                $controleur = new ConnexionControleur();
                $controleur->afficherConnexion();
                break;
            case 'verifierConnexion':
                $controleur = new ConnexionControleur();
                $controleur->verifierConnexion();
                break;

            case 'panier':
                $controleur = new PanierControleur();
                $controleur->afficherPanier();
                break;
            case 'ajouterProduitPanier':
                $controleur = new ArticleControleur();
                $controleur->ajouterProduit();
                break;

            case 'supprimerDuPanier':
                if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                    $idProduit = $_GET['id'];
                    $controleur = new PanierControleur();
                    $controleur->supprimerDuPanier($idProduit);
                } else {
                    echo "Erreur : ID du produit invalide.";
                }
                break;

            case 'article':
                if (isset($_GET['id'])) {
                    $id = intval($_GET['id']);
                    $controleur = new ArticleControleur();
                    $controleur->afficherArticle($id);
                } else {
                    echo "Erreur : Aucun article spécifié.";
                }
                break;

            case 'admin':
                $controleur = new AdminControleur();
                $controleur->afficherAdmin();
                break;

            case 'ajouterProduit':
                $controleur = new AdminControleur();
                $controleur->ajouterProduit();
                break;

            case 'supprimerProduit':
                $controleur = new AdminControleur();
                $controleur->supprimerProduit();
                break;
            
            case 'setQuantiteProduit':
                $controleur = new AdminControleur();
                $controleur->mettreAjourQuantite();
                break;

                    
            case 'supprimerFournisseur':
                $controleur = new AdminControleur();
                $controleur->supprimerFournisseur();
                break;

            case 'passerCommande':
                $controleur = new CommandeControleur();
                $controleur->passerCommande();
                break;

            case 'supprimerFacture':
                $controleur = new AdminControleur();
                $controleur->supprimerFacture();
                break;

            case 'confirmationCommande':
                $controleur = new CommandeControleur();
                $controleur->afficherCommande();
                break;

            case 'deconnexion':
                $controleur = new DeconnexionControleur();
                $controleur->deconnecter();
                break;

            default:
                echo "Erreur 404 : Page non trouvée";
                break;
        }
    }
}