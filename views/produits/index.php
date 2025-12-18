<?php
$title = 'Nos Produits - E-Commerce';
include 'views/layout/header.php';
?>

<h1>Liste de nos Produits</h1>

<div class="filters">
    <h3>Filtrer les produits par catégorie:</h3>
    <a href="<?= url('produits') ?>" class="filter-btn <?= !isset($_GET['categorie']) ? 'active' : '' ?>">
        Toutes
    </a>  
    <?php foreach ($categories as $categorie): ?>
        <a href="<?= url('produits?categorie=' . $categorie['id']) ?>" 
           class="filter-btn <?= (isset($_GET['categorie']) && $_GET['categorie'] == $categorie['id']) ? 'active' : '' ?>">
            <?= e($categorie['nom']) ?>
        </a>
    <?php endforeach; ?>
</div>

<div class="product-grid">
    <?php if (empty($produits)): ?>
        <p>Aucun produit disponible dans cette catégorie</p>
    <?php else: ?>
        <?php foreach ($produits as $produit): ?>
            <div class="product-card">
                <img src="<?= url('public/images/produits/' . e($produit['image'])) ?>" 
                     alt="<?= e($produit['nom']) ?>"
                     onerror="this.src='<?= url('public/images/produits/default.jpg') ?>'">
                
                <div class="product-info">
                    <h3><?= e($produit['nom']) ?></h3>
                    <p class="price"><?= formatPrice($produit['prix']) ?></p>
                    <p class="stock">
                        <?php if ($produit['stock'] > 0): ?>
                            <span class="in-stock">En stock (<?= $produit['stock'] ?>)</span>
                        <?php else: ?>
                            <span class="out-of-stock">En rupture de stock</span>
                        <?php endif; ?>
                    </p>
                    
                    <div class="product-actions">
                        <a href="<?= url('produit/detail?id=' . $produit['id']) ?>" class="btn btn-secondary">
                            Voir détails
                        </a>
                        
                        <?php if (isLoggedIn() && $produit['stock'] > 0): ?>
                            <form action="<?= url('panier/add') ?>" method="POST" class="inline-form">
                                <input type="hidden" name="produit_id" value="<?= $produit['id'] ?>">
                                <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php include 'views/layout/footer.php'; ?>