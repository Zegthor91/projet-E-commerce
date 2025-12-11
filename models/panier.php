<?php

class Panier extends Model {
    protected $table = 'paniers';

/*Ajoute un produit au panier*/
    public function add($utilisateur_id, $produit_id, $quantite = 1) {
    /* Vérifie si le produit existe déjà dans le panier*/
        $query = "SELECT * FROM paniers WHERE utilisateur_id = :user_id AND produit_id = :produit_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $utilisateur_id);
        $stmt->bindParam(':produit_id', $produit_id);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
        /* Quantité mis à jour */
            $query = "UPDATE paniers SET quantite = quantite + :quantite 
                      WHERE utilisateur_id = :user_id AND produit_id = :produit_id";
        } else {
        /* Insertion du nouveau produit*/
            $query = "INSERT INTO paniers (utilisateur_id, produit_id, quantite) 
                      VALUES (:user_id, :produit_id, :quantite)";
        }
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $utilisateur_id);
        $stmt->bindParam(':produit_id', $produit_id);
        $stmt->bindParam(':quantite', $quantite);
        
        return $stmt->execute();
    }

/*Récupère le panier d'un utilisateur avec les détails des produits*/
    public function getByUser($utilisateur_id) {
        $query = "SELECT pan.*, p.nom, p.prix, p.image, p.stock, (pan.quantite * p.prix) as sous_total
                  FROM paniers pan
                  JOIN produits p ON pan.produit_id = p.id
                  WHERE pan.utilisateur_id = :user_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $utilisateur_id);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

/*Supprime un produit du panier*/
    public function removeItem($utilisateur_id, $produit_id) {
        $query = "DELETE FROM paniers WHERE utilisateur_id = :user_id AND produit_id = :produit_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $utilisateur_id);
        $stmt->bindParam(':produit_id', $produit_id);
        return $stmt->execute();
    }

/* Vide le panier d'un utilisateur*/
    public function clear($utilisateur_id) {
        $query = "DELETE FROM paniers WHERE utilisateur_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $utilisateur_id);
        return $stmt->execute();
    }

/*Calcul total du panier*/
    public function getTotal($utilisateur_id) {
        $query = "SELECT SUM(pan.quantite * p.prix) as total
                  FROM paniers pan
                  JOIN produits p ON pan.produit_id = p.id
                  WHERE pan.utilisateur_id = :user_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $utilisateur_id);
        $stmt->execute();
        
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
}

?>