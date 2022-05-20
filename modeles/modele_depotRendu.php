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
        $requete = "SELECT r.rendu, j.idJal, CASE WHEN r.idJal IS NULL THEN false ELSE true END as estRendu FROM Jalon j LEFT JOIN Rendu r on r.idJal = j.idJal and r.idEquipe = ".quote($idEquipe)." WHERE j.idJal IN (SELECT idJal FROM JalonDuProjet j WHERE j.idProj = ".quote($idProjet).") ORDER by rangJal ASC";
        $resultat = $Base->query($requete);
        $rendu = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $rendu;
    }

    // Détermine le type de rendu suivant l'idJalon
    function getTypeRendu($listeJalons, $idJal) {
        foreach ($listeJalons as $jalon) {
            if ($jalon['idJal'] == $idJal) {
                return $jalon['typeJal'];
            }
        }
        return false;
    }

    // Déterminer la valeur du rendu suivant l'idJalon
    function getValueRendu($listeRendu, $idJal) {
        foreach ($listeRendu as $rendu) {

            if ($rendu['idJal'] == $idJal) {
                return $rendu['rendu'];
            }
        }
        return false;
    }

    // Met à jour le rendu d'un jalon
    function updateRendu($idJalon, $idEquipe, $rendu){
        global $Base;
        // Premièrement on supprime le rendu existant pour ce jalon (peut ne pas exister mais pas grave)
        $requete = "DELETE FROM Rendu WHERE idJal = ".quote($idJalon)." AND idEquipe = ".quote($idEquipe);
        $Base->query($requete);
        // On insère le nouveau rendu
        $requete = "INSERT INTO Rendu (idJal, idEquipe, rendu, dateRendu) VALUES (".quote($idJalon).", ".quote($idEquipe).", ".quote($rendu).", ".quote(date("Y-m-d")).")";
        $Base->query($requete);
    }