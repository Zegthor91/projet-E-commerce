<?php
$title = 'Mon Panier - E-Commerce';
include 'views/layout/header.php';
?>

<h1>Mon Panier</h1>

<?php if (empty($items)): ?>
    <div class="empty-cart">
        <p>Votre panier est vide</p>
        <a href="<?= url('produits') ?>" class="btn btn-primary">Continuer mes achats</a>
    </div>
<?php else: ?>
    <div class="cart-container">
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Sous total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <div class="cart-product">
                                <img src="<?= url('public/images/produits/' . e($item['image'])) ?>" 
                                     alt="<?= e($item['nom']) ?>"
                                     onerror="this.src='<?= url('public/images/produits/default.jpg') ?>'">
                                <span><?= e($item['nom']) ?></span>
                            </div>
                        </td>
                        <td><?= formatPrice($item['prix']) ?></td>
                        <td><?= $item['quantite'] ?></td>
                        <td><strong><?= formatPrice($item['sous_total']) ?></strong></td>
                        <td>
                            <a href="<?= url('panier/remove?id=' . $item['produit_id']) ?>" 
                               class="btn btn-danger btn-small"
                               onclick="return confirm('Etes-vous sur de vouloir retirer ce produit ?')">
                                Retirer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="cart-summary">
            <div class="cart-total">
                <h3>Total : <?= formatPrice($total) ?></h3>
            </div>
            
            <div class="cart-actions">
                <a href="<?= url('produits') ?>" class="btn btn-secondary">
                    Continuer mes achats
                </a>
                
                <a href="<?= url('panier/clear') ?>" 
                   class="btn btn-danger"
                   onclick="return confirm('Etes-vous certain de vouloir vider votre panier ?')">
                    Vider le panier
                </a>
                
                <a href="<?= url('commande/validation') ?>" class="btn btn-primary btn-large">
                    Passer la commande
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php include 'views/layout/footer.php'; ?>