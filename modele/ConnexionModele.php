<?php
require_once 'AbstractModele.php';

class ConnexionModele extends AbstractModele
{
    public function verifierUtilisateur($email, $mdp)
    {
        $sql = "SELECT * FROM clients WHERE email = :email AND mdp = :mdp";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':mdp', $mdp, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function verifierAdmin($mdp)
    {
        $sql = "SELECT * FROM clients WHERE email LIKE 'admin123@gmail.com' AND mdp LIKE 'admin'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':mdp', $mdp, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}