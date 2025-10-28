<link rel="stylesheet" href="formulaire.css">

<?php
        if (isset($_POST["submit"])) {
            $prenom = trim($_POST["prenom"] ?? '');
            $mail   = trim($_POST["mail"] ?? '');
            $age    = trim($_POST["age"] ?? '');

            $prenom_safe = $prenom;
            $mail_safe   = htmlspecialchars($mail);
            $age_safe    = htmlspecialchars($age);
             //
            $errors = [];

            if ($prenom === '') {
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
            }
        }
        ?> 