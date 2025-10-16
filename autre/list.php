

<?php
$animal1 = [
    'nom' => 'Rex',
    'age' => 5,
    'type' => 'chien'
];

$animal2 = [
    'nom' => 'Miaou',
    'age' => 3,
    'type' => 'chat'
];

$animal3 = [
    'nom' => 'Bella',
    'age' => 7,
    'type' => 'chien'
];

$animal4 = [
    'nom' => 'Félix',
    'age' => 2,
    'type' => 'chat'
];

$animal5 = [
    'nom' => 'Max',
    'age' => 4,
    'type' => 'chien'
];

$animal6 = [
    'nom' => 'Whiskers',
    'age' => 6,
    'type' => 'chat'
];

$animaux = [$animal1, $animal2, $animal3, $animal4, $animal5, $animal6];

$type = isset($_GET['type']) ? $_GET['type'] : 'tous';

$animauxAffiches = [];
if ($type === 'chiens') {
    foreach ($animaux as $animal) {
        if ($animal['type'] === 'chien') {
            $animauxAffiches[] = $animal;
        }
    }
} elseif ($type === 'chats') {
    foreach ($animaux as $animal) {
        if ($animal['type'] === 'chat') {
            $animauxAffiches[] = $animal;
        }
    }
} else {
    $animauxAffiches = $animaux;
}
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
        echo '<div>' . ' ' . htmlspecialchars($animal['nom']) . '</div>';
        echo '<div>Age : ' . $animal['age'] . ' ans</div>';
        echo '<span>' . ucfirst($animal['type']) . '</span>';
        echo '</div>';
        echo '<div>--------------------------------</div>';
    }
} else {
    echo '<div class="no-results">Aucun animal trouvé pour ce filtre.</div>';
}
?>

</body>
</html>
