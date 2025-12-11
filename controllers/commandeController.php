<?php

class CommandeController {
    
    /*Affiche la page de validation de commande*/
    public function validation() {
        if (!isLoggedIn()) {
            redirect(url('login'));
        }
        
        $panierModel = new Panier();
        $items = $panierModel->getByUser($_SESSION['user_id']);
        $total = $panierModel->getTotal($_SESSION['user_id']);
        
        if (empty($items)) {
            setFlash('error', 'Votre panier est vide');
            redirect(url('panier'));
        }
        
    /*Récupère les infos utilisateur*/
        $utilisateurModel = new Utilisateur();
        $user = $utilisateurModel->find($_SESSION['user_id']);
        
        require_once 'views/commandes/validation.php';
    }
    
    /*Traite la commande*/
    public function process() {
        if (!isLoggedIn() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('panier'));
        }
        
        $adresse = $_POST['adresse'] ?? '';
        
        if (empty($adresse)) {
            setFlash('error', 'Veuillez fournir une adresse de livraison');
            redirect(url('commande/validation'));
        }
        
        $panierModel = new Panier();
        $commandeModel = new Commande();
        $produitModel = new Produit();
        
        $items = $panierModel->getByUser($_SESSION['user_id']);
        $total = $panierModel->getTotal($_SESSION['user_id']);
        
        if (empty($items)) {
            setFlash('error', 'Votre panier est vide');
            redirect(url('panier'));
        }
        
        /* Démarre une transaction*/
        try {
            $commandeModel->db->beginTransaction();
            
        /* Crée la commande*/
            $commande_id = $commandeModel->create($_SESSION['user_id'], $total, $adresse);
            
        /* Ajoute les lignes de commande et met à jour les stocks*/
            foreach ($items as $item) {
                $commandeModel->addLine(
                    $commande_id, 
                    $item['produit_id'], 
                    $item['quantite'], 
                    $item['prix']
                );
                
        /*Mise à jour du stock*/
                $produitModel->updateStock($item['produit_id'], $item['quantite']);
            }
            
        /*Vide le panier*/
            $panierModel->clear($_SESSION['user_id']);
            
            $commandeModel->db->commit();
            
            setFlash('success', 'Commande passée avec succès ! Numéro de commande : ' . $commande_id);
            redirect(url('client/dashboard'));
            
        } catch (Exception $e) {
            $commandeModel->db->rollBack();
            setFlash('error', 'Erreur lors de la commande : ' . $e->getMessage());
            redirect(url('panier'));
        }
    }
    
    /*Affiche l'historique des commandes*/
    public function historique() {
        if (!isLoggedIn()) {
            redirect(url('login'));
        }
        
        $commandeModel = new Commande();
        $commandes = $commandeModel->getByUser($_SESSION['user_id']);
        
        require_once 'views/commandes/historique.php';
    }
    
    /*Affiche le détail d'une commande*/
    public function detail() {
        if (!isLoggedIn()) {
            redirect(url('login'));
        }
        
        if (!isset($_GET['id'])) {
            redirect(url('client/dashboard'));
        }
        
        $commandeModel = new Commande();
        $commande = $commandeModel->find($_GET['id']);
        
    /*Vérifie que la commande appartient à l'utilisateur*/
        if (!$commande || $commande['utilisateur_id'] != $_SESSION['user_id']) {
            setFlash('error', 'Commande introuvable');
            redirect(url('client/dashboard'));
        }
        
        $details = $commandeModel->getDetails($_GET['id']);
        
        require_once 'views/commandes/detail.php';
    }
}

?>