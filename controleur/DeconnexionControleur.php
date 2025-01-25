<?php
// DeconnexionControleur.php

class DeconnexionControleur
{
    public function deconnecter()
    {
        //Démarre, nettoie puis détruit la session
        session_start();
        session_unset();
        session_destroy();

        header('Location: ?action=connexion');
        exit();
    }
}
?>
