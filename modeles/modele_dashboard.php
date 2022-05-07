<?php

    // On récupère la liste des enseignants
    function getEnseignants() {
        global $Base;
        $requete = "SELECT idEns, nomEns, prenomEns FROM Enseignant;";
        $resultat = $Base->query($requete);
        $enseignants = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $enseignants;
    }

    // On récupère la liste des projets pour un enseignant
    function getEnsProjets($idEns) {
        global $Base;
        $requete = "SELECT p.idProj, p.nomProj FROM (SELECT idEquipe FROM Encadre WHERE idEns = ".quote($idEns).") a JOIN Equipe e on e.idEquipe = a.idEquipe JOIN Projet p on e.idProj = p.idProj;";
        $resultat = $Base->query($requete);
        $projets = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $projets;         
    }

    function getNbEquipes($idEns, $idProj) {
        global $Base;
        $requete = "SELECT count(*) as c FROM (SELECT idEquipe FROM Equipe WHERE idProj = ".quote($idProj).") a JOIN Encadre e on e.idEquipe = a.idEquipe and e.idEns = ".quote($idEns).";";
        $resultat = $Base->query($requete);
        $nbEquipes = $resultat->fetch(PDO::FETCH_ASSOC)['c'];
        return $nbEquipes;
    }

    function getJalons($idEns, $idProj) {
        global $Base;
        $requete = "SELECT dateLimiteJal, typeJal FROM Jalon j WHERE j.idJal IN (SELECT j.idJal FROM JalonDuProjet j WHERE j.idProj = ".quote($idProj).") ORDER by rangJal ASC";
        $resultat = $Base->query($requete);
        $jalons = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $jalons;
    }