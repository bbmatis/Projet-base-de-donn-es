<h1>Tableau de Bord pour le suivi d'un projet.</h1>

<form method="post">
    <label for="enseignant">Je suis : </label>
    <select name="idEns" id="enseignant">
        <option value="">Choisir un enseignant</option>
        <?php foreach($listeEns as $ens) { ?>
        <option value="<?=$ens['idEns']?>" <?=$idEns && $ens['idEns'] == $idEns ? 'selected' : '' ?>><?=$ens['prenomEns']." ".$ens['nomEns']?></option>
        <?php } ?>
    </select>

    <?php if($idEns) { ?>
        <br>
        <label for="projet">Je regarde :</label>
        <select name="projet" id="projet">
            <option value="">Choisir un projet</option>
            <?php foreach($listeProj as $projet) { ?>
            <option value="<?=$projet['idProj']?>" <?=$idProj && $projet['idProj'] == $idProj ? 'selected' : '' ?>><?=$projet['nomProj']?></option>
            <?php } ?>
        </select>
    <?php } ?>
    <input type="submit" value="Charger"/>
    
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
                <?php foreach($jalons as $jalon) { ?>
                <tr>
                    <td><?=$jalon['dateLimiteJal']?></td>
                    <td><?=$jalon['typeJal']?></td>
                    <td><?=$jalon['nbRendus']?>/<?=$nbEquipes?></td>
                </tr>
                <?php } ?>
        </table>
    <?php } ?>

</form>