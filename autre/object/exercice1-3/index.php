
<?php
require 'process.php';
$animauxAffiches = getlistAnimeaux();
$livresAffiches = getlistLivres();
$type = isset($_GET['type']) ? $_GET['type'] : 'tous';
$dateFilter = isset($_GET['date']) ? $_GET['date'] : null;
$dates = getListDates();
?>

<h1>Liste des Animaux </h1>

<div class="buttons">
    <a href="?type=tous" class="btn">Tous les animaux</a>
    <a href="?type=chiens" class="btn btn-chien">Seulement les chiens</a>
    <a href="?type=chats" class="btn btn-chat">Seulement les chats</a>
</div>

<?php
if ($type === 'chiens') {
    echo '<div>Affichage : Chiens uniquement</div>';
} elseif ($type === 'chats') {
    echo '<div>Affichage : Chats uniquement</div>';
} else {
    echo '<div>Affichage : Tous les animaux</div>';
}

if (count($animauxAffiches) > 0) {
    echo '<div>--------------------------------</div>';
    foreach ($animauxAffiches as $animal) {
        echo '<div>';
        echo '<div>' . ' ' . htmlspecialchars($animal->getNom()) . '</div>';
        echo '<div>Age : ' . $animal->getAge() . ' ans</div>';
        echo '<span>' . ucfirst($animal->getType()) . '</span>';
        echo '</div>';
        echo '<div>--------------------------------</div>';
    }
} else {
    echo '<div class="no-results">Aucun animal trouvé pour ce filtre.</div>';
}
?>
<h1>Liste des Livres </h1>
<select id="dateFilter" onchange="window.location.href='?date=' + this.value">
    <option value="" <?php echo ($dateFilter === null) ? 'selected' : ''; ?>>Tous les livres</option>
    <?php
        foreach ($dates as $date) {
            $selected = ($dateFilter === $date) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($date) . '" ' . $selected . '>' . htmlspecialchars($date) . '</option>';
        }
    ?>
</select>

<?php
if ($dateFilter) {
    echo '<div>Affichage : Livres publiés en ' . htmlspecialchars($dateFilter) . '</div>';
} else {
    echo '<div>Affichage : Tous les livres</div>';
}

if (count($livresAffiches) > 0) {
    echo '<div>--------------------------------</div>';
    foreach ($livresAffiches as $livre) {
        echo '<div>';
        echo '<div>' . ' ' . htmlspecialchars($livre->getNom()) . '</div>';
        echo '<div>Edition : ' . htmlspecialchars($livre->getEdition()) . '</div>';
        echo '<div>Auteur : ' . htmlspecialchars($livre->getAuteur()) . '</div>';
        echo '<div>Date de publication : ' . htmlspecialchars($livre->getDate()) . '</div>';
        echo '</div>';
        echo '<div>--------------------------------</div>';
    }
} else {
    echo '<div class="no-results">Aucun livre trouvé pour ce filtre.</div>';
}

?>

</body>
</html>
