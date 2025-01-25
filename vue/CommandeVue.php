<?php
class CommandeVue
{
    private $titre;
    private $contenue;
    private $facture;
    private $templateChemin;

    public function __construct($titre = "Commande", $templateChemin = 'template.php')
    {
        $this->titre = $titre;
        $this->facture = null;
        $this->templateChemin = $templateChemin;
    }
    // Méthode pour définir la facture à afficher
    public function setDonnees($facture)
    {
        $this->facture = $facture;
    }
    public function display()
    {
        ob_start();
        ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/accueil.css" />
    <title><?php echo htmlspecialchars($this->titre); ?></title>
</head>
<body>
    <main>
        <h1>Merci pour votre commande !</h1>
        <hr>
        <h3>Détails de votre commande :</h3>
        <hr>
        <?php if ($this->facture): ?>
        <div style="border: 1px dashed #000; padding: 10px; margin-bottom: 10px;">
            <h3>Facture #<?php echo htmlspecialchars($this->facture['id_facturation']); ?></h3>
            <p><strong>Nom :</strong> <?php echo htmlspecialchars($this->facture['nom_acheteur']); ?></p>
            <p><strong>Prénom :</strong> <?php echo htmlspecialchars($this->facture['prenom_acheteur']); ?></p>
            <p><strong>Email :</strong> <?php echo htmlspecialchars($this->facture['email_acheteur']); ?></p>
            <p><strong>Produits :</strong> <?php echo htmlspecialchars($this->facture['liste_produits']); ?></p>
            <p><strong>Total HT :</strong> <?php echo number_format($this->facture['prix_total_ht'], 2); ?> €</p>
            <p><strong>TVA :</strong> <?php echo number_format($this->facture['tva'], 2); ?> €</p>
            <p><strong>Total TTC :</strong> <?php echo number_format($this->facture['prix_total_ttc'], 2); ?> €</p>
        </div>
        <?php else: ?>
        <p>Aucune facture disponible.</p>
        <?php endif; ?>
    </main>
</body>
</html>
<?php
        $contenue = ob_get_clean();
        include $this->templateChemin;
    }
    public function affiche()
    {
        $this->display();
    }
}
?>