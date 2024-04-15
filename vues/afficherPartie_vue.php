<main>
    <div class="panneau">
        <!-- Formulaire pour sélectionner le mode d'affichage des parties terminées -->
        <form action="./controleurs/afficherPartie_controleur.php" method="post">
            <label for="mode_affichage">Mode d'affichage :</label>
            <select name="mode_affichage" id="mode_affichage">
                <option value="toutes">Toutes les parties</option>
                <option value="50_recentes">Les 50 parties les plus récentes</option>
                <option value="50_plus_rapides">Les 50 parties plus rapides par taille de plateau</option>
            </select>
            <button type="submit">Appliquer</button>
        </form>

        <!-- Bloc permettant d'afficher les parties à venir-->
        <div>
            <h2>Parties à venir</h2>
            <?php if (!empty($partiesAVenir)) : ?>
                <ul>
                    <?php foreach ($partiesAVenir as $partie): ?>
                        <li>
                            <!-- Affichage des détails de la partie-->
                            <?= $partie['Partie_ID'] ?> - <?= $partie['Date_Debut'] ?> <?= $partie['Heure_Debut'] ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p>Aucune partie à venir.</p>
            <?php endif; ?>
        </div>

        <!-- Bloc pour afficher les parties en cours -->
        <div>
            <h2>Parties en cours</h2>
            <?php if (!empty($partiesEnCours)) : ?>
                <ul>
                    <?php foreach ($partiesEnCours as $partie): ?>
                        <li>
                            <!-- Affichage des détails de la partie -->
                            <?= $partie['Partie_ID'] ?> - <?= $partie['Date_Debut'] ?> <?= $partie['Heure_Debut'] ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p>Aucune partie en cours.</p>
            <?php endif; ?>
        </div>
    </div>
</main>
