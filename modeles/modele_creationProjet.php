<?php

    // Récupère la liste des responsables d'ue
    function getResponsablesUe() {
        global $Base;
        $requete = "SELECT DISTINCT e.idEns, e.nomEns, e.prenomEns FROM `EquipePedagogique` resp LEFT JOIN Enseignant e on resp.idEns = e.idEns WHERE resp.`rôle` = 'resp';";
        $resultat = $Base->query($requete);
        $responsables = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $responsables;
    }

    // récupère la liste des ue
    function getUe() {
        global $Base;
        $requete = "SELECT * FROM `UE`;";
        $resultat = $Base->query($requete);
        $ues = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $ues;
    }

    // Récupère la liste des enseignants
    function getEnseignants() {
        global $Base;
        $requete = "SELECT * FROM `Enseignant`;";
        $resultat = $Base->query($requete);
        $enseignants = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $enseignants;
    }

    // Récupère le nombre d'étudiants d'une ue
    function getNbEtudiant($codeUe) {
        global $Base;
        $requete = "SELECT COUNT(*) FROM `Suivre` WHERE `codeAPOGEE` = ".quote($codeUe).";";
        $resultat = $Base->query($requete);
        $nbEtudiant = $resultat->fetchColumn();
        return $nbEtudiant;
    }

    // Récupérer la liste des jalons dispo 
    function getJalons() {
        global $Base;
        $requete = "SELECT * FROM `Jalon`;";
        $resultat = $Base->query($requete);
        $jalons = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $jalons;
    }