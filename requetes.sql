CREATE DATABASE gr304732_magasin_virtuel;
USE gr304732_magasin_virtuel;

CREATE TABLE clients (
    id_client INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL
);

CREATE TABLE fournisseurs (
    id_fournisseur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    contact VARCHAR(255),
    email VARCHAR(255) UNIQUE
);

CREATE TABLE produit (
    id_produit INT AUTO_INCREMENT PRIMARY KEY,
    reference VARCHAR(100) UNIQUE NOT NULL,
    titre VARCHAR(255) NOT NULL,
    descriptif TEXT,
    difficulte VARCHAR(50),   
    prix_public DECIMAL(10, 2) NOT NULL,
    prix_achat DECIMAL(10, 2) NOT NULL,
    image_url VARCHAR(255),
    quantite_stock INT DEFAULT 0
);

CREATE TABLE facturation (
    id_facturation INT AUTO_INCREMENT PRIMARY KEY,          
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,      
    nom_acheteur VARCHAR(255) NOT NULL,                     
    prenom_acheteur VARCHAR(255) NOT NULL, 
    reference VARCHAR(255) NOT NULL,                    
    email_acheteur VARCHAR(255) NOT NULL,                   
    liste_produits TEXT NOT NULL,                           
    prix_total_ht DECIMAL(10, 2) NOT NULL,                  
    prix_total_ttc DECIMAL(10, 2) NOT NULL,                     
    tva DECIMAL(5, 2) NOT NULL DEFAULT 20.00    

);


CREATE TABLE gestion_stock (
    id_stock INT AUTO_INCREMENT PRIMARY KEY,
    id_produit INT NOT NULL,
    seuil_critique INT DEFAULT 10,
    date_alerte DATETIME,
    FOREIGN KEY (id_produit) REFERENCES produit(id_produit)
);

INSERT INTO produit (reference, titre, descriptif, difficulte, prix_public, prix_achat, image_url, quantite_stock) VALUES 
    ('formation_py_deb', 'Formations Python Débutant', 'Cette formation vous permettra de découvrir les bases de Python,
     de comprendre comment écrire des programmes simples et d\'appliquer vos connaissances à des projets concrets.
      Vous apprendrez à travailler avec des variables, des boucles, des conditions, des fonctions,et bien plus encore.',
     'Débutant',59.99 , 4.99, 'assets/python.png', 20);

INSERT INTO produit (reference, titre, descriptif, difficulte, prix_public, prix_achat, image_url, quantite_stock) VALUES 
    ('formation_crypto', 'Formations Cryptomonnaies', "Cette formation permet d'acquérir les fondamentaux des cryptomonnaies,
    la technologie de la blockchain, ainsi que les stratégies pour investir et sécuriser vos actifs numériques.",
    'Intermédiaire',89.99 , 9.99, 'assets/crypto.png', 20),
     ('formation_immo', 'Formation Investissement Immobilier', "Cette formation permet d'acquérir les principes fondamentaux de l'investissement immobilier,
    de maîtriser les différentes stratégies, et de connaître les outils pour réussir vos investissements.",
    'Intermédiaire',199.99 , 1.99, 'assets/immo.png', 20),
     ('formation_excel_expert', 'Formations Excel Expert', "Cette formation permet de maîtrisé les fonctionnalités avancées d'Excel pour optimiser vos analyses,
    automatiser vos tâches et créer des rapports de haute qualité.",
    'Expert',49.99 , 0.99, 'assets/excel.png', 20),
     ('formation_dropshipp', 'Formation Dropshipping', "Cette formation vous guidera à travers chaque étape de la création d'une boutique en ligne performante,
    de la sélection des produits à la gestion des fournisseurs, en passant par les stratégies de marketing et de vente.",
    'Intermédiaire',59.99 , 89.99, 'assets/dropshipping.png', 20),
     ('formation_front', 'Formation Front-end', "Cette formation vous fournira les compétences nécessaires pour créer des sites web modernes,
     responsives et performants. Vous apprendrez à maîtriser les langages fondamentaux du web (HTML, CSS, JavaScript),
    ainsi que les frameworks et outils utilisés par les professionnels pour créer des expériences utilisateur de qualité.",
    'Débutant',29.99 , 1.99, 'assets/front.png', 20),
    ('formation_fback', 'Formation Back-end', "Cette formation vous fournira toutes les compétences nécessaires pour développer des applications web robustes et évolutives.
    Vous apprendrez à utiliser les langages de programmation Back-End les plus populaires comme PHP et Node.js, ainsi qu'à gérer des bases de données avec MySQL
    et MongoDB.",
    'Expert',99.99 , 11.99, 'assets/back.png', 20);

INSERT INTO produit (reference, titre, descriptif, difficulte, prix_public, prix_achat, image_url, quantite_stock) VALUES 
    ('formation_agile', 'Formations Agile', "Cette formation vous permet de comprendre et d'appliquer les principes et les pratiques Agile dans vos projets,
    pour maximiser la collaboration et la flexibilité.",
    'Intermédiaire',39.99 , 2.99, 'assets/agile.png', 20);

INSERT INTO produit (reference, titre, descriptif, difficulte, prix_public, prix_achat, image_url, quantite_stock) VALUES 
    ('formation_java_debutant', 'Formation Java Débutant', "Cette formation est idéale pour les débutants en programmation. Vous apprendrez les bases du langage Java, ses concepts fondamentaux et comment développer des applications simples.",
    'Débutant',39.99 , 5.99, 'assets/java.png', 20),
    
    ('formation_git', 'Formation Git', "Cette formation vous initiera à Git, l'outil de gestion de versions le plus utilisé en développement. Vous apprendrez à gérer les versions de vos projets et à collaborer efficacement avec des équipes de développeurs.",
    'Débutant',29.99 , 3.99, 'assets/git.png', 20),
    
    ('formation_js_debutant', 'Formation JavaScript Débutant', "Cette formation est conçue pour les débutants souhaitant apprendre JavaScript. Vous découvrirez comment utiliser ce langage pour ajouter des fonctionnalités interactives et dynamiques à vos sites web.",
    'Débutant',34.99 , 4.99, 'assets/js.png', 20),
    
    ('formation_bdd_sql', 'Formation Base de données et SQL', "Cette formation vous enseignera les bases des bases de données relationnelles et comment interroger ces dernières à l'aide du langage SQL pour manipuler et analyser les données efficacement.",
    'Intermédiaire',49.99 , 7.99, 'assets/sql.png', 20),
    
    ('formation_community_manager', 'Formation Community Manager', "Apprenez à gérer et développer une communauté en ligne. Cette formation couvre la création de contenu, la gestion des réseaux sociaux, et la stratégie de communication numérique.",
    'Intermédiaire',59.99 , 9.99, 'assets/community_manager.png', 20),
    
    ('formation_ai', 'Formation Intelligence Artificielle', "Cette formation vous initie aux bases de l'IA et aux techniques courantes telles que l'apprentissage supervisé, les réseaux neuronaux et le traitement du langage naturel.",
    'Expert',99.99 , 19.99, 'assets/ia.png', 20),
    
    ('formation_entreprenariat', 'Formation Entreprenariat', "Cette formation vous guidera dans la création de votre propre entreprise. Vous apprendrez les clés du succès entrepreneurial, de la conception de l'idée à la gestion d'entreprise.",
    'Intermédiaire',79.99 , 11.99, 'assets/entrepreneur.png', 20),
    
    ('formation_qualite_dev', 'Formation Qualité de Développement', "Cette formation vous fournira les meilleures pratiques pour garantir la qualité dans vos projets de développement logiciel, y compris la gestion des tests, les revues de code et les méthodes d'amélioration continue.",
    'Intermédiaire',69.99 , 12.99, 'assets/qualite_dev.png', 20);

ALTER TABLE clients
ADD COLUMN mdp VARCHAR(255) NOT NULL;