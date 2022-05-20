<h1>Tableau de gestions des rendus par équipes.</h1>

    <form method="post">
        
        <!-- On sélectionne l'équipe -->

        <label for="equipe">Je fait parti de : </label>
        <select name="idEquipe" id="equipe">
            <option>Choisir une équipe</option>
            <?php foreach($listeEquipes as $equipe) { ?>
                <option value="<?=$equipe['idEquipe']?>" <?=isset($idEquipe) && $equipe['idEquipe'] == $idEquipe ? 'selected' : '' ?>><?=$equipe['nomEquipe']?></option>
            <?php } ?>
        </select>

        <!-- On sélectionne le projet -->
        
        <?php if($idEquipe) { ?>
            <br>
            <label for="projet">Projet :</label>
            <select name="idProjet" id="projet">
                <option value="">Choisir un projet</option>
                <?php foreach($listeProjets as $projet) { ?>
                    <option value="<?=$projet['idProj']?>" <?=isset($idProjet) && $projet['idProj'] == $idProjet ? 'selected' : '' ?>><?=$projet['nomProj']?></option>
                <?php } ?>
            </select>
        <?php } ?>
        <input type="submit" value="Charger"/>
    </from>

    <!-- On affiche la liste des jalons et les infos -->

    <?php if($idEquipe && $idProjet) { ?>
        <h2><u><?=$infoProj['nomProj']?></u> : </h2>
        <h4>Info du projet :</h4>

        <p>
            Année : <strong><?=$infoProj['anneeProj']?> (<?=$infoProj['semestreProj']?>)</strong><br>
            Description : <strong><?=$infoProj['resumeProj'] ? $infoProj['resumeProj'] : "Pas de description"?></strong><br>
            Etat : <strong><?=$infoProj['etatProj']?></strong><br>
            UE : <strong><?=$infoProj['codeApoge']?></strong><br>


        </p>
        <h3>Jalons :</h3>
        <table>
            <tr>
                <th>Id</th>
                <th>Type</th>
                <th>Date limite</th>
                <th>Etat</th>
                <th>Action</th>
            </tr>
            <?php for ($i = 0; $i < count($listeJalons); $i ++){
                $jalon = $listeJalons[$i];
                $rendu = $listeRendu[$i]['estRendu'];
                if ($rendu) {
                    $etat = '<span style="color: green;">Rendu</span>';
                } else if ($jalon['reportDateLimiteJal'] < date("Y-m-d")) {
                    $etat = '<span style="color: red;">En Retard</span>';
                }else {
                    $etat = '<span style="color: blue;">A rendre</span>';
                }
                ?>
                <tr>
                    <td><?=$jalon['idJal']?></td>
                    <td><?=$jalon['typeJal']?></td>
                    <td><?=$jalon['reportDateLimiteJal']?></td>
                    <td><?=$etat?></td>
                    <td>
                        <?php if ($jalon['typeJal'] == 'Soutenance Finale') {
                            echo '<span style="color: blue;">Soutenance</span>';
                        }else {
                            ?>
                                <a href="?page=depotRendu&idEquipe=<?=$idEquipe?>&idProjet=<?=$idProjet?>&idJalon=<?=$jalon['idJal']?>&rendu=true#renduEncre"><?=!$rendu ? 'Déposer' : 'Modifier' ?> le rendu</a></td>
                            <?php
                        }
                        ?>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>

    <!-- On fait le rendu d'un jalon -->

    <?php if ($typeRendu) { 
            ?>
            <!-- Une ancre pour le rendu -->
            <a name="renduEncre"></a>
            <h2 >Rendu de "<?=$typeRendu?>" :</h2>
            <form method="post">
                <label for="rendu">Rendu : </label><br>
                <?php if ($typeRendu == "Revue de code") { ?>
                <input type="file" id="rendu" name="rendu">
                <?php } else { ?>
                <textarea id="rendu" name="rendu" rows="10" cols="50"><?=$valueRendu ?></textarea>
                <?php } ?>
                <br>
                <input type="hidden" value="<?=$_GET['idJalon']?>" name="idJalon"/>
                <input type="submit" value="Envoyer"/>
            </form>
    <?php } ?>
