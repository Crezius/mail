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
            if ((isset($_POST["message"])) && (isset($_POST["dest"]))){
                        print($_POST["message"]);

            $prep = $bdd->prepare('INSERT INTO donnee (destinataire,expediteur,date,message) VALUES (?,?,NOW(),?)');
            $prep->execute(array($_POST["dest"], "quelqun",$_POST["message"]));

        }


        ?>