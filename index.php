<?php

    // On fait les includes de la bdd
    include('inc/bdd.php');

    $routes = array(
        'acceuil' => array("Acceuil", "accueil.php")
    );

    $route = 'acceuil';
    // On vérifie si la route existe
    if(isset($_GET['page']) && isset($routes[$_GET['page']])) {
        $route = $_GET['page'];
    }

    // On défini le nom de la page
    $page = $routes[$route][0];
    // On défini le chemin de la page
    $chemin = $routes[$route][1];
    // On include le modele
    include("modeles/modele_".$chemin);

    // On inclut le controleur
    include("controleurs/controleur_".$chemin);

?>

<html>
    <!-- Bloc entête -->
    <head>
        <title>Gestion de Projets - <?=$page?></title>
        <meta charset="utf-8">
        <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.1/css/all.css"/> -->
        <link rel="stylesheet" href="css/style.css"/>
    </head>

    <!-- Bloc body -->
    <body>
        <!-- Bloc header -->
        <?php include("static/header.php") ?>
        <!-- Bloc Menu -->
        <?php include("static/menu.php") ?>
        <!-- Bloc contenu -->
        <div class="container">
            <?php include("vues/vue_".$chemin) ?>
        </div>
        <!-- Bloc footer -->
        <?php include("static/footer.php") ?>
    </body>
</html>