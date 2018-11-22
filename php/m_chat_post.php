<?php
session_start();

    // Connexion à la base de donnée
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=activiteopclrm;charset=utf8', 'root', '');
    } 
    catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
    
    // Enregistrer le pseudo
    $pseudo = "";
    if(!empty($_POST['pseudo'])) {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        setcookie('pseudo', $_POST['pseudo'], time() + 365*24*3600, null, null, false, true);
    } elseif(!empty($_COOKIE['pseudo'])) {
        $_POST['pseudo'] = $_COOKIE['pseudo'];
    }

    // Insertion du message
    if (isset($_POST['envoyer'])) { // Si on appuit sur le boutton envoyer
        if(empty($_POST['pseudo']) OR empty($_POST['message'])){ // Le pseudo ou le message est vide
            $_POST['pseudo'] = $_COOKIE['pseudo'];
        }
        else { // Si non c'est à dire que pseudo ou messege pas vide 
            $req = $bdd->prepare('INSERT INTO chat (pseudo, message, date) VALUES (?, ?, NOW())');
            $req->execute(array($_POST['pseudo'], $_POST['message']));
        }
    }

    // redirection vers la page index.php
    header('location: index.php');
?>