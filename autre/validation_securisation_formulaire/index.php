<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Formulaire moderne</title>
        <link rel="stylesheet" href="formulaire.css">
    </head>
    <body>
    <form id="myValidatedForm" action="" method="post">
            <h1>Formulaire de validation</h1>

            <div class="c100">
                <label for="prenom">Prénom :</label><br>
                <input type="text" id="prenom" name="prenom" class="input-valid" >
                <p id="errorMessagePrenom" class="hidden">Le prénom est obligatoire.</p>
            </div>

            <div class="c100">
                <label for="mail">Email :</label>
                <input type="text" id="mail" name="mail" class="input-valid" >
                <p id="errorMessageEmail" class="hidden">Le mail est obligatoire.</p>
            </div>

            <div class="c100">
                <label for="age">Âge :</label>
                <input type="number" id="age" name="age"  >
            </div>

            <div class="c100" id="submit">
                <input type="submit" name="submit" value="Envoyer">
            </div>
        </form>

        <script src="validation.js"></script>
    </body>
</html>
<?php
        if (isset($_POST["submit"])) {
            $prenom = trim($_POST["prenom"] ?? '');
            $mail   = trim($_POST["mail"] ?? '');
            $age    = trim($_POST["age"] ?? '');

            $prenom_safe = htmlspecialchars($prenom);
            $mail_safe   = htmlspecialchars($mail);
            $age_safe    = htmlspecialchars($age);
             // validation du coté serveur
            $errors = [];

           /*if ($prenom === '') {
                $errors[] = "Le prénom est requis.";
            }
            if ($mail === '' || !filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email invalide.";
            }
            if ($age === '' || !is_numeric($age) || $age < 12 || $age > 99) {
                $errors[] = "L'âge doit être un nombre entre 12 et 99.";
            }
             if (empty($errors)) {
                echo <<<HTML
                <section class="result success">
                    <div class="result-header">
                        <span class="icon"></span>
                        <h2>Envoi réussi</h2>
                    </div>
                    <div class="card">
                        <div class="row"><span class="label">Prénom</span><span class="value">{$prenom_safe}</span></div>
                        <div class="row"><span class="label">Email</span><span class="value">{$mail_safe}</span></div>
                        <div class="row"><span class="label">Âge</span><span class="value">{$age_safe} ans</span></div>
                    </div>
                </section>
                HTML;
            } 
            else { //  to handle errors
                echo <<<HTML
                <section class="result error">
                    <div class="result-header">
                        <span class="icon"></span>
                        <h2>Erreur de validation</h2>
                    </div>
                    <div class="card">
                        <ul>
                HTML;
                foreach ($errors as $error) {
                    echo "<li>{$error}</li>";
                }
                echo <<<HTML
                        </ul>
                    </div>
                </section>
                HTML;
            } */
        }
        ?> 