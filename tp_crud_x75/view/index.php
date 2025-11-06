<?php
require_once __DIR__ . "/../controller/userController.php";
$result = getUsers();
$message = '';
if (isset($_SESSION['success'])) {
    switch ($_SESSION['success']) {
        case 'add':
            $message = '<div class="alert alert-success">Utilisateur ajouté avec succès!</div>';
            break;
        case 'update':
            $message = '<div class="alert alert-success">Utilisateur modifié avec succès!</div>';
            break;
        case 'delete':
            $message = '<div class="alert alert-success">Utilisateur supprimé avec succès!</div>';
            break;
    }
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    $message .= '<div class="alert alert-error">' . htmlspecialchars($_SESSION['error']) . '</div>';
    unset($_SESSION['error']);
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs - CRUD</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Gestion des Utilisateurs</h1>
            <a href="userForm.php" class="btn btn-primary">Ajouter un utilisateur</a>
        </header>

        <?php echo $message; ?>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Genre</th>
                        <th>Date de naissance</th>
                        <th>Âge</th>
                        <th>Date création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (is_array($result) && count($result) > 0) {
                        foreach ($result as $row) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['firstname']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                            echo "<td>" . htmlspecialchars(date('d/m/Y', strtotime($row['birthdate']))) . "</td>";
                            echo "<td>" . htmlspecialchars($row['age']) . " ans</td>";
                            echo "<td>" . htmlspecialchars(date('d/m/Y H:i', strtotime($row['created_at']))) . "</td>";
                            echo "<td class='actions'>";
                            echo "<a href='userForm.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-edit'>Modifier</a>";
                            echo "<a href='../controller/userController.php?delete=" . htmlspecialchars($row['id']) . "' class='btn btn-delete' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet utilisateur ?\");'>Supprimer</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' class='no-data'>Aucun utilisateur trouvé</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
