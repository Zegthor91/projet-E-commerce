<?php
$title = 'Validation de la commande - E-Commerce';
include 'views/layout/header.php';
?>

<h1>Validation de la commande</h1>
<div class="order-validation">
    <div class="order-summary">
        <h2>Récapitulatif de votre commande</h2>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Sous-total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= e($item['nom']) ?></td>
                        <td><?= formatPrice($item['prix']) ?></td>
                        <td><?= $item['quantite'] ?></td>
                        <td><?= formatPrice($item['sous_total']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong><?= formatPrice($total) ?></strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <div class="delivery-info">
        <h2>Informations de livraison</h2>
        <form action="<?= url('commande/process') ?>" method="POST" class="order-form">
            <div class="form-group">
                <label for="adresse">Adresse de livraison</label>
                <textarea id="adresse" name="adresse" rows="4" required><?= e($user['adresse'] ?? '') ?></textarea>
            </div>
            
            <div class="form-actions">
                <a href="<?= url('panier') ?>" class="btn btn-secondary">Retour au panier</a>
                <button type="submit" class="btn btn-primary btn-large">Confirmer la commande</button>
            </div>
        </form>
    </div>
</div>
<?php include 'views/layout/footer.php'; ?>