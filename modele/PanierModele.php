<?php

require_once 'AbstractModele.php';

class PanierModele extends AbstractModele
{
    // Insère une facturation dans la base de données
    public function insererFacturation($nom, $prenom, $email, $listeProduits, $prixTotalHT, $prixTotalTTC, $tva)
    {
        $sql = "INSERT INTO facturation (nom_acheteur, prenom_acheteur, email_acheteur, liste_produits, prix_total_ht, prix_total_ttc, tva) 
                VALUES (:nom, :prenom, :email, :listeProduits, :prixTotalHT, :prixTotalTTC, :tva)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':listeProduits', $listeProduits);
        $stmt->bindParam(':prixTotalHT', $prixTotalHT);
        $stmt->bindParam(':prixTotalTTC', $prixTotalTTC);
        $stmt->bindParam(':tva', $tva);
        return $stmt->execute();
    }

    public function getPanierParUtilisateur($userId)
    {
        $sql = "SELECT p.titre, p.prix_public, c.quantite, c.date_ajout , p.image_url, c.id_produit
                FROM panier c 
                JOIN produit p ON c.id_produit = p.id_produit
                WHERE c.id_client = :userId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function supprimerProduitDuPanier($userId, $produitId)
{
    // Supprimer l'article du panier en fonction de l'ID du produit et de l'ID utilisateur (comparaison)
    $sql = "DELETE FROM panier WHERE id_client = :userId AND id_produit = :produitId";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':produitId', $produitId, PDO::PARAM_INT);
    return $stmt->execute();
}

    
}