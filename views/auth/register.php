<?php
$title = 'Inscription - E-Commerce';
include 'views/layout/header.php';
?>

<div class="auth-container">
    <div class="auth-box">
        <h1>Inscription</h1>
        
        <form action="<?= url('register/store') ?>" method="POST" class="auth-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" required>
            </div>
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required minlength="6">
                <small>Minimum 6 caractères</small>
            </div>
            <div class="form-group">
                <label for="adresse">Adresse</label>
                <textarea id="adresse" name="adresse" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="tel" id="telephone" name="telephone">
            </div>
            <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
        </form>
        
        <p class="auth-link">
            Déjà un compte ? <a href="<?= url('login') ?>">Se connecter</a>
        </p>
    </div>
</div>
<?php include 'views/layout/footer.php'; ?>