<?php ob_start(); //NE PAS MODIFIER 
$titre = "Exo 2 : Conditions"; //Mettre le nom du titre de la page que vous voulez
?>


<?php



?>



<?php
/************************
 * NE PAS MODIFIER
 * PERMET d INCLURE LE MENU ET LE TEMPLATE
 ************************/
    $content = ob_get_clean();
    require "../../global/common/template.php";
?>
