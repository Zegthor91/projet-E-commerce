<?php

class Produit extends Model {
    protected $table = 'produits';

/*Récupère les produits avec leur catégorie*/
    public function getAllWithCategory() {
        $query = "SELECT p.*, c.nom as categorie_nom 
                  FROM produits p 
                  LEFT JOIN categories c ON p.categorie_id = c.id 
                  ORDER BY p.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

/*Récupère un produit avec sa catégorie*/
    public function findWithCategory($id) {
        $query = "SELECT p.*, c.nom as categorie_nom 
                  FROM produits p 
                  LEFT JOIN categories c ON p.categorie_id = c.id 
                  WHERE p.id = :id 
                  LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

/*Recherche des produits par catégorie*/
    public function findByCategory($categorie_id) {
        $query = "SELECT * FROM produits WHERE categorie_id = :categorie_id ORDER BY nom";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':categorie_id', $categorie_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

/*Met à jour le stock d'un produit*/
    public function updateStock($id, $quantite) {
        $query = "UPDATE produits SET stock = stock - :quantite WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':quantite', $quantite);
        return $stmt->execute();
    }
}

?>