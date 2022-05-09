<?php
    $idEns = false;
    $idProj = false;

    // On récupère la liste des enseignants
    $listeEns = getEnseignants();

    // On regarde si un enseignant a été sélectionné
    if (!isset($_POST['idEns']) || $_POST['idEns'] == '') return;

    // On note l'enseignant sélectionné
    $idEns = $_POST['idEns'];

    // On récupère la liste des projets pour l'enseignant sélectionné
    $listeProj = getEnsProjets($idEns);

    // On regarde si un projet a été sélectionné
    if (!isset($_POST['projet']) || $_POST['projet'] == '') return;

    // On note le projet sélectionné
    $idProj = $_POST['projet'];

    // On récupère le nombre d'équipes encafrées par l'enseignant qui participent au projet sélectionné
    $equipes = getEquipes($idEns, $idProj);
    $nbEquipes = count($equipes);
    $jalonsInfo = getJalonsInfoProj($idEns, $idProj);

    // On récupère la liste des jalons rendus par les équipes
    $jalonsRendusParEquipe = array();
    foreach ($equipes as $equipe) {
        $jalonsRendusParEquipe[$equipe['nomEquipe']] = array();
        $jalonsEquipe = getEquipeJalon($idProj, $equipe['idEquipe']);
        foreach ($jalonsEquipe as $jalon) {
            $jalonsRendusParEquipe[$equipe['nomEquipe']]["Jalon_".$jalon['idJal']] = $jalon;
        }
    }

