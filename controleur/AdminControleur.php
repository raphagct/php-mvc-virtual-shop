<?php

require_once 'AbstractControleur.php';
require_once 'vue/AdminVue.php';
require_once 'modele/AdminModele.php';

class AdminControleur extends AbstractControleur
{
    //Méthode abstraite affichePage apreil pour toutes les vues
    public function affichePage($vue)
    {
        $vue->affiche();
    }
    // Action d'affichage de la page admin
    public function afficherAdmin()
{
    $modele = new AdminModele();
    $references = $modele->recupererReferences();
    $fournisseurs = $modele->recupererFournisseurs();
    $gestionStock = $modele->gererStock();
    $compta = $modele->afficherCompta();
    $bilanCompta = $modele->recupererBilanCompta();

    $vue = new AdminVue();
    $vue->setFournisseur($fournisseurs);
    $vue->setReferences($references);
    $vue->setGestionStock($gestionStock);
    $vue->setCompta($compta);
    $vue->setBilanCompta($bilanCompta);
    $this->affichePage($vue);
}
    //Permet de suppr les factures des achats effectués
    public function supprimerFacture()
    {
        $modele = new AdminModele();
        if (isset($_POST['id_facturation'])) {
            $idFacturation = $_POST['id_facturation'];
            $modele->supprimerFacture($idFacturation);
            header('Location: index.php?action=admin');
            exit();
        }
    }
    
    public function ajouterProduit()
{
    // ?? est l'opérateur de fusion elle permet de définir une valeur par défaut si la variable n'est pas définie dasn ce cas là c'est soit '' (rien) ou 0
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $reference = $_POST['reference'] ?? '';
        $titre = $_POST['titre'] ?? '';
        $descriptif = $_POST['descriptif'] ?? '';
        $difficulte = $_POST['difficulte'] ?? '';
        $prixPublic = $_POST['prix_public'] ?? 0;
        $prixAchat = $_POST['prix_achat'] ?? 0;
        $imageUrl = $_POST['image_url'] ?? '';
        $quantiteStock = $_POST['quantite_stock'] ?? 0;

        $nomFournisseur = $_POST['nom_fournisseur'] ?? '';
        $contactFournisseur = $_POST['contact_fournisseur'] ?? '';
        $emailFournisseur = $_POST['email_fournisseur'] ?? '';

        if (
            !empty($reference) &&
            !empty($titre) &&
            $prixPublic > 0 &&
            $prixAchat > 0 &&
            !empty($nomFournisseur) &&
            filter_var($emailFournisseur, FILTER_VALIDATE_EMAIL)
        ) {
            $modele = new AdminModele();

            // Insérer le produit
            $modele->ajouterProduit($reference, $titre, $descriptif, $difficulte, $prixPublic, $prixAchat, $imageUrl, $quantiteStock, $nomFournisseur, $contactFournisseur, $emailFournisseur);

            //Facturation pour la formation et son prix
            $listeProduits = "$titre x $quantiteStock";

            //Creer une facture avec le nom de l'utilisateur son prénom son email et ce qu'il à acheté
            $modele->creerFacturation(
                $nomFournisseur,
                $contactFournisseur,
                $emailFournisseur,
                $listeProduits,
                -$prixAchat
            );
            // header permet de rediriger vers une autre page de manière simple cette fonction sera beaucoup utilisé
            header('Location: index.php?action=admin');
            exit();
        } else {
            echo "Erreur : Veuillez remplir tous les champs obligatoires correctement, y compris un email valide.";
        }
    }
}

public function supprimerFournisseur()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = $_POST['nom'] ?? '';

        $modele = new AdminModele();
        $modele->supprimerFournisseur($nom);

        // Redirection après la suppression
        header('Location: index.php?action=admin');
        exit();
    }
}

    public function supprimerProduit()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $reference = $_POST['reference'] ?? '';

        $modele = new AdminModele();
        $modele->supprimerProduit($reference);

        // Redirection après la suppression
        header('Location: index.php?action=admin');
        exit();
    }
}

public function mettreAjourQuantite()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $reference = $_POST['reference'] ?? '';
        $quantite = $_POST['quantite_produit'] ?? '';

        $modele = new AdminModele();
        $modele->miseAjourQuantite($reference,$quantite);

        // Redirection après la mise à jour
        header('Location: index.php?action=admin');
        exit();
    }
}
}