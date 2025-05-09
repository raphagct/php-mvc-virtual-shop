# PHP-MVC-Virtual-Shop

## Description

Ce projet est un site marchand développé en **PHP** (sans framework) suivant une architecture **MVC**. Il est conçu dans le cadre de me études, il consiste à vendre des formations factices en ligne et propose une gestion complète des articles, des commandes, des utilisateurs, ainsi qu'une interface d'administration.

---

## Fonctionnalités principales

### Zone publique

- **Présentation des formations** :
  - Affichage des formations disponibles avec description, prix, et image.
  - Options de filtrage et pagination pour une navigation optimisée.
- **Gestion du panier** :
  - Ajout des formations au panier.
  - Modification des quantités et suppression des articles.
- **Finalisation de la commande** :
  - Collecte des informations client (nom, prénom, email).
  - Affichage d'un accusé de réception après la commande.

### Commandes

- Enregistrement des commandes dans une table `facturation`.
- Affichage d'un accusé de réception à l'écran après validation.

### Zone d'administration

- **Gestion des tables** :
  - Administration des tables : clients, produits, fournisseurs.
  - Ajout, suppression, et recherche d'éléments dans les tables.
- **Gestion des produits** :
  - Gestion des stocks avec visibilité des produits épuisés (non commandables).
  - Alertes de seuil critique pour avertir le webmaster.
- **Comptabilité** :
  - Suivi des ventes, chiffre d'affaires, et bénéfices ou déficits.
  - Génération de rapports des ventes et achats sur une période définie.

---

## Technologies utilisées

- **Langage** : PHP (sans framework)
- **Base de données** : PhpMyAdmin(MySQL)

---

## Auteur

raphagct

---

## Installation

1. Clonez ce dépôt sur votre machine locale :
   ```bash
   git clone https://github.com/votre-utilisateur/votre-repo.git
