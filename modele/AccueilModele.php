<?php
require_once 'AbstractModele.php';

class AccueilModele extends AbstractModele
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Récupère toutes les formations.
     */
    public function recupererFormations()
    {
        // Récupère toutes les lignes de la table 'produit'
        return $this->findAll('produit');
    }

    // Méthode paginée pour récupérer toutes les formations
    public function recupererFormationsAvecPagination($limit, $offset)
    {
        $sql = "SELECT * FROM produit LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function recupererProduitStockFaible() {
        $sql = "SELECT titre, quantite_stock FROM produit WHERE quantite_stock < 5";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une formation spécifique par son ID.
     */
    public function recupererFormationParId($id)
    {
        return $this->find('produit', $id);
    }

    /**
     * Compte le nombre total de produits dans la table.
     */
    public function compterProduits()
    {
        $sql = "SELECT COUNT(*) FROM produit";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchColumn();
    }

    /**
     * Recherche des formations avec pagination.
     */
    public function rechercherFormations($terme, $limit, $offset)
    {
        $sql = "SELECT * FROM produit WHERE titre LIKE :terme OR descriptif LIKE :terme OR difficulte LIKE :terme LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':terme', '%' . $terme . '%', PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Compte le nombre total de produits correspondant à une recherche.
     */
    public function compterProduitsRecherche($terme)
    {
        $sql = "SELECT COUNT(*) FROM produit WHERE titre LIKE :terme OR descriptif LIKE :terme";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':terme', '%' . $terme . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * Tri alphabétique avec pagination.
     */
    public function recupererFormationsTrieesAlpha($limit, $offset)
    {
        $sql = "SELECT * FROM produit ORDER BY titre ASC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Tri par prix avec pagination.
     */
    public function recupererFormationsTrieesParPrix($ordre, $limit, $offset)
    {
        //tri par ordre croissant par défaut
        if ($ordre !== 'ASC' && $ordre !== 'DESC') {
            $ordre = 'ASC';
        }

        $sql = "SELECT * FROM produit ORDER BY prix_public $ordre LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Tri par difficulté avec pagination.
     */
    public function recupererFormationsTrieesParDifficulte($ordre, $limit, $offset)
    {
        if ($ordre !== 'ASC' && $ordre !== 'DESC') {
            $ordre = 'ASC';
        }
        // Tri par difficulté (Débutant, Intermédiaire, Expert)
        $sql = "SELECT * FROM produit ORDER BY FIELD(difficulte, 'Débutant', 'Intermédiaire', 'Expert') $ordre LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}