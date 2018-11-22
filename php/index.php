<?php session_start(); 
    $pseudo = isset($_SESSION['pseudo']) ? $_SESSION['pseudo'] : '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet"> 
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Mini chat</title>
</head>
<body class="container">
    <div class="row">
    <form class="col-lg-offset-4 col-lg-4 col-md-offset-4 col-md-4 col-sm-offset-3 col-sm-6" action="m_chat_post.php" method="post">
        <fieldset>
          <legend>Bienvenue sur le mini-chat. Donnez votre avis</legend>
          <div class="input-group">
            <span class="input-group-addon">Pseudo</span>
            <input type="Pseudo" class="form-control" name="pseudo" value="">
          </div>
          <div class="input-group">
            <span class="input-group-addon">Message</span>
            <input type="text" class="form-control" name="message" value="">
          </div>
          <div class="input-group">
            <button type="submit" class="btn btn-primary btn-sm" name="envoyer">Envoyer</button>
          </div>
        </fieldset>
    </form>
    </div>

    <!-- LE PHP -->
    <?php 
        // connexion à la BD
        try{
            $bdd = new PDO('mysql:host=localhost;dbname=activiteopclrm;charset=utf8', 'root', '');
        } 
        catch(Exception $e) {
            die('Erreur : '.$e->getMessage());
        }
        // Recupération des 10 derniers messages
        $reponse = $bdd->query('SELECT pseudo, message, DAY(date) AS J, MONTH(date) AS M, YEAR(date) AS Y, HOUR(date) AS H, MINUTE(date) AS Mn, SECOND(date) AS S FROM chat ORDER BY id DESC LIMIT 0, 10');

        // Affichage de données
        while($donnees = $reponse->fetch()) {
    ?>
        <div class="">
        <div class="boxMsg row">
            <div class="pseudo col-lg-2 col-md-2 col-sm-2">
                <h1> <?php echo htmlspecialchars($donnees['pseudo']); ?> </h1>
            </div>
            <div class="msg col-lg-7 col-md-8 col-sm-6">
                <p> <?php echo htmlspecialchars($donnees['message']); ?> </p>
            </div>
            <div class="date col-lg-3 col-md-2 col-sm-4">
                <?php echo 'le : ' . $donnees['J'] . ' / ' . $donnees['M'] . ' / ' . $donnees['Y'] . ' à ' . $donnees['H'] . 'h ' . $donnees['Mn'] . 'mn ' . $donnees['S'] . 's '; ?>
                
            </div>
        </div>
        </div>
    <?php
        }
        $reponse->closeCursor();
    //    var_dump($_COOKIE);  // POUR VOIR LES COOKIE (pseudo enregistrer)
    ?>
</body>
</html>