<h1>Création de projets</h1>

<!-- Selection de l'enseigant -->
<form method="POST">
    <label for="enseignant">Je suis : </label>
    <select name="idEns" id="enseignant">
        <option value="">Choisir un responsable</option>
        <?php foreach($listeResponsablesUe as $ens) { ?>
        <option value="<?=$ens['idEns']?>" <?=$idEns && $ens['idEns'] == $idEns ? 'selected' : '' ?>><?=$ens['prenomEns']." ".$ens['nomEns']?></option>
        <?php } ?>
    </select>
    <input type="submit" value="Valider">
    <a href="?page=creationProjet&notResp=true">(Je ne suis pas dans la liste)</a>
</form>

<!-- Création d'un projet -->

    <?php if($creationProjet) { ?>

    <form method="POST">
        <h4>Etape <?=$etape?>/<?=$nbEtapes?></h4>
        <?php if ($etape == 1) { ?>
            <h4>Info du projet</h4>
        <table>
            <tr>
                <td><label for="nomProjet">Nom du projet : </label></td>
                <td><input type="text" name="nomProjet" id="nomProjet" value="<?=$nomProjet?>"></td>
            </tr>
            <tr>
                <td><label for="descriptionProjet">Description du projet : </label></td>
                <td><textarea name="descriptionProjet" id="descriptionProjet" cols="30" rows="10"><?=$descriptionProjet?></textarea></td>
            </tr>
            <tr>
                <td><label for="lienDuSujet">Lien du sujet : </label></td>
                <td><input type="text" name="lienDuSujet" id="lienDuSujet" value="<?=$lienDuSujet?>"></td>
            </tr>
            <tr>
                <td><label for="ue">Ue : </label></td>
                <td>
                    <select name="codeUe" id="ue">
                        <option value="">Choisir une UE</option>
                        <?php foreach($listeUe as $ue) { ?>
                        <option value="<?=$ue['codeAPOGEE']?>" <?=$codeUe && $ue['codeAPOGEE'] == $codeUe ? 'selected' : '' ?>><?=$ue['codeAPOGEE']?></option>
                        <?php } ?>
                    </select>
                </td>
        </table>
        <?php } else if ($etape == 2) { ?>
            <!-- Selection des enseignants qui vont encadrer -->
            <h4>Equipe pédagogique</h4>
            <!-- Liste des enseignants déjà selectionné -->
            <?php foreach ($listeEnseignantsEncadrants as $ens) { 
                $famosoEnseignant = $listeEnseignants[array_search($ens, array_column($listeEnseignants, 'idEns'))]; 
                ?>
                <span> <?=$famosoEnseignant['prenomEns']." ".$famosoEnseignant['nomEns']?> <input type="submit" name="remove" value="Retirer l'enseignant <?=$famosoEnseignant['idEns']?>" ></span><br>
            <?php } ?>
            <select name="enseignantToAdd" id="enseignant">
                <option value="">Choisir un enseignant</option>
                <?php foreach($listeEnseignants as $ens) { 
                    if (in_array($ens['idEns'], $listeEnseignantsEncadrants)) continue;
                    ?>
                <option value="<?=$ens['idEns']?>"><?=$ens['prenomEns']." ".$ens['nomEns']?></option>
                <?php } ?>
            </select>
            <input type="submit" name="addEnseignant" value="Ajouter l'enseignant">

        <?php }else if ($etape == 3) { ?>
            <!-- Génération des équipes -->
            <h4>Génération des équipes</h4>
            Il y as <?=count($listeEnseignantsEncadrants)?> enseignants encadrants pour <?=$nbEtudiants?> étudiants.<br>
            <label for="nbEtudiantsParEquipe">Nombre d'étudiants par équipe : </label><input name="nbEtudiantsParEquipe" type="number" min="1" max="8" value="<?=$nbEtudiantsParEquipe?>">
        <?php }else if ($etape == 4) {?>
            <!-- Gestion des jalons -->
            <h4>Gestion des jalons</h4>
            <!-- Liste des jalond déjà selectionné -->
            <?php foreach ($listeJalonsProjet as $jal) { 
                $famosoJalon = $listeJalons[array_search($jal, array_column($listeJalons, 'idJal'))]; 
                ?>
                <span> <?=$famosoJalon['typeJal']." ".$famosoJalon['reportDateLimiteJal']?> <input type="submit" name="remove" value="Retirer le jalon <?=$famosoJalon['idJal']?>" ></span><br>
            <?php } ?>
            <!-- Liste des jalons dispo -->
            <select name="jalonToAdd">
                <?php foreach ($listeJalons as $jalon) {
                        if (in_array($jalon['idJal'], $listeJalonsProjet)) continue;
                        ?>
                    <option value="<?=$jalon['idJal']?>"><?=$jalon['typeJal']?> <?=$jalon['reportDateLimiteJal']?></option>
                <?php } ?>
            </select>
            <input type="submit" name="addJalon" value="Ajouter le Jalon">
        <?php }else if ($etape == 5) { ?>
            <h4>Récapitulatif</h4>
            <table>
                <tr>
                    <td><label for="nomProjet">Nom du projet : </label></td>
                    <td><?=$nomProjet?></td>
                </tr>
                <tr>
                    <td><label for="descriptionProjet">Description du projet : </label></td>
                    <td><?=$descriptionProjet?></td>
                </tr>
                <tr>
                    <td><label for="lienDuSujet">Lien du sujet : </label></td>
                    <td><?=$lienDuSujet?></td>
                </tr>
                <tr>
                    <td><label for="ue">Ue : </label></td>
                    <td><?=$codeUe?></td>
                </tr>
                <tr>
                    <td><label for="nbEtudiantsParEquipe">Nombre d'étudiants par équipe : </label></td>
                    <td><?=$nbEtudiantsParEquipe?> soit <?=$nbEtudiants/$nbEtudiantsParEquipe?> equipes.</td>
                </tr>
                <tr>
                    <td>Encadrants</td>
                    <td>
                        <?php foreach ($listeEnseignantsEncadrants as $ens) { 
                            $famosoEnseignant = $listeEnseignants[array_search($ens, array_column($listeEnseignants, 'idEns'))]; 
                            ?>
                            <span> <?=$famosoEnseignant['prenomEns']." ".$famosoEnseignant['nomEns']?> </span><br>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Jalons</td>
                    <td>
                        <?php foreach ($listeJalonsProjet as $jal) { 
                            $famosoJalon = $listeJalons[array_search($jal, array_column($listeJalons, 'idJal'))]; 
                            ?>
                            <span> <?=$famosoJalon['typeJal']." ".$famosoJalon['reportDateLimiteJal']?> </span><br>
                        <?php } ?>
                    </td>
                </tr>
            </table>

            <input type="submit" name="submit" value="Générer le projet">
        <?php } ?>
        <br>
        <?php if ($etape > 1) { ?>
            <input type="submit" name="previousStep" value="Etape Précédente">
        <?php } ?>

        <?php if ($etape < $nbEtapes) { ?>
            <input type="submit" name="nextStep" value="Etape suivante">
        <?php } ?>
    </form>

    <?php } ?>