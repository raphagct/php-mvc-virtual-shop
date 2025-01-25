<?php

$host = 'linserv-info-01';
$dbname = 'fv306702_magasin_virtuel';
$username = 'fv306702';
$password = 'fv306702';

//Requete sql pour accéder avec les privilèges
//GRANT ALL PRIVILEGES ON fv306702_magasin_virtuel.* TO 'fv306702'@'localhost' IDENTIFIED BY 'fv306702';
//FLUSH PRIVILEGES;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

?>