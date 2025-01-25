<?php
class AdminVue
{
    private $titre;
    private $contenue;
    private $templateChemin;
    private $bilanCompta;
    private $references = [];
    private $GestionStock = [];
    private $compta = [];
    private $fournisseurs = [];

    public function __construct($titre = "Admin", $contenue = "", $templateChemin = 'template.php')
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
    <link rel="stylesheet" href="css/admin.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
    <title><?php echo htmlspecialchars($this->titre); ?></title>
</head>

<body>
    <main>
        <section>
            <!-- Formulaire pour ajouter un produit -->
            <form method="post" action="index.php?action=ajouterProduit">
                <h2>Ajouter un Produit</h2>
                <label for="reference">Référence :</label>
                <input type="text" name="reference" id="reference" placeholder="Ex : formation_nom" required><br>

                <label for="titre">Titre :</label>
                <input type="text" name="titre" id="titre" placeholder="Ex : Formation Nom" required><br>

                <label for="descriptif">Descriptif :</label>
                <textarea name="descriptif" id="descriptif"
                    placeholder="Ex : Cette formation vous permet..."></textarea><br>

                <label for="difficulte">Difficulté :</label>
                <input type="text" name="difficulte" id="difficulte" placeholder="Ex : Expert"><br>

                <label for="prix_public">Prix Public :</label>
                <input type="number" step="0.01" name="prix_public" id="prix_public" placeholder="Ex : 49.99"
                    required><br>

                <label for="prix_achat">Prix Achat :</label>
                <input type="number" step="0.01" name="prix_achat" id="prix_achat" placeholder="Ex : 5.99" required><br>
                <h5>Note d'utilisation : ajouter une image dans le dossier assets au préalable</h5>
                <label for="image_url">Image URL :</label>
                <input type="text" name="image_url" id="image_url" placeholder="Ex : assets/image.png"><br>

                <label for="quantite_stock">Quantité en Stock :</label>
                <input type="number" name="quantite_stock" id="quantite_stock" value="0" placeholder="Ex : 100"><br>

                <!-- Champs liés à la table fournisseurs -->
                <h3>Informations sur le fournisseur</h3>
                <label for="nom_fournisseur">Nom du Fournisseur :</label>
                <input type="text" name="nom_fournisseur" id="nom_fournisseur" placeholder="Ex : Open Classroom"
                    required><br>

                <label for="contact_fournisseur">Contact :</label>
                <input type="text" name="contact_fournisseur" id="contact_fournisseur"
                    placeholder="Ex : 06 12 34 56 78"><br>

                <label for="email_fournisseur">Email :</label>
                <input type="email" name="email_fournisseur" id="email_fournisseur"
                    placeholder="Ex : fournisseur@gmail.com"><br>

                <button type="submit" class="bouton-ajout" >Ajouter le Produit</button>
            </form>
        </section>
        <hr>
        <section>
            <!-- Formulaire pour set une quantite -->
            <form method="post" action="index.php?action=setQuantiteProduit">
                <h2>Mettre à jour la quantité d'un produit</h2>
                <label for="reference_supp">Quantité :</label>
                <select name="reference" id="reference_supp">
                    <?php
                            foreach ($this->references as $reference) {
                                echo '<option value="' . htmlspecialchars($reference['reference']) . '">' . htmlspecialchars($reference['reference']) . '</option>';
                            }
                            ?>
                </select><br>
                <input type="number" name="quantite_produit" id="quantite_produit"
                    placeholder="Ex : 20">
                <button type="submit" class="bouton-A-Jour" >Mettre à jour la quantité</button>
            </form>

        </section>
        <hr>
        <section>
            <!-- Formulaire pour supprimer un produit -->
            <form method="post" action="index.php?action=supprimerProduit">
                <h2>Supprimer un Produit</h2>
                <label for="reference_supp">Référence :</label>
                <select name="reference" id="reference_supp">
                    <?php
                            foreach ($this->references as $reference) {
                                echo '<option value="' . htmlspecialchars($reference['reference']) . '">' . htmlspecialchars($reference['reference']) . '</option>';
                            }
                            ?>
                </select><br>
                <button type="submit" class="bouton-supprimer">Supprimer le Produit</button>
            </form>

        </section>
        <hr>
        <section>
            <!-- Formulaire pour supprimer un fournisseur -->
            <form method="post" action="index.php?action=supprimerFournisseur">
                <h2>Supprimer un Fournisseur</h2>
                <label for="fournisseur_supp">Fournisseur :</label>
                <select name="nom" id="fournisseur_supp">
                    <?php
                            foreach ($this->fournisseurs as $fournisseur) {
                                echo '<option value="' . htmlspecialchars($fournisseur['nom']) . '">' . htmlspecialchars($fournisseur['nom']) . '</option>';
                            }
                            ?>
                </select><br>

                <button type="submit" class="bouton-supprimer"> Supprimer le fournisseur</button>
            </form>
        </section>
        <hr>
        <!-- Tableau de gestion des stocks -->
        <section>
            <h2>Gestion des Stocks</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Produit</th>
                        <th>Titre</th>
                        <th>Quantité en Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->GestionStock as $produit): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($produit['id_produit']); ?></td>
                        <td><?php echo htmlspecialchars($produit['titre']); ?></td>
                        <td><?php echo htmlspecialchars($produit['quantite_stock']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <hr>
        <!-- Tableau de comptabilité -->
        <section>
            <h2>Comptabilité</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Facturation</th>
                        <th>Nom Acheteur/Fournisseur</th>
                        <th>Date </th>
                        <th>Formation(s) vendue/achetée(s) </th>
                        <th>Prix Total HT</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->compta as $facture): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($facture['id_facturation']); ?></td>
                        <td><?php echo htmlspecialchars($facture['nom_acheteur']); ?></td>
                        <td><?php echo htmlspecialchars($facture['date_creation']); ?></td>
                        <td><?php echo htmlspecialchars($facture['liste_produits']); ?></td>
                        <td class="<?php echo $facture['prix_total_ht'] < 0 ? 'prix-négatif' : 'prix-positif'; ?>">
                            <?php echo htmlspecialchars($facture['prix_total_ht']); ?>
                        </td>
                        <td>
                            <form method="post" action="index.php?action=supprimerFacture">
                                <input type="hidden" name="id_facturation"
                                    value="<?php echo htmlspecialchars($facture['id_facturation']); ?>">
                                <button type="submit"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette facturation ?');">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Affichage du bilan -->
            <div class="bilan-compta">
                <h3>Bilan : </h3>
                <p>Total des prix HT :
                    <?php echo number_format($this->bilanCompta['total_bilan'], 2, ',', ' ') . ' €'; ?></p>
            </div>
        </section>

        <hr>

    </main>
</body>

</html>
<?php
        $contenue = ob_get_clean(); //On recup le contenue de la page
        include $this->templateChemin; //On ajoute le header,la navbar et le footer
    }

    public function setReferences(array $references)
    {
        $this->references = $references;
    }

    public function setFournisseur(array $fournisseurs)
    {
        $this->fournisseurs = $fournisseurs;
    }

    public function setCompta(array $compta)
    {
        $this->compta = $compta;
    }

    public function setBilanCompta($bilanCompta)
{
    $this->bilanCompta = $bilanCompta;
}
    public function setGestionStock(array $GestionStock)
    {
        $this->GestionStock = $GestionStock;
    }
    // Nouvelle méthode 'affiche' ajoutée ici
    public function affiche()
    {
        $this->display();
    }
}