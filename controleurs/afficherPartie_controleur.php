<?php
require_once('./modele/modele.php');


// Fonction pour récupérer la liste des parties à venir
function getPartiesAVenir() {
    global $connexion;

    // Requête SQL pour récupérer les parties à venir en utilisant Date_Debut
    $requete = "SELECT * FROM PARTIE WHERE Date_Debut > NOW()";

    $res = mysqli_query($connexion, $requete);
    $partiesAVenir = mysqli_fetch_all($res, MYSQLI_ASSOC);

    return $partiesAVenir;
}

// Fonction pour récupérer les parties en cours
function getPartiesEnCours() {
    global $connexion;

    // Requête SQL pour récupérer les parties en cours en utilisant Date_Debut
    $requete = "SELECT * FROM PARTIE WHERE Date_Debut <= NOW()";

    $res = mysqli_query($connexion, $requete);
    $partiesEnCours = mysqli_fetch_all($res, MYSQLI_ASSOC);

    return $partiesEnCours;
}

// Fonction pour récupérer les parties terminées selon le mode d'affichage sélectionné
function getPartiesTerminees($modeAffichage) {
    global $connexion;

    // Variable pour stocker la requête SQL
    $requete = "";

    // Déterminer la requête SQL en fonction du mode d'affichage
    switch ($modeAffichage) {
        case '50_recentes':
            $requete = "SELECT Partie_ID, Duree FROM PARTIE WHERE Date_Debut <= NOW() ORDER BY Date_Debut DESC LIMIT 50";
            break;
        case '50_plus_rapides':
            $requete = "SELECT Partie_ID, Duree FROM PARTIE WHERE Date_Debut <= NOW() ORDER BY Duree ASC LIMIT 50";
            break;
        default:
            $requete = "SELECT * FROM PARTIE";
    }

    // Exécuter la requête SQL
    $res = mysqli_query($connexion, $requete);
    $partiesTerminees = mysqli_fetch_all($res, MYSQLI_ASSOC);

    return $partiesTerminees;
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si le mode d'affichage est défini dans les données POST
    if (isset($_POST["mode_affichage"])) {
        // Récupérer le mode d'affichage sélectionné
        $modeAffichage = $_POST["mode_affichage"];

        // Récupérer les parties terminées en fonction du mode d'affichage sélectionné
        $partiesTerminees = getPartiesTerminees($modeAffichage);

        // Afficher la vue associée avec les parties terminées
        include("./vues/afficherPartie_vue.php");
        exit(); // Arrêter l'exécution du script après l'affichage des parties terminées
    }
}

// Si le formulaire n'a pas été soumis ou si le mode d'affichage n'est pas défini, afficher les parties à venir par défaut
$partiesAVenir = getPartiesAVenir();
$partiesEnCours = getPartiesEnCours();
include("./vues/afficherPartie_vue.php");
?>
