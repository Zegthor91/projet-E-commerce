<?php

class ProduitController {
    
/*Liste tous les produits*/
    public function index() {
        $produitModel = new Produit();
        $categorieModel = new Categorie();
        
    /* Filtre par catégorie si spécifié*/
        if (isset($_GET['categorie']) && !empty($_GET['categorie'])) {
            $produits = $produitModel->findByCategory($_GET['categorie']);
        } else {
            $produits = $produitModel->getAllWithCategory();
        }
        
        $categories = $categorieModel->all();
        
        require_once 'views/produits/index.php';
    }
    /*Affiche le détail d'un produit*/
    public function detail()
}

?>