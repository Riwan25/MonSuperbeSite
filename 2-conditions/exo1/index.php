<?php ob_start(); //NE PAS MODIFIER 
$titre = "Exo 1 : Conditions Ternaires"; //Mettre le nom du titre de la page que vous voulez
?>

<!-- mettre ici le code -->
<?php
     $sexe = "M";
    switch($sexe) {
        case "M":
            echo "Bonjour Monsieur";
            break;
        case "F":
            echo "Bonjour Madame";
            break;
        default:
            echo "Bonjour";
    }

    echo $sexe=="M" ? "Bonjour Monsieur" : "Bonjour Madame";
    echo "<br/>";
    $budget =  2553.89;
    $achats = 3554.76;

    if($budget >= $achats){
        echo "Budget suffisant";
    } else {
        echo "Budget insufisant";
    }

    echo "<br/>";

    $age = 22;

    if ($age >= 18) {
        echo "Vous êtes majeur";
    } else {
        echo "Vous êtes mineur";
    }

    echo "<br/>";

    $heure = 19;
    if ($heure < 6 || $heure >= 22) {
        echo "Bonne nuit";
    } elseif ($heure < 12) {
        echo "Bon matin";
    } elseif ($heure < 22) {
        echo "Bon après-midi";
    }

    echo "<br/>";

    $montantAchat = 120; 
    $reduction = 0;
    if ($montantAchat > 100) {
        $reduction = 0.10 * $montantAchat;
    } elseif ($montantAchat > 50) {
        $reduction = 0.05 * $montantAchat;
    } else {
        $reduction = 0;
    }

    echo "La réduction est de : " . $reduction . " euros.";
    echo "<br/>";

    $age = 45;
    switch (true) {
        case ($age >= 0 && $age <= 5):
            echo "Vous êtes un bébé";
            break;
        case ($age >= 6 && $age <= 12):
            echo "Vous êtes un enfant";
            break;
        case ($age >= 13 && $age <= 19):
            echo "Vous êtes un adolescent";
            break;
        case ($age >= 20 && $age <= 59):
            echo "Vous êtes un adulte";
            break;
        case ($age >= 60):
            echo "Vous êtes un senior";
            break;
        default:
            echo "Âge invalide";
    }



?>


<?php
/************************
 * NE PAS MODIFIER
 * PERMET d INCLURE LE MENU ET LE TEMPLATE
 ************************/
    $content = ob_get_clean();
    require "../../global/common/template.php";
?>
