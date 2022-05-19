<h1>Tableau de gestions des rendus par équipes.</h1>

    <form method="post">
        <label for="equipe">Je fait parti de : </label>
        <select name="idEquipe" id="equipe">
            <option>Choisir une équipe</option>
            <?php foreach($listeEquipes as $equipe) { ?>
                <option value="<?=$equipe['idEquipe']?>" <?=isset($idEquipe) && $equipe['idEquipe'] == $idEquipe ? 'selected' : '' ?>><?=$equipe['nomEquipe']?></option>
            <?php } ?>
        </select>

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

    <?php if($idEquipe && $idProjet) { ?>
        <h2>Projet : <?=$infoProj['nomProj']?></h2>
        <h3>Jalons :</h3>
        <table>
            <tr>
                <th>Type</th>
                <th>Date limite</th>
                <th>Etat</th>
                <th>Action</th>
            </tr>
            <?php for ($i = 0; $i < count($listeJalons); $i ++){
                $jalon = $listeJalons[$i];
                $rendu = $listeRendu[$i]['rendu'];
                $date = date('Y-m-d');
                echo "{$jalon['reportDateLimiteJal']} < $date";
                if ($rendu) {
                    $etat = '<span style="color: green;">Rendu</span>';
                } else if ($jalon['reportDateLimiteJal'] < date("Y-m-d")) {
                    $etat = '<span style="color: red;">En Retard</span>';
                }else {
                    $etat = '<span style="color: blue;">A rendre</span>';
                }
                ?>
                <tr>
                    <td><?=$jalon['typeJal']?></td>
                    <td><?=$jalon['reportDateLimiteJal']?></td>
                    <td><?=$etat?></td>
                    <td><a href="?page=rendu&idEquipe=<?=$idEquipe?>&idProj=<?=$idProjet?>&jalon=<?=$jalon['idJal']?>"><?=!$rendu ? 'Rendre' : 'Modifier' ?> le jalon</a></td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>
