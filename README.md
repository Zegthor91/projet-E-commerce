**Structure des dossiers / fichiers**
---
```
ecommerce/
├── config/
│   └── database.php
├── models/
│   ├── Model.php
│   ├── Produit.php
│   ├── Utilisateur.php
│   ├── Panier.php
│   ├── Commande.php
│   └── Categorie.php
├── views/
│   ├── layout/
│   │   ├── header.php
│   │   └── footer.php
│   ├── home/
│   │   └── index.php
│   ├── produits/
│   │   ├── index.php
│   │   └── detail.php
│   ├── panier/
│   │   └── index.php
│   ├── auth/
│   │   ├── login.php
│   │   └── register.php
│   ├── commandes/
│   │   ├── validation.php
│   │   ├── historique.php
│   │   └── detail.php
│   └── client/
│       └── dashboard.php
├── controllers/
│   ├── HomeController.php
│   ├── ProduitController.php
│   ├── PanierController.php
│   ├── AuthController.php
│   └── CommandeController.php
├── helpers/
│   └── functions.php
├── public/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── script.js
│   └── images/
│       └── produits/
│           └── default.jpg
├── index.php
├── .htaccess
└── README.md
```