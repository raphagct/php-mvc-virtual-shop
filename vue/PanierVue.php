<?php
class PanierVue
{
    private $titre;
    private $contenue;
    private $templateChemin;
    private $panier;
    public function __construct($titre = "Panier", $contenue = "", $templateChemin = 'template.php')
    {
        $this->titre = $titre;
        $this->contenue = $contenue;
        $this->templateChemin = $templateChemin;
        $this->panier = []; 
    }
    private function getProduitAttribut($produit, $attribut)
    {
        return isset($produit[$attribut]) ? htmlspecialchars($produit[$attribut]) : "Attribut non disponible";
    }
    public function calculTotal()
{
    if (empty($this->panier) || !is_array($this->panier)) {
        return 0; 
    }
    $total = 0;
    foreach ($this->panier as $article) {
        $total += $article['prix_public'] * $article['quantite'];
    }
    return $total;
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
    <link rel="stylesheet" href="css/panier.css" />
    <title><?php echo $this->titre; ?></title>
</head>
<body>
    <section>
        <h1>Votre Panier</h1>
    </section>
    <section>
        <main class="produit-grid">
            <?php
                if (!empty($this->panier)) {
                    foreach ($this->panier as $produit) {
                        ?>
            <article class="produit-panier">
                <h2><?php echo $this->getProduitAttribut($produit, 'titre'); ?></h2>
                <p class="date-ajout">Date d'ajout : <?php echo date('d/m/Y', strtotime($produit['date_ajout'])); ?></p>
                <img src="<?php echo $this->getProduitAttribut($produit, 'image_url'); ?>" alt="<?php echo $this->getProduitAttribut($produit, 'titre'); ?>">
                <span class="prix">Prix :
                    <?php echo number_format($produit['prix_public'] ?? 0, 2, ',', ' ') . ' €'; ?></span>
                <div class="panier-item">Quantité : <span class="panier-qte"><?php echo $produit['quantite'] ?? 1; ?></span>
                </div>
                <a href="index.php?action=supprimerDuPanier&id=<?php echo $produit['id_produit']; ?>">Supprimer</a>
            </article>
            <?php
                    }
                } else {
                    echo "<p>Votre panier est vide.</p>";
                }
            ?>
        </main>
    </section>
    <section>
        <h2>Total des articles</h2>
        <p>Total HT : <?php echo number_format($this->calculTotal(), 2, ',', ' ') . ' €'; ?></p>
        <p>Total TTC : <?php echo number_format($this->calculTotal() * 1.2, 2, ',', ' ') . ' €'; ?></p>
        <form action="index.php?action=passerCommande" method="post">
            <button type="submit">Passer commande</button>
        </form>
    </section>
</body>
</html>
<?php
        $contenue = ob_get_clean();
        include $this->templateChemin;
    }
    public function setPanier($panier)
    {
        $this->panier = $panier;
    }
    public function affiche()
    {
        $this->display();
    }
}