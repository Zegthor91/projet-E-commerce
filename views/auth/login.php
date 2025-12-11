<?php
$title = 'Connexion - E-Commerce';
include 'views/layout/header.php';
?>

<div class="auth-container">
    <div class="auth-box">
        <h1>Connexion</h1>
        
        <form action="<?= url('authenticate') ?>" method="POST" class="auth-form">
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe *</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
        </form>
        
        <p class="auth-link">
            Pas encore de compte ? <a href="<?= url('register') ?>">S'inscrire</a>
        </p>
    </div>
</div>

<?php include 'views/layout/footer.php';

?>