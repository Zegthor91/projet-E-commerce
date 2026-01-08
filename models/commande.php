<?php

class Commande extends Model {
    protected $table = 'commandes';

/*Crée une nouvelle commande*/
    public function create($utilisateur_id, $total, $adresse) {
        $query = "INSERT INTO commandes (utilisateur_id, total, adresse_livraison) 
                  VALUES (:utilisateur_id, :total, :adresse)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':utilisateur_id', $utilisateur_id);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':adresse', $adresse);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }

/*Ajoute une ligne de commande*/
    public function addLine($commande_id, $produit_id, $quantite, $prix_unitaire) {
        $query = "INSERT INTO lignes_commande (commande_id, produit_id, quantite, prix_unitaire) 
                  VALUES (:commande_id, :produit_id, :quantite, :prix_unitaire)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':commande_id', $commande_id);
        $stmt->bindParam(':produit_id', $produit_id);
        $stmt->bindParam(':quantite', $quantite);
        $stmt->bindParam(':prix_unitaire', $prix_unitaire);
        
        return $stmt->execute();
    }

/*Récupère les commandes d'un utilisateur*/
    public function getByUser($utilisateur_id) {
        $query = "SELECT * FROM commandes WHERE utilisateur_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $utilisateur_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

/*Récupère les détails d'une commande avec ses lignes*/
    public function getDetails($commande_id) {
        $query = "SELECT lc.*, p.nom, p.image
                  FROM lignes_commande lc
                  JOIN produits p ON lc.produit_id = p.id
                  WHERE lc.commande_id = :commande_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':commande_id', $commande_id);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
}

?>