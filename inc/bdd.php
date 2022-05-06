<?php
	//=======================================================
	//                    MySQL - PDO
	//=======================================================

	$HoteDeLaBDD = "127.0.0.1"; // Hôte de la Base MySQL
	$NomDeLaBDD = "p2003969"; // Nom de la Base MySQL
	$UserDeLaBDD = "p2003969"; // Utilisateur de la Base MySQL
	$MDPDeLaBDD = "Rehire37Liquid"; //MDP de l'utilisateur de la Base MySQL

	$Base = new PDO('mysql:host='.$HoteDeLaBDD.';dbname='.$NomDeLaBDD, $UserDeLaBDD, $MDPDeLaBDD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

    // Fonction qui permet de quote les données pour éviter les injections SQL
    // @param $val : la valeur à quote
    // @param $like : true si on veut un like, false si on veut un =
    // @return la valeur quoted
	function quote($val, $like = false) {
		global $Base;
		$val = $like ? $Base->quote("%".$val."%") : $Base->quote($val);
		return $val;
	}