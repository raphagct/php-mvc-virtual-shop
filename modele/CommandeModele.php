<?php
require_once 'AbstractModele.php';

class CommandeModele extends AbstractModele
{
    public function __construct()
    {
        parent::__construct(); // Récupère la connexion à la base de données via la classe parente
    }


    public function afficherFacturation()
    {
        // Récupère l'enregistrement avec l'id_facturation le plus élevé
        $sql = "SELECT * FROM facturation ORDER BY id_facturation DESC LIMIT 1"; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        // Retourne l'enregistrement avec l'id_formation le plus élevé
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function supprPanier($userId)
    {
    // Préparation de la requête SQL pour supprimer les lignes du panier où l'id_client correspond à userId
    $sql = "DELETE FROM panier WHERE id_client = :userId";
    
    // Préparation de la requête avec la connexion PDO
    $stmt = $this->pdo->prepare($sql);
    
    // Lier le paramètre :userId à la valeur de $userId, en tant qu'entier
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    
    // Exécuter la requête et retourner le résultat (true si réussite, false sinon)
    return $stmt->execute();
    }


    public function creerFacturation($idClient, $tauxTva = 20.00)
    {
    try {
        // Récupérer les informations du client
        $sqlClient = "SELECT nom, prenom, email FROM clients WHERE id_client = :idClient";
        $stmtClient = $this->pdo->prepare($sqlClient);
        $stmtClient->bindParam(':idClient', $idClient, PDO::PARAM_INT);
        $stmtClient->execute();
        $client = $stmtClient->fetch(PDO::FETCH_ASSOC);

        if (!$client) {
            throw new Exception("Client introuvable");
        }

        // Récupérer les produits du panier pour ce client
        $sqlPanier = "
            SELECT p.id_produit, p.quantite_stock, p.reference, p.prix_public, pa.quantite
FROM panier pa
INNER JOIN produit p ON pa.id_produit = p.id_produit
WHERE pa.id_client = :idClient

        ";
        $stmtPanier = $this->pdo->prepare($sqlPanier);
        $stmtPanier->bindParam(':idClient', $idClient, PDO::PARAM_INT);
        $stmtPanier->execute();
        $produits = $stmtPanier->fetchAll(PDO::FETCH_ASSOC);

        if (empty($produits)) {
            throw new Exception("Panier vide pour ce client");
        }

        // Calculer le total HT et TTC
        $prixTotalHT = 0;
        $listeProduits = [];

        foreach ($produits as $produit) {
            $sousTotal = $produit['prix_public'] * $produit['quantite'];
            $prixTotalHT += $sousTotal;
            $listeProduits[] = sprintf(
                "%s (%d x %.2f)",
                $produit['reference'],
                $produit['quantite'],
                $produit['prix_public']
            );
        }

        $tva = ($prixTotalHT * $tauxTva) / 100;
        $prixTotalTTC = $prixTotalHT + $tva;

        // Convertir la liste des produits en texte
        $listeProduitsTexte = implode(", ", $listeProduits);

        // Insérer une nouvelle entrée dans la table facturation
        $sqlFacturation = "
            INSERT INTO facturation (
                nom_acheteur, prenom_acheteur, email_acheteur, liste_produits, prix_total_ht, prix_total_ttc, tva
            ) VALUES (
                :nom, :prenom, :email, :listeProduits, :prixTotalHT, :prixTotalTTC, :tva
            )
        ";
        $stmtFacturation = $this->pdo->prepare($sqlFacturation);

        $stmtFacturation->bindParam(':nom', $client['nom'], PDO::PARAM_STR);
        $stmtFacturation->bindParam(':prenom', $client['prenom'], PDO::PARAM_STR);
        $stmtFacturation->bindParam(':email', $client['email'], PDO::PARAM_STR);
        $stmtFacturation->bindParam(':listeProduits', $listeProduitsTexte, PDO::PARAM_STR);
        $stmtFacturation->bindParam(':prixTotalHT', $prixTotalHT, PDO::PARAM_STR);
        $stmtFacturation->bindParam(':prixTotalTTC', $prixTotalTTC, PDO::PARAM_STR);
        $stmtFacturation->bindParam(':tva', $tva, PDO::PARAM_STR);

        foreach ($produits as $produit) {
            if ($produit['quantite'] > $produit['quantite_stock']) {
                throw new Exception("Stock insuffisant pour le produit ID: " . $produit['id_produit']);
            }
            $sqlUpdateStock = "
        UPDATE produit 
        SET quantite_stock = quantite_stock - :quantite
        WHERE id_produit = :idProduit
    ";
            $stmtUpdateStock = $this->pdo->prepare($sqlUpdateStock);
            $stmtUpdateStock->bindParam(':quantite', $produit['quantite'], PDO::PARAM_INT);
            $stmtUpdateStock->bindParam(':idProduit', $produit['id_produit'], PDO::PARAM_INT);
            if (!$stmtUpdateStock->execute()) {
                $errorInfo = $stmtUpdateStock->errorInfo();
                throw new Exception("Erreur lors de la mise à jour du stock pour le produit ID: " . $produit['id_produit'] . ". Erreur SQL: " . implode(' - ', $errorInfo));
            }
        }


        // Exécuter la requête
        if ($stmtFacturation->execute()) {
            return [
                'succes' => true,
                'message' => "Facturation créée avec succès."
            ];
        } else {
            throw new Exception("Erreur lors de la création de la facturation");
        }
    } catch (Exception $e) {
        return [
            'succes' => false,
            'message' => $e->getMessage()
        ];
    }
}
}
?>