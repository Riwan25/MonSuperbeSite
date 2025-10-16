<?php ob_start(); //NE PAS MODIFIER 
$titre = "Exo 1 : Conditions Ternaires"; //Mettre le nom du titre de la page que vous voulez
?>

<!-- mettre ici le code -->
<?php
    $a = 5;
    $b = 7;
    $c = 9;
    echo "<p>";
        echo "***********************************<br />";
        echo "Voici les valeurs initiales de mes variables:<br />";
        echo "***********************************<br />";
        echo "A : ". $a ."<br />";
        echo "B : ". $b ."<br />";
        echo "C : ". $c;
    echo "</p>";

    $tmp=$a;
    $a=$b;
    $b=$c;
    $c=$tmp;

    echo "<p>";
        echo "***********************************<br />";
        echo "En permuttant ces trois variable on  aura:<br />";
        echo "***********************************<br />";
        echo "A : ". $a ."<br />";
        echo "B : ". $b ."<br />";
        echo "C : ". $c;
    echo "</p>";

?>


<?php
/************************
 * NE PAS MODIFIER
 * PERMET d INCLURE LE MENU ET LE TEMPLATE
 ************************/
    $content = ob_get_clean();
    require "../../global/common/template.php";
?>
