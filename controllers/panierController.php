<?php

class PanierController {
    
/*Affichage du panier*/
    public function index() {
        if (!isLoggedIn()) {
            setFlash('error', 'Vous devez être connecté pour accéder au panier');
            redirect(url('login'));
        }
        
        $panierModel = new Panier();
        $items = $panierModel->getByUser($_SESSION['user_id']);
        $total = $panierModel->getTotal($_SESSION['user_id']);
        
        require_once 'views/panier/index.php';
    }
    
    /*Ajoute un produit au panier*/
    public function add() {
        if (!isLoggedIn()) {
            setFlash('error', 'Vous devez être connecté pour ajouter au panier');
            redirect(url('login'));
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $produit_id = $_POST['produit_id'] ?? null;
            $quantite = $_POST['quantite'] ?? 1;
            
            if ($produit_id) {
            /*Vérifie le stock du panier*/
                $produitModel = new Produit();
                $produit = $produitModel->find($produit_id);
                
                if ($produit && $produit['stock'] >= $quantite) {
                    $panierModel = new Panier();
                    
                    if ($panierModel->add($_SESSION['user_id'], $produit_id, $quantite)) {
                        setFlash('success', 'Produit ajouté au panier');
                    } else {
                        setFlash('error', 'Erreur lors de l\'ajout au panier');
                    }
                } else {
                    setFlash('error', 'Stock insuffisant');
                }
            }
        }
        
        redirect(url('panier'));
    }
    
/*Supprime un produit du panier*/
    public function remove() {
        if (!isLoggedIn()) {
            redirect(url('login'));
        }
        
        if (isset($_GET['id'])) {
            $panierModel = new Panier();
            
            if ($panierModel->removeItem($_SESSION['user_id'], $_GET['id'])) {
                setFlash('success', 'Produit retiré du panier');
            }
        }
        
        redirect(url('panier'));
    }
    
/**Vide le panier*/
    public function clear() {
        if (!isLoggedIn()) {
            redirect(url('login'));
        }
        
        $panierModel = new Panier();
        $panierModel->clear($_SESSION['user_id']);
        
        setFlash('success', 'Panier vidé');
        redirect(url('panier'));
    }
}

?>