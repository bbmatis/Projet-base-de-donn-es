<?php
    // Obtenir la liste des projets actifs
    // En sélectionnant son libelle, le sigle EU associé et nom, prénom du responsable de l’UE
    function getProjetActif() {
        global $Base;
        $requete = "SELECT DISTINCT `nomProj`, `codeApoge`, ens.`prenomEns`, ens.`nomEns` FROM ( SELECT `nomProj`, `codeApoge`, `semestreProj`, `anneeProj` FROM Projet WHERE `etatProj` = 'Actif' ) p JOIN EquipePedagogique e ON p.codeApoge = e.codeAPOGEE AND p.`semestreProj` = e.semestre AND p.anneeProj = e.annee JOIN Enseignant ens ON e.idEns = ens.idEns";
        $resultat = $Base->query($requete);
        $projets = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $projets;
    }

    // Obtenir le nombre de projets par UE suivant le statut du projet
    // Soit Actif, En Attente, Archivé
    function getNbProjetsUEParEtat() {
        global $Base;
        $requete = "SELECT Archive.codeApoge, Archive.semestreProj, Archive.Archives, Actif.Actifs, coalesce(Attente.Attentes, 0) as Attentes FROM (SELECT COUNT(*) as Archives, codeApoge, semestreProj FROM Projet WHERE etatProj = 'Archivé' GROUP by codeApoge, semestreProj) Archive JOIN (SELECT COUNT(*) as Actifs, codeApoge FROM Projet WHERE etatProj = 'Actif' GROUP by codeApoge, semestreProj) Actif on Archive.codeApoge = Actif.codeApoge LEFT JOIN (SELECT COUNT(*) as Attentes, codeApoge FROM Projet WHERE etatProj = 'En attente' GROUP by codeApoge, semestreProj) Attente on Attente.codeApoge = Archive.codeApoge";
        $resultat = $Base->query($requete);
        $nbProjets = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $nbProjets;
    }
    
    // Obtenir le nombre d'UE acceptant plus de 2 étudiants par équipes
    function getnbUEEquipePlusDe2() {
        global $Base;
        $requete = "SELECT COUNT(code) as count FROM (SELECT ue.codeAPOGEE as code FROM Equipe e JOIN Projet p on e.idProj = p.idProj JOIN UE ue on ue.codeAPOGEE = p.codeApoge WHERE e.nbEtudiants > 2 GROUP by ue.codeAPOGEE) a";
        $resultat = $Base->query($requete);
        $nbUE = $resultat->fetch(PDO::FETCH_ASSOC)['count'];
        return $nbUE;
    }

    // Obtenir l'ue qui as présenté le plus de projets
    function getUEProjetPlus() {
        global $Base;
        $requete = "SELECT codeApoge, c FROM (SELECT COUNT(p.idProj) as c, p.codeApoge FROM Projet p GROUP by p.codeApoge ORDER by c DESC) a LIMIT 1";
        $resultat = $Base->query($requete);
        $ue = $resultat->fetch(PDO::FETCH_ASSOC);
        return $ue;
    }

    // Obtenir l'enseignant qui as encadré le plus de projets
    function getEnsProjetEncadrerPlus() {
        global $Base;
        $requete = "SELECT e.nomEns, e.prenomEns, e.idEns, a.c FROM (SELECT e.idEns, COUNT(e.idEns) as c FROM Encadre e GROUP by e.idEns ORDER by c DESC) a JOIN Enseignant e on a.idEns = e.idEns ORDER BY a.c DESC LIMIT 1";
        $resultat = $Base->query($requete);
        $ens = $resultat->fetch(PDO::FETCH_ASSOC);
        return $ens;
    }

    // Obtenir la liste des étudiants ayant obtenu la meilleure note pour chaque UE
    function getEleveBestNotesByUE() {
        global $Base;
        $requete = "SELECT ue.libelleUE, ue.sigle, rM.anneeProj, rM.semestreProj, rM.nomProj, e.nomEtu, e.prenomEtu, note FROM (SELECT MAX(note) as note, p.codeApoge, p.nomProj, rea.idEquipe, p.semestreProj, p.anneeProj FROM (SELECT MAX(`noteFinaleRealisation`) as note, `idProj`, idEquipe FROM Réalisation GROUP by `idProj`) rea JOIN Projet p on rea.idProj = p.idProj GROUP by p.codeApoge) rM JOIN Appartient a on rM.idEquipe = a.idEquipe JOIN Etudiant e on a.idEtu = e.idEtu JOIN UE ue on ue.codeAPOGEE = rM.codeApoge and ue.semestre = rM.semestreProj;";
        $resultat = $Base->query($requete);
        $meilleuresNotes = $resultat->fetchAll(PDO::FETCH_ASSOC);
        return $meilleuresNotes;
    }