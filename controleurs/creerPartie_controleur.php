<?php
// Inclure le fichier de configuration de la base de données
require_once("./modele/modele.php");

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nombreCartes = $_POST["nombre_cartes"];
    $nombreVertes = $_POST["nombre_vertes"];
    $nombreOranges = $_POST["nombre_oranges"];
    $nombreNoires = $_POST["nombre_noires"];

    // Appeler une fonction pour créer la partie en base de données
    creerPartie($nombreCartes, $nombreVertes, $nombreOranges, $nombreNoires);
    
    // Rediriger l'utilisateur vers une autre page ou afficher un message de succès
    // Exemple : header("Location: creerPartie_succes.php");
    exit(); // Arrêter l'exécution du script après le traitement du formulaire
}

// Afficher la vue associée
include("./vues/creerPartie_vue.php");
?>
