<?php
require_once 'classes/AnimalDAO.php';

$animalDAO = new AnimalDAO();

$animaux = $animalDAO->getAnimauxBD();