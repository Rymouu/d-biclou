<?php 
include("./modele/modele.php");

$message_requete = ""; // Variable pour stocker le message de notification

if(isset($_GET['requete'])) { // Vérifie si la requête est présente dans l'URL
    $requete = $_GET['requete']; // Récupère la requête SQL
    $resultat = mysqli_query($connexion, $requete); 

    if ($resultat === null) {
        $message_requete = "Erreur lors de l'exécution de la requête : " . mysqli_error($connexion);
    } elseif (mysqli_num_rows($resultat) == 0) {
        $message_requete = "La requête n'a pas de résultat.";
    } 
}

include ("./vues/requete_vue.php");
?>
