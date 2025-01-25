<?php
require_once './routeur/router.php';
session_start();
try {
    $routeur = new Router();
    $routeur->route();
} catch (Exception $e) {
    echo "Une erreur est survenue : " . $e->getMessage();
}