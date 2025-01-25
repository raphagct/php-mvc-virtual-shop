<?php
require_once 'AbstractControleur.php';
require_once 'vue/ArticleVue.php';
require_once 'modele/ArticleModele.php';
class ArticleControleur extends AbstractControleur
{
    // Implémentation de la méthode abstraite affichePage
    public function affichePage($vue)
    {
        $vue->affiche(); // Appelle la méthode affiche() de l'objet vue pour afficher la page
    }

    public function afficherArticle($id)
    {
        // Récupérer les détails de l'article depuis le modèle
        $articleModele = new ArticleModele();
        $article = $articleModele->recupererFormationParId($id);

        if ($article) {
            // Si l'article est trouvé, afficher une vue spécifique pour cet article
            $vue = new ArticleVue();
            $vue->setDonnees($article); // Transmettre les données du produit à la vue
            $this->affichePage($vue);
        } else {
            echo "Article introuvable.";
        }
    }
    public function ajouterProduit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['action_formulaire'])) {
                $actionFormulaire = $_POST['action_formulaire'];
                if ($actionFormulaire === 'ajouterPanier') {
                    // Vérifier que les données nécessaires sont présentes dans la requête POST
                    if (isset($_POST['id_formation'], $_POST['nom_formation'], $_POST['prix_formation'], $_POST['quantite'])) {
                        // Vérifier que la session est démarrée et que user_id est défini
                        if (!isset($_SESSION['user_id'])) {
                            echo "Erreur: utilisateur non connecté.";
                            return;
                        }

                        $idFormation = $_POST['id_formation'];
                        $quantiteFormation = $_POST['quantite'];
                        $userId = $_SESSION['user_id'];

                        // Vérifier les valeurs des variables
                        var_dump($idFormation, $quantiteFormation, $userId);

                        $articleModele = new ArticleModele();
                        $articleModele->ajouterProduitAuPanier($userId, $idFormation, $quantiteFormation);

                        // Rediriger vers la page du panier pour voir les modifications
                        header('Location: ?action=panier');
                        exit();
                    }
                } elseif ($actionFormulaire === 'allerAccueil') {
                    // Logic to add to cart and redirect to home
                    if (isset($_POST['id_formation'], $_POST['quantite'])) {
                        if (!isset($_SESSION['user_id'])) {
                            echo "Erreur: utilisateur non connecté.";
                            return;
                        }

                        $idFormation = $_POST['id_formation'];
                        $quantiteFormation = $_POST['quantite'];
                        $userId = $_SESSION['user_id'];

                        $articleModele = new ArticleModele();
                        $articleModele->ajouterProduitAuPanier($userId, $idFormation, $quantiteFormation);

                        // Redirect to the home page
                        header('Location: index.php?action=accueil');
                        exit();
                    }
                }
            } else {
                echo "Erreur: action_formulaire non définie.";
            }
        }
    }
}