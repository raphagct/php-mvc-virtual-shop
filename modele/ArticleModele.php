<?php
require_once 'AbstractModele.php';

class ArticleModele extends AbstractModele
{
    public function __construct()
    {
        parent::__construct();
    }

    public function recupererFormationParId($id)
    {
        return $this->find('produit', $id);
    }

    public function ajouterProduitAuPanier($userId, $produitId, $quantite)
{
    // Vérifier si le produit est déjà dans le panier
    $sql = "SELECT quantite FROM panier WHERE id_client = :userId AND id_produit = :produitId";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':produitId', $produitId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si le produit existe et n'est pas dans le panier, mettez à jour la quantité
    if ($result) {
        $nouvelleQuantite = $result['quantite'] + $quantite;
        $sql = "UPDATE panier SET quantite = :quantite WHERE id_client = :userId AND id_produit = :produitId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':quantite', $nouvelleQuantite, PDO::PARAM_INT);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':produitId', $produitId, PDO::PARAM_INT);
        return $stmt->execute();
    } else {
        // Sinon, insérez le produit dans le panier
        $sql = "INSERT INTO panier (id_client, id_produit, quantite, date_ajout) 
                VALUES (:userId, :produitId, :quantite, NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':produitId', $produitId, PDO::PARAM_INT);
        $stmt->bindParam(':quantite', $quantite, PDO::PARAM_INT);
        return $stmt->execute();
    }
}


}