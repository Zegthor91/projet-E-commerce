<?php

class Utilisateur extends Model {
    protected $table = 'utilisateurs';

/*Création du nouvel utilisateur*/
    public function create($data) {
        $query = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, adresse, telephone) 
                  VALUES (:nom, :prenom, :email, :mot_de_passe, :adresse, :telephone)";
        
        $stmt = $this->db->prepare($query);
        $password_hash = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);
        
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':prenom', $data['prenom']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':mot_de_passe', $password_hash);
        $stmt->bindParam(':adresse', $data['adresse']);
        $stmt->bindParam(':telephone', $data['telephone']);
        
        return $stmt->execute();
    }

/*Trouve un utilisateur par email*/
    public function findByEmail($email) {
        $query = "SELECT * FROM utilisateurs WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

/*Vérifie les identifiants de connexion*/
    public function login($email, $password) {
        $user = $this->findByEmail($email);
        
        if ($user && password_verify($password, $user['mot_de_passe'])) {
            return $user;
        }
        
        return false;
    }
}

?>