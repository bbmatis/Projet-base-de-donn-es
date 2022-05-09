<?php

    // On récupère la liste des enseignants
    function getEnseignants() {
        global $Base;
        $requete = "SELECT * FROM `Enseignant` ORDER BY `prenomEns`, `nomEns` ASC;";
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

    function getEquipes($idEns, $idProj) {
        global $Base;
        $requete = "SELECT a.nomEquipe, a.idEquipe FROM (SELECT nomEquipe, idEquipe FROM Equipe WHERE idProj = ".quote($idProj).") a JOIN Encadre e on e.idEquipe = a.idEquipe and e.idEns = ".quote($idEns).";";
        $resultat = $Base->query($requete);
        $equipes = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $equipes;
    }

    function getJalonsInfoProj($idEns, $idProj) {
        global $Base;
        $requete = "SELECT j.reportDateLimiteJal as dateLimiteJal,  j.typeJal, j.idJal, r.nb AS nbRendus
        FROM ( SELECT reportDateLimiteJal, typeJal, idJal FROM Jalon WHERE idJal IN
                ( SELECT idJal FROM JalonDuProjet WHERE idProj = ".quote($idProj)." ) ) j
        JOIN ( SELECT COUNT(*) AS nb, idJal FROM Rendu WHERE idJal IN
                ( SELECT idJal FROM JalonDuProjet WHERE idProj = ".quote($idProj)." ) AND idEquipe IN
                ( SELECT e.idEquipe FROM ( SELECT idEquipe FROM Equipe WHERE idProj = ".quote($idProj)." ) a
                    JOIN Encadre e ON e.idEquipe = a.idEquipe AND e.idEns = ".quote($idEns)." )
                GROUP BY idJal ) r
        ON j.idJal = r.idJal";
        $resultat = $Base->query($requete);
        $jalons = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $jalons;
    }

    // Récupérer la liste des jalons rendus par une équipe pour un projet
    function getEquipeJalon($idProj, $idEquipe) {
        global $Base;
        $requete = "SELECT * FROM `Rendu` WHERE `idEquipe` = ".quote($idEquipe)." and `idJal` in (SELECT idJal FROM JalonDuProjet j WHERE j.idProj = ".quote($idProj).");";
        $resultat = $Base->query($requete);
        $jalons = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $jalons;
    }