-- Insertion de données de test pour la base de données animal_db

USE animal_db;

-- Insertion des types d'animaux
INSERT INTO type (libelle) VALUES
('Chien'),
('Chat'),
('Oiseau'),
('Poisson'),
('Reptile');

-- Insertion des animaux
INSERT INTO animal (nom, age, sex, type_id) VALUES
('Rex', 5, 'M', 1),
('Minou', 3, 'F', 2),
('Titi', 2, 'M', 3),
('Nemo', 1, 'M', 4),
('Médor', 7, 'M', 1),
('Félix', 4, 'M', 2);

-- Insertion des images (exemples)
INSERT INTO image (libelle, url) VALUES
('Rex portrait', 'Jeux.png'),
('Rex jouant', 'Jeux2.png'),
('Minou endormi', 'JS.png'),
('Titi dans sa cage', 'JS2.png'),
('Nemo dans l\'aquarium', 'PHP.png'),
('Médor dans le jardin', 'PHP2.png'),
('Félix sur le canapé', 'SQL.png');

-- Liaison entre animaux et images
INSERT INTO image_animal (animal_id, image_id) VALUES
(1, 1), -- Rex - rex1.jpg
(1, 2), -- Rex - rex2.jpg
(2, 3), -- Minou - minou1.jpg
(3, 4), -- Titi - titi1.jpg
(4, 5), -- Nemo - nemo1.jpg
(5, 6), -- Médor - medor1.jpg
(6, 7), -- Félix - felix1.jpg
