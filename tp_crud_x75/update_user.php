<?php
require_once 'db_connect.php';

$errors = [];
$user = null;

// Vérifier si l'ID est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$conn = get_connection();
$id = intval($_GET['id']);

// Récupérer l'utilisateur avec prepared statement
$user = get_user_by_id($conn, $id);

if (!$user) {
    mysqli_close($conn);
    header("Location: index.php");
    exit();
}

$firstname = $user['firstname'];
$lastname = $user['lastname'];
$email = $user['email'];
$gender = $user['gender'];
$birthdate = $user['birthdate'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $birthdate = $_POST['birthdate'] ?? '';

    $errors = array_merge($errors, validate_name($firstname, 'prénom'));
    $errors = array_merge($errors, validate_name($lastname, 'nom'));
    $errors = array_merge($errors, validate_email($email));
    $errors = array_merge($errors, validate_gender($gender));
    $errors = array_merge($errors, validate_birthdate($birthdate));

    if (empty(validate_email($email)) && email_exists($conn, $email, $id)) {
        $errors[] = "Cet email est déjà utilisé par un autre utilisateur.";
    }
    if (empty($errors)) {
        $age = calculate_age($birthdate);
        
        if (update_user($conn, $id, $firstname, $lastname, $email, $gender, $birthdate, $age)) {
            mysqli_close($conn);
            header("Location: index.php?success=update");
            exit();
        } else {
            $errors[] = "Erreur lors de la modification de l'utilisateur.";
        }
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un utilisateur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Modifier un utilisateur</h1>
            <a href="index.php" class="btn btn-secondary">Retour à la liste</a>
        </header>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form id="userForm" method="POST" action="" novalidate>
                <div class="form-group">
                    <label for="firstname">Prénom <span class="required">*</span></label>
                    <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($firstname); ?>" required>
                    <span class="error-message" id="error-firstname"></span>
                </div>

                <div class="form-group">
                    <label for="lastname">Nom <span class="required">*</span></label>
                    <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>" required>
                    <span class="error-message" id="error-lastname"></span>
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                    <span class="error-message" id="error-email"></span>
                </div>

                <div class="form-group">
                    <label>Genre <span class="required">*</span></label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="gender" value="Homme" <?php echo ($gender == 'Homme') ? 'checked' : ''; ?> required>
                            Homme
                        </label>
                        <label>
                            <input type="radio" name="gender" value="Femme" <?php echo ($gender == 'Femme') ? 'checked' : ''; ?> required>
                            Femme
                        </label>
                    </div>
                    <span class="error-message" id="error-gender"></span>
                </div>

                <div class="form-group">
                    <label for="birthdate">Date de naissance <span class="required">*</span></label>
                    <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($birthdate); ?>" required>
                    <span class="error-message" id="error-birthdate"></span>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    <a href="index.php" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
