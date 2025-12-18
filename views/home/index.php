<?php
$title = 'Accueil - E-Commerce';
include 'views/layout/header.php';
?>

<section class="hero">
    <h1>Bienvenue sur notre boutique E-Commerce</h1>
    <p>Veuillez découvrir notre catalogue si dessous</p>
</section>

<section class="categories">
    <h2>Catégories</h2>
    <div class="category-grid">
        <?php foreach ($categories as $categorie): ?>
            <a href="<?= url('produits?categorie=' . $categorie['id']) ?>" class="category-card">
                <h3><?= e($categorie['nom']) ?></h3>
                <p><?= $categorie['nb_produits'] ?> produit(s)</p>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<section class="featured-products">
    <h2>Nos Produits</h2>
    <div class="product-grid">
        <?php foreach (array_slice($produits, 0, 8) as $produit): ?>
            <div class="product-card">
                <img src="<?= url('public/images/produits/' . e($produit['image'])) ?>" 
                     alt="<?= e($produit['nom']) ?>"
                     onerror="this.src='<?= url('public/images/produits/default.jpg') ?>'">
                
                <div class="product-info">
                    <h3><?= e($produit['nom']) ?></h3>
                    <p class="category"><?= e($produit['categorie_nom'] ?? 'Sans catégorie') ?></p>
                    <p class="price"><?= formatPrice($produit['prix']) ?></p>
                    
                    <div class="product-actions">
                        <a href="<?= url('produit/detail?id=' . $produit['id']) ?>" class="btn btn-secondary">
                            Voir détails
                        </a>
                        
                        <?php if (isLoggedIn()): ?>
                            <form action="<?= url('panier/add') ?>" method="POST" class="inline-form">
                                <input type="hidden" name="produit_id" value="<?= $produit['id'] ?>">
                                <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <div class="text-center">
        <a href="<?= url('produits') ?>" class="btn btn-primary">Voir tous les produits</a>
    </div>
</section>

<?php include 'views/layout/footer.php'; ?>