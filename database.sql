-- Création de la base de données
CREATE DATABASE IF NOT EXISTS ecommerce_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ecommerce_db;

-- Table des catégories
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Table des utilisateurs
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    adresse TEXT,
    telephone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Table des produits
CREATE TABLE produits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(200) NOT NULL,
    description TEXT,
    prix DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    image VARCHAR(255),
    categorie_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Table des commandes
CREATE TABLE commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    statut ENUM('en_attente', 'validee', 'expediee', 'livree', 'annulee') DEFAULT 'en_attente',
    adresse_livraison TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table des lignes de commande
CREATE TABLE lignes_commande (
    id INT AUTO_INCREMENT PRIMARY KEY,
    commande_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL,
    prix_unitaire DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES commandes(id) ON DELETE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES produits(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table du panier
CREATE TABLE paniers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES produits(id) ON DELETE CASCADE,
    UNIQUE KEY unique_panier (utilisateur_id, produit_id)
) ENGINE=InnoDB;

-- Insertion de données de test

-- Catégories
INSERT INTO categories (nom, description) VALUES
('Électronique', 'Appareils et gadgets électroniques'),
('Vêtements', 'Mode et accessoires'),
('Livres', 'Romans, essais et BD'),
('Maison', 'Décoration et équipement maison');

-- Utilisateur test (mot de passe: password)
INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, adresse, telephone) VALUES
('Dupont', 'Jean', 'test@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123 Rue de la Paix, Paris', '0123456789');

-- Produits
INSERT INTO produits (nom, description, prix, stock, image, categorie_id) VALUES
('Smartphone XPro', 'Téléphone dernière génération avec écran OLED', 699.99, 50, 'smartphone.jpg', 1),
('Ordinateur Portable', 'PC portable 15 pouces, 16Go RAM, SSD 512Go', 899.99, 30, 'laptop.jpg', 1),
('T-Shirt Premium', 'T-shirt en coton bio, plusieurs couleurs', 29.99, 100, 'tshirt.jpg', 2),
('Jean Slim', 'Jean confortable coupe slim', 59.99, 75, 'jean.jpg', 2),
('Le Seigneur des Anneaux', 'Trilogie complète de J.R.R. Tolkien', 45.00, 40, 'livre.jpg', 3),
('Lampe Design', 'Lampe LED design moderne', 79.99, 25, 'lampe.jpg', 4),
('Coussin Déco', 'Coussin décoratif 45x45cm', 19.99, 60, 'coussin.jpg', 4),
('Casque Audio', 'Casque sans fil avec réduction de bruit', 199.99, 45, 'casque.jpg', 1);