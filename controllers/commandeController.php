<?php

class CommandeController
{
    /* Affiche la page de validation de commande */
    public function validation()
    {
        if (!isLoggedIn()) {
            redirect(url('login'));
        }

        $userId = (int) ($_SESSION['user_id'] ?? 0);
        $panierModel = new Panier();
        $items = $panierModel->getByUser($userId);
        $total = $panierModel->getTotal($userId);

        if (empty($items)) {
            setFlash('error', 'Votre panier est vide');
            redirect(url('panier'));
        }
    /* Récupère les infos utilisateur */
        $utilisateurModel = new Utilisateur();
        $user = $utilisateurModel->find($userId);

        require_once 'views/commandes/validation.php';
    }


    public function process()
    {
        if (!isLoggedIn() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('panier'));
        }

        $adresse = trim($_POST['adresse'] ?? '');
        if ($adresse === '') {
            setFlash('error', 'Veuillez fournir une adresse de livraison');
            redirect(url('commande/validation'));
        }

        $userId = (int) ($_SESSION['user_id'] ?? 0);
        $panierModel = new Panier();
        $commandeModel = new Commande();
        $produitModel = new Produit();

        $items = $panierModel->getByUser($userId);
        $total = $panierModel->getTotal($userId);

        if (empty($items)) {
            setFlash('error', 'Votre panier est vide');
            redirect(url('panier'));
        }

        /* Démarrage de la transaction et création de la commande */
        try {
            $commandeModel->db->beginTransaction();
            $commande_id = $commandeModel->create($userId, $total, $adresse);
        /* Mise à jour des stocks */
            foreach ($items as $item) {
                $commandeModel->addLine(
                    $commande_id,
                    (int) $item['produit_id'],
                    (int) $item['quantite'],
                    (float) $item['prix']
                );
                $produitModel->updateStock(
                    (int) $item['produit_id'],
                    (int) $item['quantite']
                );
            }

            $panierModel->clear($userId);
            $commandeModel->db->commit();

            setFlash('success', 'Commande passée avec succès ! Voici le numéro de commande : ' . $commande_id);
            redirect(url('client/dashboard'));

        } catch (Exception $e) {
        /* On vérifie qu'une transaction est en cours */
            if (method_exists($commandeModel->db, 'inTransaction') && $commandeModel->db->inTransaction()) {
                $commandeModel->db->rollBack();
            }
            setFlash('error', 'Erreur lors de la commande : ' . $e->getMessage());
            redirect(url('panier'));
        }
    }

    /* Affichage de l'historique des commandes */
    public function historique()
    {
        if (!isLoggedIn()) {
            redirect(url('login'));
        }

        $userId = (int) ($_SESSION['user_id'] ?? 0);
        $commandeModel = new Commande();
        $commandes     = $commandeModel->getByUser($userId);

        require_once 'views/commandes/historique.php';
    }

    /* Affiche le détail de telle ou telle commande */
    public function detail()
    {
        if (!isLoggedIn()) {
            redirect(url('login'));
        }

        if (!isset($_GET['id'])) {
            redirect(url('client/dashboard'));
        }

        $commandeId = (int) $_GET['id'];
        $userId = (int) ($_SESSION['user_id'] ?? 0);

        $commandeModel = new Commande();
        $commande = $commandeModel->find($commandeId);

    /* Vérifie si la commande appartient à l'utilisateur */
        if (!$commande || (int) $commande['utilisateur_id'] !== $userId) {
            setFlash('error', 'Commande introuvable');
            redirect(url('client/dashboard'));
        }

        $details = $commandeModel->getDetails($commandeId);

        require_once 'views/commandes/detail.php';
    }
}

?>