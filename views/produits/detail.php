<?php
$title = e($produit['nom']) . ' - E-Commerce';
include 'views/layout/header.php';
?>

<div class="product-detail">
    <div class="product-image">
        <img src="<?= url('public/images/produits/' . e($produit['image'])) ?>" 
             alt="<?= e($produit['nom']) ?>"
             onerror="this.src='<?= url('public/images/produits/default.jpg') ?>'">
    </div>
    <div class="product-info-detail">
        <h1><?= e($produit['nom']) ?></h1>
        <p class="category">
            Catégorie : <?= e($produit['categorie_nom'] ?? 'Non catégorisé') ?>
        </p>
        <p class="price-large"><?= formatPrice($produit['prix']) ?></p>
        <p class="stock">
            <?php if ($produit['stock'] > 0): ?>
                <span class="in-stock">En stock (<?= $produit['stock'] ?> disponible(s))</span>
            <?php else: ?>
                <span class="out-of-stock">Rupture de stock</span>
            <?php endif; ?>
        </p>
        <div class="description">
            <h3>Description</h3>
            <p><?= nl2br(e($produit['description'])) ?></p>
        </div>
        
        <?php if (isLoggedIn() && $produit['stock'] > 0): ?>
            <form action="<?= url('panier/add') ?>" method="POST" class="add-to-cart-form">
                <input type="hidden" name="produit_id" value="<?= $produit['id'] ?>">
                
                <div class="quantity-selector">
                    <label for="quantite">Quantité:</label>
                    <input type="number" name="quantite" id="quantite" 
                           value="1" min="1" max="<?= $produit['stock'] ?>">
                </div>
                
                <button type="submit" class="btn btn-primary btn-large">
                    Ajouter au panier
                </button>
            </form>
        <?php elseif (!isLoggedIn()): ?>
            <p class="login-message">
                <a href="<?= url('login') ?>">Connectez-vous</a> pour ajouter ce produit au panier
            </p>
        <?php endif; ?>
        <a href="<?= url('produits') ?>" class="btn btn-secondary">Retour aux produits</a>
    </div>
</div>
<?php include 'views/layout/footer.php'; ?>