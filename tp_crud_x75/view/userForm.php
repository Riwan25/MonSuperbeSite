<?php
require_once __DIR__ . "/../controller/userController.php";

$isUpdate = false;
$user = [
    'id' => '',
    'firstname' => '',
    'lastname' => '',
    'email' => '',
    'gender' => '',
    'birthdate' => ''
];

if (isset($_GET['id'])) {
    $isUpdate = true;
    $userData = getUserById($_GET['id']);
    if ($userData) {
        $user = $userData;
    } else {
        header("Location: index.php");
        exit();
    }
}
$submitButton = $isUpdate ? "updateUser" : "saveUser";
$submitLabel = $isUpdate ? "Modifier l'utilisateur" : "Ajouter l'utilisateur";
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
            <h1><?php echo $pageTitle; ?></h1>
            <a href="index.php" class="btn btn-secondary">Retour à la liste</a>
        </header>

        <div class="form-container">
            <form id="userForm" method="POST" action="../controller/userController.php" novalidate>
                <?php if ($isUpdate): ?>
                    <input type="hidden" name="idUser" value="<?php echo htmlspecialchars($user['id']); ?>">
                <?php endif; ?>
                <div class="form-group">
                    <label for="firstname">Prénom <span class="required">*</span></label>
                    <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
                    <span class="error-message" id="error-firstname"></span>
                </div>

                <div class="form-group">
                    <label for="lastname">Nom <span class="required">*</span></label>
                    <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
                    <span class="error-message" id="error-lastname"></span>
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    <span class="error-message" id="error-email"></span>
                </div>

                <div class="form-group">
                    <label>Genre <span class="required">*</span></label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="gender" value="Homme" <?php echo ($user['gender'] == 'Homme') ? 'checked' : ''; ?> required>
                            Homme
                        </label>
                        <label>
                            <input type="radio" name="gender" value="Femme" <?php echo ($user['gender'] == 'Femme') ? 'checked' : ''; ?> required>
                            Femme
                        </label>
                    </div>
                    <span class="error-message" id="error-gender"></span>
                </div>

                <div class="form-group">
                    <label for="birthdate">Date de naissance <span class="required">*</span></label>
                    <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($user['birthdate']); ?>" required>
                    <span class="error-message" id="error-birthdate"></span>
                </div>

                <div class="form-actions">
                    <button type="submit" name="<?php echo $submitButton; ?>" class="btn btn-primary"><?php echo $submitLabel; ?></button>
                    <a href="index.php" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
