<?php

abstract class AbstractModele
{
    protected $pdo;
    // Constructeur pour récupérer la connexion PDO
    public function __construct()
    {
        require_once 'config/pdo.php';
        $this->pdo = $pdo;
    }

    // Méthode pour récupérer un enregistrement par ID
    public function find($table, $id)
    {
        $sql = "SELECT * FROM $table WHERE id_produit = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Méthode  pour récupérer toutes les données d'une table
    public function findAll($table)
    {
        $sql = "SELECT * FROM $table";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
}