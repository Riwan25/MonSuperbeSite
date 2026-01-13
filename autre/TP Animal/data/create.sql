CREATE DATABASE animal_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE animal_db;

CREATE TABLE type (
    id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(30) NOT NULL
);

CREATE TABLE animal (
    id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(30) NOT NULL,
    age TINYINT UNSIGNED,
    sex CHAR(1),
    type_id TINYINT UNSIGNED,
    CONSTRAINT fk_animal_type
        FOREIGN KEY (type_id)
        REFERENCES type(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

CREATE TABLE image (
    id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(30),
    url VARCHAR(100) NOT NULL
);

CREATE TABLE image_animal (
    animal_id TINYINT UNSIGNED,
    image_id TINYINT UNSIGNED,
    PRIMARY KEY (animal_id, image_id),
    CONSTRAINT fk_image_animal_animal
        FOREIGN KEY (animal_id)
        REFERENCES animal(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_image_animal_image
        FOREIGN KEY (image_id)
        REFERENCES image(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
