<?php
require_once 'AbstractModele.php';

class InscriptionModele extends AbstractModele
{
    public function __construct()
    {
         parent::__construct();
    }

    public function ajouterUtilisateur($nom, $prenom, $email, $mdp)
    {
        $requete = "INSERT INTO clients (id_client, nom, prenom, email, mdp) VALUES (0,:nom, :prenom, :email, :mdp)";
        $stmt = $this->pdo->prepare($requete);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':mdp', $mdp, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

}
