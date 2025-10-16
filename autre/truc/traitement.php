<?php
session_start();


if (!isset($_SESSION['clients'])) {
    $_SESSION['clients'] = array();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client = array(
        'nom' => htmlspecialchars(trim($_POST['nom'])),
        'prenom' => htmlspecialchars(trim($_POST['prenom'])),
        'adresse' => htmlspecialchars(trim($_POST['adresse'])),
        'ville' => htmlspecialchars(trim($_POST['ville'])),
        'code_postal' => htmlspecialchars(trim($_POST['code_postal'])),
        'date_enregistrement' => date('d/m/Y H:i:s')
    );
    
    $_SESSION['clients'][] = $client;
    
    header('Location: traitement.php');
    exit();
}
?>

<body>
    <h1>Liste des Clients Enregistrés</h1>
    
    <div class="count">
        <strong>Nombre total de clients : <?php echo count($_SESSION['clients']); ?></strong>
    </div>
    
    <?php if (empty($_SESSION['clients'])): ?>
        <div>
            <p>Aucun client enregistré pour le moment.</p>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Adresse</th>
                    <th>Ville</th>
                    <th>Code Postal</th>
                    <th>Date d'enregistrement</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['clients'] as $index => $client): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo $client['nom']; ?></td>
                        <td><?php echo $client['prenom']; ?></td>
                        <td><?php echo $client['adresse']; ?></td>
                        <td><?php echo $client['ville']; ?></td>
                        <td><?php echo $client['code_postal']; ?></td>
                        <td><?php echo $client['date_enregistrement']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    
    <div class="actions">
        <a href="formulaire.php">Ajouter un nouveau client</a>
        <?php if (!empty($_SESSION['clients'])): ?>
            <a href="vider_session.php" onclick="return confirm('Êtes-vous sûr de vouloir supprimer tous les clients ?');">Vider la liste</a>
        <?php endif; ?>
    </div>
</body>
