<?php

class ProduitController
{
    public function index()
    {
        $produitModel = new Produit();
        $categorieModel = new Categorie();

    /* Filtre en chaque catégorie si c'est spécifié */
        if (isset($_GET['categorie']) && !empty($_GET['categorie'])) {
            $categorieId = (int) $_GET['categorie'];
            $produits = $produitModel->findByCategory($categorieId);
        } else {
            $produits = $produitModel->getAllWithCategory();
        }

        $categories = $categorieModel->all();

        require_once 'views/produits/index.php';
    }
    /* Affiche le détail d'un produit */
    public function detail()
    {
        $produitModel = new Produit();
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header('Location: index.php?controller=produit&action=index');
            exit;
        }

        $id = (int) $_GET['id'];
        $produit = $produitModel->find($id);

    /* Gére si le produit n'est pas trouvé */
        if (!$produit) {
            header('HTTP/1.0 404 Not Found');
            require_once 'views/errors/404.php';
            exit;
        }

        require_once 'views/produits/detail.php';
    }
}

?>