<?php

    $idEquipe = false;
    $idProjet = false;
    $typeRendu = false;

    // On vérifie les GET
    if (isset($_GET['idEquipe'])) $idEquipe = $_GET['idEquipe'];
    if (isset($_GET['idProjet'])) $idProjet = $_GET['idProjet'];

    // On vérifie les POST
    if (isset($_POST['idEquipe'])) $idEquipe = $_POST['idEquipe'];
    if (isset($_POST['idProjet'])) $idProjet = $_POST['idProjet'];

    if (isset($_GET['idEquipe']) && isset($_POST['idEquipe']) && $_GET['idEquipe'] != $_POST['idEquipe']) {
        header('Location: index.php?page=rendu&idEquipe='.$_POST['idEquipe']);
    }

    // Si il y as eu une modification de rendu
    if (isset($_POST['rendu']) && isset($_POST['idJalon'])) {
        // On met a jour le rendu dans la base de données
        updateRendu($_POST['idJalon'], $idEquipe, $_POST['rendu']);
    }

    // On récupère la liste des équipes
    $listeEquipes = getEquipes();

    // Si une équipe a été sélectionnée
    if (!$idEquipe) return;

    // On récupère la liste des projets de cette équipe
    $listeProjets = getProjetsEquipe($idEquipe);

    // Si un projet a été sélectionné et qu'il est dans la liste des projets de cette équipe
    if (!$idProjet || !in_array($idProjet, array_column($listeProjets, 'idProj'))) {
        $idProjet = false;
        return;
    }

    // On récupère les infos du projet
    $infoProj = getProjetInfo($idProjet);

    // On récupère la liste des jalons du projet
    $listeJalons = getJalonsProjet($idProjet);

    // On récupère la liste des rendu fait par l'équipe pour le projet
    $listeRendu = getRenduEquipeProjet($idEquipe, $idProjet);

    if (!isset($_GET['rendu']) || $_GET['rendu'] != 'true' || !isset($_GET['idJalon'])) return;

    // On determine le type de rendu d'après la liste de jalons et l'idJal
    $typeRendu = getTypeRendu($listeJalons, $_GET['idJalon']);

    if (!$typeRendu) return;

    // On cherche la valeur du rendu si il as déjà été fait 
    $valueRendu = getValueRendu($listeRendu, $_GET['idJalon']);