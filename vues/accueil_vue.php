<?php
// Inclure le contrôleur des statistiques
include __DIR__ . '/../controleurs/statistiques_controleur.php';

// Récupérer les statistiques
$stats = obtenir_statistiques();
?>

<main>
    <p class="accueil_description accueil_auteurs">Bienvenue sur notre site !<br></p>
    
    <p id="cadre_description" class="accueil_description">
        Ce site a été réalisé dans le cadre de l'UE Base de données et programmation web.<br>
        Il s'agit d'une application web pour un jeu de dés inspiré du jeu DICYCLE RACE. Chaque joueur incarne un cycliste et doit atteindre la ligne d'arrivée en parcourant un trajet composé de 12 cartes. Pour avancer, le joueur doit réaliser des combinaisons de dés spécifiques. Il dispose de 6 dés bleus, 6 dés jaunes et 6 dés rouges, et doit choisir 6 dés à chaque tour pour tenter de valider une ou plusieurs cases en au plus 3 lancers. Différentes stratégies peuvent être utilisées en fonction du nombre de cartes que le joueur souhaite valider en un tour.
    </p>

    <a href="afficherPartie_vue.php">Afficher les parties</a>

    <div class="panneau">
        <div> <!-- Bloc permettant d'afficher les statistiques -->
            <h2>Statistiques de la base</h2>
            <table class="table_resultat">
                <thead>
                    <tr>
                        <th>Propriétés</th>
                        <th>Valeur</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Nombre de joueurs</td><td><?= $stats['nb_joueurs'] ?></td></tr>
                    <tr><td>Nombre d'équipes</td><td><?= $stats['nb_equipes'] ?></td></tr>
                    <tr><td>Nombre de classements</td><td><?= $stats['nb_classements'] ?></td></tr>
                    <tr><td>Nombre de tournois</td><td><?= $stats['nb_tournois'] ?></td></tr>
                    <tr><td>Moyenne de joueurs par tournoi</td><td><?= $stats['moyenne_joueurs_par_tournois'] ?></td></tr>
                </tbody>
            </table>
            
            <!-- Nouvelles statistiques -->
            <h2>Statistiques supplémentaires</h2>
            <table class="table_resultat">
                <thead>
                    <tr>
                        <th>Propriétés</th>
                        <th>Valeur</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Nombre de phases de tournoi qualifiées</td><td><?= count($stats['phases_tournoi']) ?></td></tr>
                    <tr><td>Nombre d'équipes classées premières sans membres classés individuellement</td><td><?= $stats['nb_equipes_premieres'] ?></td></tr>
                    <tr><td>Nombre moyen de participants aux tournois (pour les 3 dernières années)</td><td><?= $stats['nb_moyen_participants'] ?></td></tr>
                </tbody>
            </table>
            
            <h3>Joueurs classés individuellement dans le top 5 d'au moins 2 classements nationaux</h3>
            <ul>
                <?php foreach ($stats['top_joueurs'] as $joueur) : ?>
                    <li><?= $joueur['Nom'] . ' ' . $joueur['Prenom'] ?></li>
                <?php endforeach; ?>
            </ul>
            
            <h3>Nombre de parties jouées pour chaque taille de plateau</h3>
            <table class="table_resultat">
                <thead>
                    <tr>
                        <th>Taille de plateau</th>
                        <th>Nombre de parties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stats['parties_par_taille_plateau'] as $taille) : ?>
                        <tr>
                            <td><?= $taille['Nombre_Cartes'] ?> cartes</td>
                            <td><?= $taille['Nombre_Parties'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <h3>Top 5 des joueurs ayant joué le plus de parties</h3>
            <ol>
                <?php foreach ($stats['top_joueurs_parties'] as $joueur_parties) : ?>
                    <li><?= $joueur_parties['Nom'] . ' ' . $joueur_parties['Prenom'] ?></li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
    
</main>
