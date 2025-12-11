<?php
$title = 'Détail de la commande #' . $commande['id'] . ' - E-Commerce';
include 'views/layout/header.php';
?>
<h1>Détail de la commande #<?= $commande['id'] ?></h1>
<div class="order-detail">
    <div class="order-info">
        <h2>Informations de la commande</h2>
        <p><strong>Date :</strong> <?= date('d/m/Y H:i', strtotime($commande['created_at'])) ?></p>
        <p><strong>Statut :</strong> 
            <span class="status status-<?= $commande['statut'] ?>">
                <?= ucfirst(str_replace('_', ' ', $commande['statut'])) ?>
            </span>
        </p>
        <p><strong>Adresse de livraison :</strong><br><?= nl2br(e($commande['adresse_livraison'])) ?></p>
        <p><strong>Total :</strong> <?= formatPrice($commande['total']) ?></p>
    </div>
    <div class="order-items">
        <h2>Produits commandés</h2>
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
                <?php foreach ($details as $item): ?>
                    <tr>
                        <td>
                            <div class="cart-product">
                                <img src="<?= url('public/images/produits/' . e($item['image'])) ?>" 
                                     alt="<?= e($item['nom']) ?>"
                                     onerror="this.src='<?= url('public/images/produits/default.jpg') ?>'">
                                <span><?= e($item['nom']) ?></span>
                            </div>
                        </td>
                        <td><?= formatPrice($item['prix_unitaire']) ?></td>
                        <td><?= $item['quantite'] ?></td>
                        <td><?= formatPrice($item['prix_unitaire'] * $item['quantite']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong><?= formatPrice($commande['total']) ?></strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="back-link">
        <a href="<?= url('client/dashboard') ?>" class="btn btn-secondary">← Retour à mon espace</a>
        <a href="<?= url('commande/historique') ?>" class="btn btn-secondary">Voir toutes mes commandes</a>
    </div>
</div>
<?php include 'views/layout/footer.php'; ?>