<?php
$title = 'Mon Espace Client - E-Commerce';
include 'views/layout/header.php';

$commandeModel = new Commande();
$commandes = $commandeModel->getByUser($_SESSION['user_id']);
$utilisateurModel = new Utilisateur();
$user = $utilisateurModel->find($_SESSION['user_id']);
?>
<h1>Mon Espace Client</h1>

<div class="dashboard">
    <div class="dashboard-card">
        <h2>Mes informations</h2>
        <p><strong>Nom :</strong> <?= e($user['nom']) ?> <?= e($user['prenom']) ?></p>
        <p><strong>Email :</strong> <?= e($user['email']) ?></p>
        <p><strong>Téléphone :</strong> <?= e($user['telephone'] ?? 'Non renseigné') ?></p>
        <p><strong>Adresse :</strong> <?= nl2br(e($user['adresse'] ?? 'Non renseignée')) ?></p>
    </div>
    <div class="dashboard-card">
        <h2>Mes commandes récentes</h2>
        
        <?php if (empty($commandes)): ?>
            <p>Aucune commande pour le moment</p>
        <?php else: ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>N° Commande</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($commandes, 0, 5) as $commande): ?>
                        <tr>
                            <td>
                                <a href="<?= url('commande/detail?id=' . $commande['id']) ?>">
                                    #<?= $commande['id'] ?>
                                </a>
                            </td>
                            <td><?= date('d/m/Y', strtotime($commande['created_at'])) ?></td>
                            <td><?= formatPrice($commande['total']) ?></td>
                            <td>
                                <span class="status status-<?= $commande['statut'] ?>">
                                    <?= ucfirst(str_replace('_', ' ', $commande['statut'])) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <a href="<?= url('commande/historique') ?>" class="btn btn-secondary">
                Voir toutes mes commandes
            </a>
        <?php endif; ?>
    </div>
    <div class="dashboard-actions">
        <a href="<?= url('produits') ?>" class="btn btn-primary">Continuer mes achats</a>
        <a href="<?= url('panier') ?>" class="btn btn-secondary">Voir mon panier</a>
    </div>
</div>
<?php include 'views/layout/footer.php'; ?>