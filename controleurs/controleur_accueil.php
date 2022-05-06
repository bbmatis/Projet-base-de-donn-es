<?php
    // On récupère la liste des projets
    $listeProj = getProjetActif();

    // On récupère le nombre d'UE acceptant plus de 2 étudiants par équipes
    $nbUEEquipePlusDe2 = getnbUEEquipePlusDe2();

    // On récupère l'ue qui as présenté le plus de projets
    $ueProjetPlus = getUEProjetPlus();

    // On récupère l'enseignant qui as encadré le plus de projets
    $ensProjetEncadrerPlus = getEnsProjetEncadrerPlus();

    // On récupère la liste des étudiants qui ont eu la meilleure note dans chaque UE
    $listeEtudiantMeilleurNote = getEleveBestNotesByUE();
    
