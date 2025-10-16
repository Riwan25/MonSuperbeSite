<?php ob_start(); //NE PAS MODIFIER 
$titre = "Exo 1 : Boucles"; //Mettre le nom du titre de la page que vous voulez
?>

<?="Boucle exo1";
?>







<?php
/************************
 * NE PAS MODIFIER
 * PERMET d INCLURE LE MENU ET LE TEMPLATE
 ************************/
    $content = ob_get_clean();
    require "../../global/common/template.php";
?>
