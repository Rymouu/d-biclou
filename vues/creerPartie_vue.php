<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une partie</title>
</head>
<body>
    <h1>Créer une partie</h1>
    <form action="creerPartie_controleur.php" method="post">
        <label for="nombre_cartes">Nombre de cartes constituant le plateau :</label>
        <input type="number" name="nombre_cartes" required><br>

        <label for="nombre_vertes">Nombre de cartes vertes à sélectionner :</label>
        <input type="number" name="nombre_vertes" required><br>

        <label for="nombre_oranges">Nombre de cartes oranges à sélectionner :</label>
        <input type="number" name="nombre_oranges" required><br>

        <label for="nombre_noires">Nombre de cartes noires à sélectionner :</label>
        <input type="number" name="nombre_noires" required><br>

        <button type="submit">Créer la partie</button>
    </form>
</body>
</html>
