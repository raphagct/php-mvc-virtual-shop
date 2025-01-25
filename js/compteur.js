document.addEventListener('DOMContentLoaded', function () {
    const boutonsMoins = document.querySelectorAll('.qte-cpt--moins');
    const boutonsPlus = document.querySelectorAll('.qte-cpt--plus');

    boutonsMoins.forEach(bouton => {
        bouton.addEventListener('click', function () {
            const input = this.nextElementSibling; // Sélectionne l'input situé après le bouton "moins"
            if (input && input.tagName === 'INPUT') {
                let value = parseInt(input.value, 10) || 0;
                input.value = Math.max(0, value - 1); // Empêche d'aller en dessous de zéro
                synchroniserPanier(input); // Synchronise avec PanierVue
            }
        });
    });

    boutonsPlus.forEach(bouton => {
        bouton.addEventListener('click', function () {
            const input = this.previousElementSibling; // Sélectionne l'input situé avant le bouton "plus"
            if (input && input.tagName === 'INPUT') {
                let value = parseInt(input.value, 10) || 0;
                input.value = value + 1; // Augmente la valeur
                synchroniserPanier(input); // Synchronise avec PanierVue
            }
        });
    });

    // Synchronisation entre ArticleVue et PanierVue
    function synchroniserPanier(input) {
        const idArticle = input.dataset.id; // Récupère l'identifiant unique de l'article
        const nouvelleQuantite = parseInt(input.value, 10) || 0; // Quantité mise à jour

        const panierItem = document.querySelector(`.panier-item[data-id="${idArticle}"]`);
        if (panierItem) {
            const panierQuantite = panierItem.querySelector('.panier-qte'); // Élément pour afficher la quantité
            if (panierQuantite) {
                panierQuantite.textContent = nouvelleQuantite; // Met à jour l'affichage avec la bonne quantité
            }
        }
    }
});
