<?php
    $idEquipe = false;
    $idProjet = false;
    // On vérifie les GET
    if (isset($_GET['idEquipe'])) $idEquipe = $_GET['idEquipe'];
    if (isset($_GET['idProjet'])) $idProjet = $_GET['idProjet'];

    // On vérifie les POST
    if (isset($_POST['idEquipe'])) $idEquipe = $_POST['idEquipe'];
    if (isset($_POST['idProjet'])) $idProjet = $_POST['idProjet'];

    // On récupère la liste des équipes
    $listeEquipes = getEquipes();
    echo $idEquipe;
    echo $idProjet;

    // Si une équipe a été sélectionnée
    if (!$idEquipe) return;

    // On récupère la liste des projets de cette équipe
    $listeProjets = getProjetsEquipe($idEquipe);

    // Si un projet a été sélectionné
    if (!$idProjet) return;

    // On récupère les infos du projet
    $infoProj = getProjetInfo($idProjet);

    // On récupère la liste des jalons du projet
    $listeJalons = getJalonsProjet($idProjet);

    // On récupère la liste des rendu fait par l'équipe pour le projet
    $listeRendu = getRenduEquipeProjet($idEquipe, $idProjet);