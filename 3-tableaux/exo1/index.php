<?php ob_start(); //NE PAS MODIFIER 
$titre = "Partie 3 - Les tableaux associatifs"; //Mettre le nom du titre de la page que vous voulez
?>

<!-- mettre ici le code -->
<?php
    // $array = [
    //     "Allemagne" => "Berlin",
    //     "Italie" => "Rome",
    //     "Belgique" => "Bruxelles",
    //     "Maroc" => "Rabat",
    //     "Espagne" => "Madrid"
    // ];

    // $pays_population = array(
    //     'France' => 67595000,
    //     'Suede' => 9998000,
    //     'Suisse' => 8417000,
    //     'Kosovo' => 1820631,
    //     'Malte' => 434403,
    //     'Mexique' => 122273500,
    //     'Allemagne' => 82800000,
    // );

    // $test = [
    //     "1",
    //     "2",
    //     "3",
    //     "4",
    //     "5",
    //     "6",
    //     4 => "7",
    //     "8",
    //     "9",
    // ];

    // var_dump($test);

    // echo "<br>";

    // $array = [ 10, 20, 30, 40, 50];
    // $search = 10;
    // $find = false;
    // for ($i = 0; $i < count($array); $i++) {
    //     if ($array[$i] == $search) {
    //         echo "L'élément $search est à l'index $i";
    //         $find = true;
    //         break;
    //     }
    // }
    // if (!$find) {
    //     echo "L'élément $search n'existe pas dans le tableau";
    // }

    // echo "<br>";
    
    // for ($j = 0; $j < 10; $j++) {
    //     for ($i = 0; $i < 10-$j; $i++) {
    //         echo "*";
    //     }
    //     echo "<br>";
    // }


    function factoriel($number) {
        if ($number < 0) {
            return null;
        }
        if ($number === 0) {
            return 1;
        }
        $result = 1;
        for ($i = 1; $i <= $number; $i++) {
            $result *= $i;
        }
        return $result;
    }

    function factorielRec($number) {
        if ($number < 0) {
            return null;
        }
        if ($number === 0) {
            return 1;
        }
        return $number * factorielRec($number - 1);
    }

    function moyenne($array) {
        if (count($array) === 0) {
            return null;
        }
        $sum = 0;
        foreach ($array as $value) {
            $sum += $value;
        }
        return $sum / count($array);
    }

    // function max($array) {
    //     if (count($array) == 0) {
    //         return null;
    //     }
    //     $max = $array[0];
    //     foreach ($array as $value) {
    //         if ($value > $max) {
    //             $max = $value;
    //         }
    //     }
    //     return $max;
    // }

    // function min($array) {
    //     if (count($array) == 0) {
    //         return null;
    //     }
    //     $min = $array[0];
    //     foreach ($array as $value) {
    //         if ($value < $min) {
    //             $min = $value;
    //         }
    //     }
    //     return $min;
    // }

    function exist($sortedArray, $value) {
        $left = 0;
        $right = count($sortedArray) - 1;
        while ($left <= $right) {
            $mid = intdiv($left + $right, 2);
            if ($sortedArray[$mid] === $value) {
                return true;
            } elseif ($sortedArray[$mid] < $value) {
                $left = $mid + 1;
            } else {
                $right = $mid - 1;
            }
        }
        return false;
    }

    $array = [1, 23, 45, 67, 89, 90, 123, 145, 167, 189, 190, 223, 245, 267, 289, 290];
    var_dump(exist($array, 191 ));




    function primeNumber($n) {
        if ($n <= 1) {
            return false;
        }
        for ($i = 2; $i <= sqrt($n); $i++) {
            if ($n % $i == 0) {
                return false;
            }
        }
        return true;
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
