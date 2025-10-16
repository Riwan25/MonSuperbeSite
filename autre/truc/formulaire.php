
<h1>Formulaire Client</h1>

<form action="traitement.php" method="POST">
    <fieldset>
        <legend>Adresse client</legend>
        
        <div>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        
        <div>
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>
        
        <div>
            <label for="adresse">Adresse :</label>
            <input type="text" id="adresse" name="adresse" required>
        </div>
        
        <div>
            <label for="ville">Ville :</label>
            <input type="text" id="ville" name="ville" required>
        </div>
        
        <div>
            <label for="code_postal">Code postal :</label>
            <input type="text" id="code_postal" name="code_postal" required>
        </div>
        
        <input type="submit" value="Envoyer">
    </fieldset>
</form>

<div>
    <a href="traitement.php">Voir tous les clients enregistrés</a>
</div>
