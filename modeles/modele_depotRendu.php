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
        $requete = "SELECT p.idProj,p.nomProj,e.nomEquipe FROM Equipe e JOIN Projet p on e.idProj = p.idProj WHERE e.idEquipe = ".quote($idEquipe)." ORDER BY p.etatProj, p.anneeProj, p.nomProj";
        $resultat = $Base->query($requete);
        $projets = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $projets;         
    }