<h1>Tableau de Bord pour le suivi d'un projet.</h1>

<form method="post">
    <!-- Selection de l'enseignant -->
    <label for="enseignant">Je suis : </label>
    <select name="idEns" id="enseignant">
        <option>Choisir un enseignant</option>
        <?php foreach($listeEns as $ens) { ?>
        <option value="<?=$ens['idEns']?>" <?=$idEns && $ens['idEns'] == $idEns ? 'selected' : '' ?>><?=$ens['prenomEns']." ".$ens['nomEns']?></option>
        <?php } ?>
    </select>

    <?php if($idEns) { ?>
        <br>
        <!-- Selection du projet -->
        <label for="projet">Je regarde :</label>
        <select name="projet" id="projet">
            <option value="">Choisir un projet</option>
            <?php foreach($listeProj as $projet) { ?>
            <option value="<?=$projet['idProj']?>" <?=$idProj && $projet['idProj'] == $idProj ? 'selected' : '' ?>><?=$projet['nomProj']?></option>
            <?php } ?>
        </select>
    <?php } ?>
    <input type="submit" value="Charger"/>
    <!-- Affichage des infos du projet -->
    <?php if($idProj && $nbEquipes > 0) { ?>
        <br>
        <p>Vous encadrez <?=$nbEquipes?> Équipes sur ce projet.</p>
        <h4>Liste des jalons sur le projet</h4>
        <table>
            <thead>
                <tr>
                    <th>Date limite</th>
                    <th>Type</th>
                    <th>Rendus</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($jalonsInfo as $jalon) { ?>
                <tr>
                    <td><?=$jalon['dateLimiteJal']?></td>
                    <td><?=$jalon['typeJal']?></td>
                    <td><?=$jalon['nbRendus']?>/<?=$nbEquipes?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- Affichage des infos sur les équipes encadrées -->
        <h4>Liste des équipes encadrées</h4>
        <table>
            <thead>
                <tr>
                    <th>Nom de l'équipe</th>
                    <!-- On affiche la liste des jalons -->
                    <?php for ($i = 0; $i < count($jalonsInfo); $i++) { ?>
                        <th>Jalon <?=$i+1?> (Limite : <?=$jalonsInfo[$i]['dateLimiteJal']?>)</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
            <?php 
                foreach($equipes as $equipe) { 
            ?>
                <tr>
                    <td><?=$equipe['nomEquipe']?></td>
                    <!-- On affiche la liste des jalons -->
                    <?php 
                        $jalonsRendu = $jalonsRendusParEquipe[$equipe['nomEquipe']];
                        foreach ($jalonsInfo as $jalon) { ?>
                    <td>
                    <?php  if(isset($jalonsRendu["Jalon_".$jalon['idJal']])) { ?>
                            <span style="color:green">Rendu </span>
                    <?php  } else {
                            if($jalon['dateLimiteJal'] < date("Y-m-d")) { ?>
                            <span style="color:red">Non rendu à temps</span>
                        <?php } else { ?>
                            <span style="color:orange">Attendu</span>
                        <?php } ?>
                    <?php } ?>
                        
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
            </tbody>
        </table>

    <?php } ?>

</form>