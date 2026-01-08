<?php

class Categorie extends Model {
    protected $table = 'categories';
/*Récupère toutes les catégories avec le nombre de produits*/
    public function getAllWithCount() {
        $query = "SELECT c.*, COUNT(p.id) as nb_produits
                  FROM categories c
                  LEFT JOIN produits p ON c.id = p.categorie_id
                  GROUP BY c.id
                  ORDER BY c.nom";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

?>