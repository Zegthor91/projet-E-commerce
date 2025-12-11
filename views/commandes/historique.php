<?php
$title = 'Historique des commandes - E-Commerce';
include 'views/layout/header.php';
?>
<h1>Historique de mes commandes</h1>

<?php if (empty($commandes)): ?>
    <p>Vous n'avez pas encore passé de commande.</p>
    <a href="<?= url('produits') ?>" class="btn btn-primary">Découvrir nos produits</a>
<?php else: ?>
    <table class="orders-table">
        <thead>
            <tr>
                <th>N° Commande</th>
                <th>Date</th>
                <th>Total</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commandes as $commande): ?>
                <tr>
                    <td>#<?= $commande['id'] ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($commande['created_at'])) ?></td>
                    <td><?= formatPrice($commande['total']) ?></td>
                    <td>
                        <span class="status status-<?= $commande['statut'] ?>">
                            <?= ucfirst(str_replace('_', ' ', $commande['statut'])) ?>
                        </span>
                    </td>
                    <td>
                        <a href="<?= url('commande/detail?id=' . $commande['id']) ?>" 
                           class="btn btn-secondary btn-small">
                            Détails
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
<?php include 'views/layout/footer.php'; ?>