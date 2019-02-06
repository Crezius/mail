        <?php 
            
            //Info base
            $dbhost = "localhost";
            $dbuser = "me";
            $dbpass = "mdp";
            $db = "mail";
            $user="";
            $Liste="";
            $Message="";


            try {
                $bdd = new PDO('mysql:host=localhost;dbname='.$db.';charset=utf8', $dbuser, $dbpass);
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }

            $prep = $bdd->prepare('INSERT INTO donnee (destinataire,expediteur,date,message) VALUES (?,?,NOW(),?)');
            //$prep->execute(array("test", "test", "test123"));
            
            $prep->execute(array($_POST["dest"], $_POST['user'], $_POST["message"]));

        //}


        ?>
        
        <script>
           console.log(<?php echo $_POST['dest']." ".$_POST['user']." ".$_POST['message'];?>);
        </script>