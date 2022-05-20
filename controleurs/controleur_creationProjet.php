<?php 
    session_start(); // Pour garder les infos du projet que l'ont est entrain de créer
    $idEns = false;
    $creationProjet = false;
    $nbEtapes = 5;

    if (!isset($_SESSION['etapeCreation'])) $_SESSION['etapeCreation'] = 1;
    $etape = $_SESSION['etapeCreation'];

    // On récupère la liste des responsables d'ue
    $listeResponsablesUe = getResponsablesUe();

    $isPost = isset($_POST['idEns']);
    $isSession = isset($_SESSION['idEns']);
    // Si ni post ni session, on return
    if (!$isPost && !$isSession) return;

    if (isset($_POST['idEns'])) {
        $idEns = $_POST['idEns'];
        $_SESSION['idEns'] = $idEns;
    } else {
        $idEns = $_SESSION['idEns'];
    }

    if (!$idEns || $idEns == "") return;

    $creationProjet = true; // Pour afficher le formulaire de création de projet

    // On met par défaut a false les valeurs du formulaire
    $nomProjet = false;
    $descriptionProjet = false;
    $lienDuSujet = false;
    $codeUe = false;
    $listeEnseignantsEncadrants = array();
    $nbEtudiantsParEquipe = 1;
    $listeJalonsProjet = array();

    // la liste des valeur des champs du formulaire
    $valueToCheck = array('nomProjet', 'descriptionProjet', 'lienDuSujet', 'codeUe', 'listeEnseignantsEncadrants', 'nbEtudiantsParEquipe', 'listeJalonsProjet');

    // On récupère les valeurs à checker
    foreach ($valueToCheck as $value) {
        if (isset($_POST[$value])) {
            $$value = $_POST[$value];
            $_SESSION[$value] = $$value;
        }else if (isset($_SESSION[$value])) {
            $$value = $_SESSION[$value];
        }
    }

    // Si on passe a l'étape suivante
    if (isset($_POST['nextStep']) && $etape < $nbEtapes) {
        $etape++;
        $_SESSION['etapeCreation'] = $etape;
    }

    // Si on passe a l'étape précédente
    if (isset($_POST['previousStep']) && $etape > 1) {
        $etape--;
        $_SESSION['etapeCreation'] = $etape;
    }

    if ($etape == 1) {
        // Récupère la liste des ue
        $listeUe = getUe();
    }else if ($etape == 2) {
        // On récupère la liste des enseignants
        $listeEnseignants = getEnseignants();

        // Pour ajouter un enseignant à la liste des enseignants encadrants
        if (isset($_POST['addEnseignant']) && isset($_POST['enseignantToAdd']) && $_POST['enseignantToAdd'] != "") {
            // On ajoute un enseignant à la liste des enseignants
            // Si il n'est pas déjà dans la liste
            if (!in_array($_POST['enseignantToAdd'], $listeEnseignantsEncadrants)) {
                $listeEnseignantsEncadrants[] = $_POST['enseignantToAdd'];
                $_SESSION['listeEnseignantsEncadrants'] = $listeEnseignantsEncadrants;
            }
        }

        // Pour supprimer un enseignant de la liste des enseignants encadrants
        if (isset($_POST['remove'])) {
            $idEnsToRemove = explode(' ', $_POST['remove'])[2];
            $listeEnseignantsEncadrants = array_diff($listeEnseignantsEncadrants, array($idEnsToRemove));
            $_SESSION['listeEnseignantsEncadrants'] = $listeEnseignantsEncadrants;
        }
    }else if ($etape == 3) {
        // On récupère le nombre d'étudiants qui suivent l'UE
        $nbEtudiants = getNbEtudiant($codeUe);
    }else if ($etape == 4) {
        // On récupère la liste des jalons 
        $listeJalons = getJalons();

        // Pour ajouter un jalon a la liste des jalons
        if (isset($_POST['addJalon']) && isset($_POST['jalonToAdd']) && $_POST['jalonToAdd'] != "") {
            // On ajoute un jalon à la liste des jalons
            // Si il n'est pas déjà dans la liste
            if (!in_array($_POST['jalonToAdd'], $listeJalonsProjet)) {
                $listeJalonsProjet[] = $_POST['jalonToAdd'];
                $_SESSION['listeJalonsProjet'] = $listeJalonsProjet;
            }
        }

        // Pour supprimer un jalon de la liste des jalons
        if (isset($_POST['remove'])) {
            $idJalonToRemove = explode(' ', $_POST['remove'])[3];
            echo $idJalonToRemove;
            $listeJalonsProjet = array_diff($listeJalonsProjet, array($idJalonToRemove));
            $_SESSION['listeJalonsProjet'] = $listeJalonsProjet;
        }
    }else if ($etape == 5) {
        // On récupère la liste des enseignants
        $listeEnseignants = getEnseignants();

        // On récupère le nombre d'étudiants qui suivent l'UE
        $nbEtudiants = getNbEtudiant($codeUe);

        // On récupère la liste des jalons 
        $listeJalons = getJalons();
    }