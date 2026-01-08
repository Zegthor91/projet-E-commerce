<?php

class HomeController {
    
/*Affichage de la page d'accueil*/
    public function index() {
        $produitModel = new Produit();
        $categorieModel = new Categorie();
        
        $produits = $produitModel->getAllWithCategory();
        $categories = $categorieModel->getAllWithCount();
        
        require_once 'views/home/index.php';
    }
}

?>