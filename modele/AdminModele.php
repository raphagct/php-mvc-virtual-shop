<?php
require_once 'AbstractModele.php';

class AdminModele extends AbstractModele
{
    // Méthode pour ajouter un produit dans la table
    public function ajouterProduit($reference, $titre, $descriptif, $difficulte, $prixPublic, $prixAchat, $imageUrl, $quantiteStock, $nomFournisseur, $contactFournisseur, $emailFournisseur)
    {
        // Insertion des données dans la table 'produit'
        $sqlProduit = "INSERT INTO produit (reference, titre, descriptif, difficulte, prix_public, prix_achat, image_url, quantite_stock)
                       VALUES (:reference, :titre, :descriptif, :difficulte, :prixPublic, :prixAchat, :imageUrl, :quantiteStock)";
        $stmtProduit = $this->pdo->prepare($sqlProduit);
        $stmtProduit->bindParam(':reference', $reference);
        $stmtProduit->bindParam(':titre', $titre);
        $stmtProduit->bindParam(':descriptif', $descriptif);
        $stmtProduit->bindParam(':difficulte', $difficulte);
        $stmtProduit->bindParam(':prixPublic', $prixPublic);
        $stmtProduit->bindParam(':prixAchat', $prixAchat);
        $stmtProduit->bindParam(':imageUrl', $imageUrl);
        $stmtProduit->bindParam(':quantiteStock', $quantiteStock, PDO::PARAM_INT);
        $stmtProduit->execute();
    
        // Insertion des données dans la table 'fournisseurs'
        $sqlFournisseur = "INSERT INTO fournisseurs (nom, contact, email)
                           VALUES (:nomFournisseur, :contactFournisseur, :emailFournisseur)";
        $stmtFournisseur = $this->pdo->prepare($sqlFournisseur);
        $stmtFournisseur->bindParam(':nomFournisseur', $nomFournisseur);
        $stmtFournisseur->bindParam(':contactFournisseur', $contactFournisseur);
        $stmtFournisseur->bindParam(':emailFournisseur', $emailFournisseur);
        $stmtFournisseur->execute();
    }

    //Méthode créer une facture
    public function creerFacturation($nomAcheteur, $prenomAcheteur, $emailAcheteur, $listeProduits, $prixAchat)
    {
        $sql = "INSERT INTO facturation 
                (date_creation, nom_acheteur, prenom_acheteur, email_acheteur, liste_produits, prix_total_ht, prix_total_ttc, tva) 
                VALUES (NOW(), :nomAcheteur, :prenomAcheteur, :emailAcheteur, :listeProduits, :prixAchat, :prixAchatTTC, :tva)";

        // Calcul du prix TTC avec TVA par défaut de 20%
        $stmt = $this->pdo->prepare($sql);
        $prixAchatTTC = $prixAchat * 1.20;
        $tva = 20.00;
        $stmt->bindParam(':nomAcheteur', $nomAcheteur);
        $stmt->bindParam(':prenomAcheteur', $prenomAcheteur);
        $stmt->bindParam(':emailAcheteur', $emailAcheteur);
        $stmt->bindParam(':listeProduits', $listeProduits);
        $stmt->bindParam(':prixAchat', $prixAchat);
        $stmt->bindParam(':prixAchatTTC', $prixAchatTTC);
        $stmt->bindParam(':tva', $tva);
        $stmt->execute();
    }

    public function supprimerFacture($idFacturation)
    {
        $sql = "DELETE FROM facturation WHERE id_facturation = :id_facturation";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_facturation', $idFacturation, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Méthode pour supprimer un produit en fonction de sa référence
    public function supprimerProduit($reference)
    {
       $sqlPanier = "DELETE FROM panier WHERE id_produit IN (SELECT id_produit FROM produit WHERE reference = :reference)";
       $stmtPanier = $this->pdo->prepare($sqlPanier);
       $stmtPanier->bindParam(':reference', $reference);
       $stmtPanier->execute();

       // Supprimer le produit de la table produit
       $sql = "DELETE FROM produit WHERE reference = :reference";
       $stmt = $this->pdo->prepare($sql);
       $stmt->bindParam(':reference', $reference);
       $stmt->execute();
    }

    public function supprimerFournisseur($nom)
    {
        $sql = "DELETE FROM fournisseurs WHERE nom = :nom";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->execute();
    }

    public function miseAjourQuantite($reference,$quantite)
    {
        $sql = "UPDATE produit SET quantite_stock = :quantite WHERE reference = :reference";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':reference', $reference);
        $stmt->bindParam(':quantite', $quantite);
        $stmt->execute();
    }

    public function recupererFournisseurs()
    {
        $sql = "SELECT nom FROM fournisseurs ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function recupererReferences()
    {
        $sql = "SELECT reference FROM produit ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function gererStock(){
        $sql = "SELECT id_produit, titre , quantite_stock FROM produit ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function afficherCompta(){
        // Requête SQL pour récupérer les données triées par date_creation de manière décroissante
        $sql = "SELECT id_facturation,nom_acheteur, date_creation,liste_produits, prix_total_ht FROM facturation ORDER BY date_creation DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function recupererBilanCompta() {
        // Requête SQL pour calculer la somme de tous les prix_total_ht
        $sql = "SELECT SUM(prix_total_ht) AS total_bilan FROM facturation";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}