<?php 
            
        //Info base
        $dbhost = "localhost";
        $dbuser = "me";
        $dbpass = "mdp";
        $db = "mail";
        $user="";
        $Liste="";
        $Message="";
        $indice=0;

        try {
            $bdd = new PDO('mysql:host=localhost;dbname='.$db.';charset=utf8', $dbuser, $dbpass);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        if (isset($_GET["idSUP"])) {
            $prep = $bdd->prepare('DELETE FROM donnee WHERE id=?');
            $prep->execute(array($_GET["idSUP"]));

        }        
        
?>