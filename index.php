<?php

session_start();

require_once 'config/database.php';
require_once 'helpers/functions.php';
require_once 'models/Model.php';
require_once 'models/Produit.php';
require_once 'models/Utilisateur.php';
require_once 'models/Panier.php';
require_once 'models/Commande.php';
require_once 'models/Categorie.php';
require_once 'controllers/HomeController.php';
require_once 'controllers/ProduitController.php';
require_once 'controllers/PanierController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/CommandeController.php';

$request = $_SERVER['REQUEST_URI'];
$request = str_replace('/ecommerce/', '', $request);
$request = strtok($request, '?');

/*Liste des routeurs*/
switch ($request) {
    case '':
    case '/':
        $controller = new HomeController();
        $controller->index();
        break;

    case 'produits':
        $controller = new ProduitController();
        $controller->index();
        break;
    
    case 'produit/detail':
        $controller = new ProduitController();
        $controller->detail();
        break;

    case 'panier':
        $controller = new PanierController();
        $controller->index();
        break;
    
    case 'panier/add':
        $controller = new PanierController();
        $controller->add();
        break;
    
    case 'panier/remove':
        $controller = new PanierController();
        $controller->remove();
        break;
    
    case 'panier/clear':
        $controller = new PanierController();
        $controller->clear();
        break;
    
    // Authentification
    case 'login':
        $controller = new AuthController();
        $controller->login();
        break;
    
    case 'authenticate':
        $controller = new AuthController();
        $controller->authenticate();
        break;
    
    case 'register':
        $controller = new AuthController();
        $controller->register();
        break;
    
    case 'register/store':
        $controller = new AuthController();
        $controller->store();
        break;
    
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;
    
    case 'commande/validation':
        $controller = new CommandeController();
        $controller->validation();
        break;
    
    case 'commande/process':
        $controller = new CommandeController();
        $controller->process();
        break;
    
    case 'commande/historique':
        $controller = new CommandeController();
        $controller->historique();
        break;
    
    case 'commande/detail':
        $controller = new CommandeController();
        $controller->detail();
        break;
    
/* Espace client*/
    case 'client/dashboard':
        if (!isLoggedIn()) {
            redirect(url('login'));
        }
        require_once 'views/client/dashboard.php';
        break;
    
/*ERROR 404*/
    default:
        http_response_code(404);
        echo "<h1>404 - Page non trouvée</h1>";
        echo "<a href='" . url() . "'>Retour à l'accueil</a>";
        break;
}