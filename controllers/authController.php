<?php

class AuthController {
    
    /*Affiche le formulaire de connexion*/
    public function login() {
        if (isLoggedIn()) {
            redirect(url());
        }
        
        require_once 'views/auth/login.php';
    }
    
    /*Traitement de la connexion*/
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $utilisateurModel = new Utilisateur();
            $user = $utilisateurModel->login($email, $password);
            
            if ($user) {
                startSession();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nom'] = $user['nom'];
                $_SESSION['user_prenom'] = $user['prenom'];
                $_SESSION['user_email'] = $user['email'];
                
                setFlash('success', 'Connexion réussie');
                redirect(url());
            } else {
                setFlash('error', 'Email ou mot de passe incorrect');
                redirect(url('login'));
            }
        }
        
        redirect(url('login'));
    }
    
    /*Affiche le formulaire d'inscription*/
    public function register() {
        if (isLoggedIn()) {
            redirect(url());
        }
        
        require_once 'views/auth/register.php';
    }
    
    /*Traitemeent de l'inscription*/
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'] ?? '',
                'prenom' => $_POST['prenom'] ?? '',
                'email' => $_POST['email'] ?? '',
                'mot_de_passe' => $_POST['mot_de_passe'] ?? '',
                'adresse' => $_POST['adresse'] ?? '',
                'telephone' => $_POST['telephone'] ?? ''
            ];
            
            /*Validation simple*/
            if (empty($data['nom']) || empty($data['email']) || empty($data['mot_de_passe'])) {
                setFlash('error', 'Veuillez remplir tous les champs obligatoires');
                redirect(url('register'));
            }
            
        /*Vérifie si l'email existe déjà*/
            $utilisateurModel = new Utilisateur();
            if ($utilisateurModel->findByEmail($data['email'])) {
                setFlash('error', 'Cet email est déjà utilisé');
                redirect(url('register'));
            }
            
        /*Création de l'utilisateur*/
            if ($utilisateurModel->create($data)) {
                setFlash('success', 'Inscription réussie. Vous pouvez maintenant vous connecter');
                redirect(url('login'));
            } else {
                setFlash('error', 'Erreur lors de l\'inscription');
                redirect(url('register'));
            }
        }
        
        redirect(url('register'));
    }
    
/*Déconnexion*/
    public function logout() {
        startSession();
        session_destroy();
        redirect(url());
    }
}

?>