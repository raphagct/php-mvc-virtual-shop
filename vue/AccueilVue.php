<?php
class AccueilVue
{
    private $titre;
    private $contenue;
    private $templateChemin;
    private $donnees;
    private $pagination;
    private $alerteStock = [];

    public function __construct($titre = "Accueil", $contenue = "", $templateChemin = 'template.php')
    {
        $this->titre = $titre;
        $this->contenue = $contenue;
        $this->templateChemin = $templateChemin;
    }
    public function display()
    {
        ob_start(); //On start un observable pour recup le contenue de la page
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/accueil.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
    <title><?php echo htmlspecialchars($this->titre); ?></title>
</head>

<body>
    <?php if (isset($_SESSION['nom_utilisateur'])) { ?>
    <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['nom_utilisateur']); ?>!</p>
    <?php } ?>
    <?php if (!empty($this->alerteStock)): ?>
    <ul>
        <?php foreach ($this->alerteStock as $product): ?>
        <li>
            Attention : <strong><?= htmlspecialchars($product['titre']) ?></strong> a un stock faible :
            <?= htmlspecialchars($product['quantite_stock']) ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php else: ?>
    <p>Aucun produit avec un stock faible.</p>
    <?php endif; ?>
    <section>
        <div class="BarreRecherche">
            <form method="GET">
                <input type="text" name="recherche" placeholder="Rechercher une formation..."
                    value="<?php echo isset($_GET['recherche']) ? htmlspecialchars($_GET['recherche']) : ''; ?>">
                <button type="submit" class="btn">Rechercher</button>
            </form>
        </div>
    </section>
    <section class="Tri_Section">
        <p>
            <button class="Tri" onclick="window.location.href='?action=accueil&trier=alpha'">Trier par ordre alphabétique</button>
            <button class="Tri" onclick="window.location.href='?action=accueil&trier=prix_asc'">Trier par prix croissant</button>
            <button class="Tri" onclick="window.location.href='?action=accueil&trier=prix_desc'">Trier par prix décroissant</button>
            <button class="Tri" onclick="window.location.href='?action=accueil&trier=difficulte_asc'">Trier par difficulté croissant</button>
            <button class="Tri" onclick="window.location.href='?action=accueil&trier=difficulte_desc'">Trier par difficulté décroissant</button>
        </p>
    </section>
    <!-- Section presentation des formations -->
    <section>
        <main class="produit-grid">
            <?php
                    // Vérifiez si les données sont disponibles
                    if ($this->donnees) {
                        // Affichez chaque produit
                        foreach ($this->donnees as $produit) {
                    ?>
            <article class="produit">
                <img src="<?php echo htmlspecialchars($produit['image_url']); ?>" alt="<?php echo htmlspecialchars($produit['titre']); ?>">
                <h2><?php echo htmlspecialchars($produit['titre']); ?></h2>
                <p><?php echo htmlspecialchars($produit['difficulte']); ?></p>
                <span class="prix"><?php echo number_format($produit['prix_public'], 2, ',', ' ') . ' €'; ?></span>
                <p><button class="btn" onclick="window.location.href='?action=article&id=<?php echo htmlspecialchars($produit['id_produit']); ?>'">Acheter la formation </button></p>
            </article>
            <?php }
                    } else {
                        echo "<p>Aucun produit disponible.</p>";
                    }
                    ?>
    </section>
    <!-- Pagination fixée et centrée -->
    <section class="pagination-conteneur">
        <?php if ($this->pagination['hasPreviousPage']) { ?>
        <button class="pagination-btn page-prev" onclick="window.location.href='?page=<?php echo max(1, $this->pagination['currentPage'] - 1); ?>&recherche=<?php echo isset($_GET['recherche']) ? htmlspecialchars($_GET['recherche']) : ''; ?>&trier=<?php echo isset($_GET['trier']) ? htmlspecialchars($_GET['trier']) : ''; ?>'">Page précédente,</button>
        <?php } ?>
        <?php if ($this->pagination['hasNextPage']) { ?>
        <button class="pagination-btn page-next" onclick="window.location.href='?page=<?php echo min($this->pagination['totalPages'], $this->pagination['currentPage'] + 1); ?>&recherche=<?php echo isset($_GET['recherche']) ? htmlspecialchars($_GET['recherche']) : ''; ?>&trier=<?php echo isset($_GET['trier']) ? htmlspecialchars($_GET['trier']) : ''; ?>'">Page suivante</button>
        <?php } ?>
    </section>
    <hr>
    <!-- Section "Qui sommes-nous ?" -->
    <section class="qui-sommes-nous">
        <h2>Qui sommes-nous ?</h2>
        <p>
            Nous sommes deux étudiants passionnés par l'informatique.
            Avec ce site, notre objectif est de rendre les connaissances accessibles à tous, avec des formations
            adaptées à divers besoins. Grâce à nos recherches et partenaires, nous proposons des contenus pédagogiques
            de haute qualité pour vous aider à réussir dans vos objectifs professionels !
        </p>
        <p>
            Nous croyons fermement que l'apprentissage est la clé pour ouvrir des portes et offrir des opportunités
            dans le monde du travail. Explorez notre site pour découvrir nos formations et commencer votre apprentissage
            dès aujourd'hui !
        </p>
    </section>
    </main>
</body>
</html>
<?php
        $contenue = ob_get_clean(); //On recup le contenue de la page
        include $this->templateChemin; //On ajoute le header,la navbar et le footer
        }
    public function setDonnees($donnees)
    {
        $this->donnees = $donnees;
    }
    public function setPagination($currentPage, $totalPages, $hasPreviousPage, $hasNextPage)
    {
        $this->pagination = [
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'hasPreviousPage' => $hasPreviousPage,
            'hasNextPage' => $hasNextPage,
        ];
    }
    public function setAlerteStock(array $alerteStock)
    {
        $this->alerteStock = $alerteStock;
    }
    public function affiche()
    {
        $this->display();
    }
}
?>