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
        $requete = "SELECT j.dateLimiteJal, j.typeJal, j.idJal, r.nb AS nbRendus
        FROM ( SELECT dateLimiteJal, typeJal, idJal FROM Jalon WHERE idJal IN
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