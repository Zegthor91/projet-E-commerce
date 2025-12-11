<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'E-Commerce' ?></title>
    <link rel="stylesheet" href="<?= url('public/css/style.css') ?>">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <a href="<?= url() ?>" class="logo">E-Commerce</a>
                
                <ul class="nav-menu">
                    <li><a href="<?= url() ?>">Accueil</a></li>
                    <li><a href="<?= url('produits') ?>">Produits</a></li>
                    
                    <?php if (isLoggedIn()): ?>
                        <li><a href="<?= url('panier') ?>">Panier</a></li>
                        <li><a href="<?= url('client/dashboard') ?>">Mon Compte</a></li>
                        <li><a href="<?= url('logout') ?>">Deconnexion</a></li>
                        <li class="user-info"><?= e($_SESSION['user_prenom']) ?></li>
                    <?php else: ?>
                        <li><a href="<?= url('login') ?>">Connexion</a></li>
                        <li><a href="<?= url('register') ?>">Inscription</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>

    <main class="container">
        <?php if ($success = getFlash('success')): ?>
            <div class="alert alert-success"><?= e($success) ?></div>
        <?php endif; ?>
        
        <?php if ($error = getFlash('error')): ?>
            <div class="alert alert-error"><?= e($error) ?></div>
        <?php endif; ?>