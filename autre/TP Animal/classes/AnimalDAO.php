<?php

require_once 'Database.php';
require_once 'Animal.php';

class AnimalDAO {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getInstance();
    }

    public function getAnimauxBD() {
        $animaux = [];

        $query = "SELECT id, nom, age, sex, type_id FROM animal ORDER BY nom ASC";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $animal = new Animal(
                    $row['id'],
                    $row['nom'],
                    $row['age'],
                    $row['sex'],
                    $row['type_id']
                );

                if ($row['type_id']) {
                    $typeLibelle = $this->getTypeAnimal($row['id']);
                    $animal->setTypeLibelle($typeLibelle);
                }

                $images = $this->getImagesAnimal($row['id']);
                $animal->setImages($images);

                $animaux[] = $animal;
            }
        } catch(PDOException $e) {
            echo "Erreur lors de la récupération des animaux : " . $e->getMessage();
        }

        return $animaux;
    }

    public function getTypeAnimal($idAnimal) {
        $typeLibelle = '';

        $query = "SELECT t.libelle 
                  FROM type t 
                  INNER JOIN animal a ON a.type_id = t.id 
                  WHERE a.id = :id_animal";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_animal', $idAnimal, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch();
            if ($row) {
                $typeLibelle = $row['libelle'];
            }
        } catch(PDOException $e) {
            echo "Erreur lors de la récupération du type : " . $e->getMessage();
        }

        return $typeLibelle;
    }

    public function getImagesAnimal($idAnimal) {
        $images = [];

        $query = "SELECT i.id, i.libelle, i.url 
                  FROM image i 
                  INNER JOIN image_animal ia ON ia.image_id = i.id 
                  WHERE ia.animal_id = :id_animal";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_animal', $idAnimal, PDO::PARAM_INT);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $images[] = [
                    'id' => $row['id'],
                    'libelle' => $row['libelle'],
                    'url' => $row['url']
                ];
            }
        } catch(PDOException $e) {
            echo "Erreur lors de la récupération des images : " . $e->getMessage();
        }

        return $images;
    }
}
