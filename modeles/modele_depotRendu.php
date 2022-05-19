<?php 

    // Récupère la liste des équipes
    function getEquipes() {
        global $Base;
        $requete="SELECT idEquipe, nomEquipe FROM Equipe ORDER BY nomEquipe ASC";
        $resultat = $Base->query($requete);
        $equipe = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $equipe;
    }

    // Récupère la liste des projets d'une équipe
    function getProjetsEquipe($idEquipe) {
        global $Base;
        $requete = "SELECT p.idProj, p.nomProj FROM Equipe e JOIN Projet p on e.idProj = p.idProj WHERE e.idEquipe = ".quote($idEquipe)." ORDER BY p.etatProj, p.anneeProj, p.nomProj";
        $resultat = $Base->query($requete);
        $projets = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $projets;         
    }

    // Récupère les infos du projet
    function getProjetInfo($idProj) {
        global $Base;
        $requete = "SELECT * FROM Projet WHERE idProj = ".quote($idProj);
        $resultat = $Base->query($requete);
        $projet = $resultat->fetch(PDO::FETCH_ASSOC);
        return $projet;
    }

    // Récupère la liste des jalons d'un projet
    function getJalonsProjet($idProjet) {
        global $Base;
        $requete = "SELECT j.idJal, j.reportDateLimiteJal, j.typeJal FROM Jalon j WHERE idJal IN (SELECT idJal FROM JalonDuProjet jdp WHERE jdp.idProj = ".quote($idProjet).") ORDER by rangJal ASC";
        $resultat = $Base->query($requete);
        $jalons = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $jalons;
    }

    // Récupère la liste des rendu d'une équipe pour un projet
    function getRenduEquipeProjet($idEquipe, $idProjet) {
        global $Base;
        $requete = "SELECT j.idJal, CASE WHEN r.idJal IS NULL THEN false ELSE true END as rendu FROM Jalon j LEFT JOIN Rendu r on r.idJal = j.idJal and r.idEquipe = ".quote($idEquipe)." WHERE j.idJal IN (SELECT idJal FROM JalonDuProjet j WHERE j.idProj = ".quote($idProjet).")";
        $resultat = $Base->query($requete);
        $rendu = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $rendu;
    }