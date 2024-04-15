<?php
// Vérifier si les constantes sont déjà définies
if (!defined('SERVEUR')) {
    // Inclure les constantes de connexion
    include __DIR__ . '/../inc/config-bd.php';
}

// Fonction pour récupérer les statistiques depuis la base de données
function obtenir_statistiques() {
    // Connexion à la base de données
    $bdd = new PDO('mysql:host=' . SERVEUR . ';dbname=' . BDD . ';charset=utf8', UTILISATEUR, MOTDEPASSE);

    // Tableau pour stocker les statistiques
    $stats = array();

    // Requête SQL pour récupérer le nombre de joueurs
    $requete_nb_joueurs = "SELECT count(*) AS nb_joueurs FROM JOUEUR";
    $resultat_nb_joueurs = $bdd->query($requete_nb_joueurs);
    $stats['nb_joueurs'] = $resultat_nb_joueurs->fetch(PDO::FETCH_ASSOC)['nb_joueurs'];

    // Requête SQL pour récupérer le nombre d'équipes
    $requete_nb_equipes = "SELECT count(*) AS nb_equipes FROM EQUIPE";
    $resultat_nb_equipes = $bdd->query($requete_nb_equipes);
    $stats['nb_equipes'] = $resultat_nb_equipes->fetch(PDO::FETCH_ASSOC)['nb_equipes'];

    // Requête SQL pour récupérer le nombre de classements
    $requete_nb_classements = "SELECT count(*) AS nb_classements FROM CLASSEMENT";
    $resultat_nb_classements = $bdd->query($requete_nb_classements);
    $stats['nb_classements'] = $resultat_nb_classements->fetch(PDO::FETCH_ASSOC)['nb_classements'];

    // Requête SQL pour récupérer le nombre de tournois
    $requete_nb_tournois = "SELECT count(*) AS nb_tournois FROM TOURNOI";
    $resultat_nb_tournois = $bdd->query($requete_nb_tournois);
    $stats['nb_tournois'] = $resultat_nb_tournois->fetch(PDO::FETCH_ASSOC)['nb_tournois'];

    // Requête SQL pour récupérer la moyenne des joueurs par tournoi
    $requete_moyenne_joueurs_par_tournois = "
        SELECT avg(p.n) AS moyenne_joueurs
        FROM (
            SELECT Tournoi_ID, count(DISTINCT Joueur_ID) AS n
            FROM Participe
            GROUP BY Tournoi_ID
        ) p
    ";
    $resultat_moyenne_joueurs_par_tournois = $bdd->query($requete_moyenne_joueurs_par_tournois);
    $stats['moyenne_joueurs_par_tournois'] = $resultat_moyenne_joueurs_par_tournois->fetch(PDO::FETCH_ASSOC)['moyenne_joueurs'];

    // Requête SQL pour les phases de tournoi
    $requete_phases_tournoi = "
        SELECT t.Nom, year(t.Date_Debut) AS Annee, ph.Niveau
        FROM TOURNOI t
        JOIN PHASE ph ON t.Tournoi_ID = ph.Tournoi_ID
        JOIN Participe pa ON ph.Tournoi_ID = pa.Tournoi_ID AND ph.Niveau = pa.Niveau
        JOIN JOUEUR j ON pa.Joueur_ID = j.Joueur_ID
        WHERE pa.Est_Qualifie AND j.Nom = 'userNom' AND j.Prenom = 'userPrenom'
        ORDER BY year(t.Date_Debut) DESC, ph.Niveau DESC
    ";
    $resultat_phases_tournoi = $bdd->query($requete_phases_tournoi);
    $stats['phases_tournoi'] = $resultat_phases_tournoi->fetchAll(PDO::FETCH_ASSOC);

    // Requête SQL pour le nombre d'équipes classées premières
    $requete_nb_equipes_premieres = "
        SELECT count(e.Equipe_ID) AS nombre_equipes
        FROM EQUIPE e
        JOIN Sont_Classes sc ON e.Equipe_ID = sc.Equipe_ID
        WHERE sc.Rang = 1
        AND NOT EXISTS (
            SELECT *
            FROM JOUEUR j
            JOIN Est_Classe ec ON j.Joueur_ID = ec.Joueur_ID
            WHERE ec.Rang = 1 AND j.Joueur_ID = ec.Joueur_ID
        )
    ";
    $resultat_nb_equipes_premieres = $bdd->query($requete_nb_equipes_premieres);
    $stats['nb_equipes_premieres'] = $resultat_nb_equipes_premieres->fetch(PDO::FETCH_ASSOC)['nombre_equipes'];

    // Requête SQL pour le nombre moyen de participants aux tournois pour les 3 dernières années
    $requete_nb_moyen_participants = "
        SELECT avg(p.n) AS moyenne_participants
        FROM (
            SELECT pa.Tournoi_ID, count(DISTINCT pa.Joueur_ID) AS n
            FROM Participe pa
            JOIN TOURNOI t ON pa.Tournoi_ID = t.Tournoi_ID
            WHERE year(t.Date_Debut) >= (YEAR(CURDATE()) - 3)
            GROUP BY pa.Tournoi_ID
        ) p
    ";
    $resultat_nb_moyen_participants = $bdd->query($requete_nb_moyen_participants);
    $stats['nb_moyen_participants'] = $resultat_nb_moyen_participants->fetch(PDO::FETCH_ASSOC)['moyenne_participants'];

    // Requête SQL pour les joueurs classés individuellement dans le top 5 d'au moins 2 classements de portée nationale
    $requete_top_joueurs = "
        SELECT j.Nom, j.Prenom
        FROM JOUEUR j
        JOIN Est_Classe ci ON j.Joueur_ID = ci.Joueur_ID
        JOIN CLASSEMENT c ON c.Classement_ID = ci.Classement_ID
        WHERE c.Portee = 'nationale' AND ci.Rang <= 5
        GROUP BY j.Nom, j.Prenom, j.Joueur_ID
        HAVING count(DISTINCT ci.Classement_ID) > 2
    ";
    $resultat_top_joueurs = $bdd->query($requete_top_joueurs);
    $stats['top_joueurs'] = $resultat_top_joueurs->fetchAll(PDO::FETCH_ASSOC);

    // Requête SQL pour le nombre de parties jouées pour chaque taille de plateau
    $requete_parties_par_taille_plateau = "
        SELECT P.Nombre_Cartes, count(DISTINCT P.Plateau_ID) AS Nombre_Parties
        FROM PLATEAU P
        GROUP BY P.Nombre_Cartes
    ";
    $resultat_parties_par_taille_plateau = $bdd->query($requete_parties_par_taille_plateau);
    $stats['parties_par_taille_plateau'] = $resultat_parties_par_taille_plateau->fetchAll(PDO::FETCH_ASSOC);

    // Requête SQL pour le top 5 des joueurs ayant joué le plus de parties
    $requete_top_joueurs_parties = "
        SELECT J.Nom, J.Prenom, count(P.Partie_ID) AS Nombre_Parties
        FROM JOUEUR J
        JOIN Joue P ON J.Joueur_ID = P.Joueur_ID
        GROUP BY P.Joueur_ID
        ORDER BY Nombre_Parties DESC
        LIMIT 5
    ";
    $resultat_top_joueurs_parties = $bdd->query($requete_top_joueurs_parties);
    $stats['top_joueurs_parties'] = $resultat_top_joueurs_parties->fetchAll(PDO::FETCH_ASSOC);

    // Fermeture de la connexion
    $bdd = null;

    return $stats;
}
?>
