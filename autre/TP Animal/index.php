<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Animaux</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    require_once 'processAnimals.php';
    ?>

    <div class="container">
        <h1>Liste des Animaux</h1>

        <?php if (empty($animaux)): ?>
            <div class="no-data">
                Aucun animal trouvé dans la base de données.
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                      <th>Nom</th>
                      <th>Age</th>
                      <th>Sexe</th>
                      <th>Type</th>
                      <th>Images</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($animaux as $animal): ?>
                        <tr>
                          <td><?php echo htmlspecialchars($animal->getNom()); ?></td>
                          <td>
                            <?php if ($animal->getAge()): ?>
                              <?php echo htmlspecialchars($animal->getAge()); ?> an<?php echo $animal->getAge() > 1 ? 's' : ''; ?>
                              <?php endif; ?>
                            </td>
                            <td>
                              <?php if ($animal->getSex()): ?>
                                <?php 
                                    $sexe = strtoupper($animal->getSex());
                                    echo $sexe === 'M' ? 'Male' : 'Femelle';
                                    ?>
                                <?php endif; ?>
                              </td>
                              <td>
                                <?php if ($animal->getTypeLibelle()): ?>
                                  <?php echo htmlspecialchars($animal->getTypeLibelle()); ?>
                                <?php endif; ?>
                              </td>
                              <td>
                                <?php if (!empty($animal->getImages())): ?>
                                    <div class="images-container">
                                        <?php 
                                        $images = $animal->getImages();
                                        $imageCount = count($images);
                                        foreach ($images as $index => $image): 
                                            $isLastOdd = ($imageCount % 2 !== 0 && $index === $imageCount - 1);
                                        ?>
                                            <div class="image-wrapper<?php echo $isLastOdd ? ' single-last' : ''; ?>">
                                                <img src="images/<?php echo htmlspecialchars($image['url']); ?>" 
                                                      alt="<?php echo htmlspecialchars($image['libelle'] ?? $animal->getNom()); ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                  <div class="no-image">
                                    Aucune image
                                  </div>
                                <?php endif; ?>
                              </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </script>
</body>
</html>
