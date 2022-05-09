<?php 

    function getEquipe() {
        global $Base;
        $requete="SELECT idEquipe, nomEquipe FROM Equipe ORDER BY nomEquipe ASC";
        $resultat = $Base->query($requete);
        $equipe = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $equipe;
    }

    function getProjetsEquipe($idEquipe) {
        global $Base;
        $requete = "SELECT p.idProj, p.nomProj FROM (SELECT idEquipe FROM Encadre WHERE idEquipe = ".quote($idEquipe).") a JOIN Equipe e on e.idEquipe = a.idEquipe JOIN Projet p on e.idProj = p.idProj;";
        $resultat = $Base->query($requete);
        $projets = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $projets;         
    }