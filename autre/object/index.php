
<?php
require 'classes/Animal.php';

$animaux = [
    new Animal('Rex', 5, 'chien'),
    new Animal('Miaou', 3, 'chat'),
    new Animal('Bella', 7, 'chien'),
    new Animal('Félix', 2, 'chat'),
    new Animal('Max', 4, 'chien'),
    new Animal('Whiskers', 6, 'chat')
];

$type = isset($_GET['type']) ? $_GET['type'] : 'tous';

$animauxAffiches = [];
if ($type === 'chiens') {
    foreach ($animaux as $animal) {
        if ($animal->getType() === 'chien') {
            $animauxAffiches[] = $animal;
        }
    }
} elseif ($type === 'chats') {
    foreach ($animaux as $animal) {
        if ($animal->getType() === 'chat') {
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

</body>
</html>
