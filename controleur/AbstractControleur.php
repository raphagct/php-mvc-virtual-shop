<?php
abstract class AbstractControleur
{
    abstract protected function affichePage($vue);

    public function affiche($vue)
    {
        $vue->affiche();
    }
}