<?php
class ArticleVue
{
    private $titre;
    private $contenue;
    private $templateChemin;
    private $donnees;

    public function __construct($titre = "Article", $contenue = "", $templateChemin = 'template.php')
    {
        $this->titre = $titre;
        $this->contenue = $contenue;
        $this->templateChemin = $templateChemin;
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
    <link rel="stylesheet" href="css/article.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
    <title><?php echo htmlspecialchars($this->titre); ?></title>
</head>

<body>
    <main>
        <article class="article-container">
            <div class="image-conteneur">
                <img src="<?php echo htmlspecialchars($this->donnees['image_url']); ?>"
                    alt="Image de <?php echo htmlspecialchars($this->donnees['titre']); ?>" class="produit-image">
            </div>

            <div class="produit-details">
                <h2><?php echo htmlspecialchars($this->donnees['titre']); ?></h2>
                <span
                    class="prix"><?php echo number_format($this->donnees['prix_public'], 2, ',', ' ') . ' €'; ?></span>
                <p class="descriptif"><?php echo htmlspecialchars($this->donnees['descriptif']); ?></p>
                <!-- Formulaire d'ajout au panier -->
                <form method="POST" action="?action=ajouterProduitPanier">
                    <input type="hidden" name="id_formation" value="<?php echo htmlspecialchars($this->donnees['id_produit']); ?>">
                    <input type="hidden" name="nom_formation" value="<?php echo htmlspecialchars($this->donnees['titre']); ?>">
                    <input type="hidden" name="prix_formation" value="<?php echo htmlspecialchars($this->donnees['prix_public']); ?>">
                    <input type="hidden" name="image_formation" value="<?php echo htmlspecialchars($this->donnees['image_url']); ?>">
                    <input type="hidden" id="quantite-formulaire" name="quantite" value="1">
                    <input type="hidden" id="action-formulaire" name="action_formulaire" value="ajouterPanier">
                    <div class="article" data-id="article1" data-stock="<?php echo $this->donnees['quantite_stock']; ?>">
                        <label for="quantite" class="quantite-label">Quantité :</label>
                        <button type="button" class="qte-cpt--moins">-</button>
                        <input type="number" id="quantite-visible" value="1" min="1" max="<?php echo $this->donnees['quantite_stock']; ?>">
                        <button type="button" class="qte-cpt--plus">+</button>
                    </div>
                    <div class="button-conteneur">
                        <button type="submit" class="btn acheter-Accueil" onclick="document.querySelector('#action-formulaire').value='allerAccueil';">Ajouter au panier et continuer le shopping</button>
                        <button type="submit" class="btn acheter-btn" onclick="document.querySelector('#action-formulaire').value='ajouterPanier';">Ajouter au Panier et aller au panier</button>
                    </div>
                </form>


                <script>
                // Gestion des boutons + et -
                document.addEventListener('DOMContentLoaded', () => {
                    const btnMoins = document.querySelector('.qte-cpt--moins');
                    const btnPlus = document.querySelector('.qte-cpt--plus');
                    const inputQuantiteVisible = document.getElementById('quantite-visible');
                    const inputQuantiteFormulaire = document.getElementById('quantite-formulaire');
                    const article = document.querySelector('.article');
                    const stockMax = parseInt(article.getAttribute('data-stock'), 10);

                    // Diminuer la quantité
                    btnMoins.addEventListener('click', () => {
                        let quantite = parseInt(inputQuantiteVisible.value, 10) || 1;
                        if (quantite > 1) {
                            inputQuantiteVisible.value = --quantite;
                            inputQuantiteFormulaire.value = quantite;
                        }
                    });

                    // Augmenter la quantité
                    btnPlus.addEventListener('click', () => {
                        let quantite = parseInt(inputQuantiteVisible.value, 10) || 1;
                        if (quantite < stockMax) { // Ne pas dépasser la quantité en stock
                            inputQuantiteVisible.value = ++quantite;
                            inputQuantiteFormulaire.value = quantite;
                        }
                    });

                    // Synchroniser la quantité visible avec le champ caché
                    inputQuantiteVisible.addEventListener('input', () => {
                        let quantite = parseInt(inputQuantiteVisible.value, 10) || 1;
                        if (quantite < 1) quantite = 1; // Empêche une quantité négative
                        if (quantite > stockMax) quantite =
                        stockMax; // Limite la quantité au stock disponible
                        inputQuantiteVisible.value = quantite;
                        inputQuantiteFormulaire.value = quantite;
                    });
                });
                </script>

            </div>
        </article>

    </main>
</body>

</html>
<?php
        $contenue = ob_get_clean(); // On récupère le contenu de la page
        include $this->templateChemin; // On ajoute le template (header, navbar, footer)
    }

    public function setDonnees($donnees)
    {
        $this->donnees = $donnees;
    }

    public function affiche()
    {
        $this->display();
    }
}
?>