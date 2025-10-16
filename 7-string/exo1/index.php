<?php ob_start(); //NE PAS MODIFIER 
$titre = "Exo 1 : Conditions Ternaires"; //Mettre le nom du titre de la page que vous voulez
?>

<!-- mettre ici le code -->
<?php
    echo "<h2>Exercise 1</h2>";
    $str = "Bonjour et bienvenue au cours de programmation.";
    for ($i = 0; $i < strlen($str); $i++) {
        echo $str[$i] . "<br />";
    }

    echo "<hr><h2>Exercise 2</h2>";
    $str1 = strtolower("Etoiles de mer");
    $str2 = strtolower("chat et la souris");

    if ($str1 < $str2) {
        echo "$str1<br>$str2";
    } else {
        echo "$str2<br>$str1";
    }

    echo "<hr><h2>Exercise 3</h2>";
    $text = "PHP 8 \n est meilleur \n que ASP \n et JSP \n réunis";
    $result = str_replace("\n", "<br />", $text);
    echo nl2br($result);

    echo "<hr><h2>Exercise 4</h2>";
    $mixedCase = "pHp est UN langage De sCripT.";
    $formattedText = ucwords(strtolower($mixedCase));
    echo $formattedText;

    echo "<hr><h2>Exercise 5</h2>";
    $quote = " Les dunes changent sous l'action du vent, mais le désert reste toujours le même. ";

    $posBeforeTrim = strpos($quote, "désert");
    echo "Position of the word 'désert' before trim: $posBeforeTrim<br>";

    $quote = ltrim($quote);

    $quote = rtrim($quote);

    $posAfterTrim = strpos($quote, "désert");
    echo "Position of the word 'désert' after trim: $posAfterTrim<br>";

    $substring1 = "Les dunes changent sous l'action du vent";
    echo "Substring 1: $substring1<br>";

    echo "Length of substring 1: " . strlen($substring1) . "<br>";

    echo "Number of 'o' in substring 1: " . substr_count($substring1, 'o') . "<br>";

    $substring2 = "le désert reste toujours le même";
    echo "Substring 2: $substring2<br>";

    echo "Length of substring 2: " . strlen($substring2) . "<br>";

    echo "Number of 'e' in substring 2: " . substr_count($substring2, 'e') . "<br>";

    echo "Number of 'on' in the full quote: " . substr_count($quote, 'on') . "<br>";

    echo "Total length of the quote: " . strlen($quote) . "<br>";

    echo "<hr><h2>Exercise 6</h2>";
    $email = "d.pascal2012@mail.com";

    $atIndex = strpos($email, "@");
    $username = substr($email, 0, $atIndex);
    echo "Username: $username<br>";

    echo "Index of '@': $atIndex<br>";

    $domain = substr($email, $atIndex + 1);
    echo "Domain name: $domain<br>";

    if ($domain === "gmail.com") {
        echo "It is a Gmail address.";
    } else {
        echo "It is NOT a Gmail address.";
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
