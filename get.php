
        
        <?php 
            
            //Info base
            $dbhost = "localhost";
            $dbuser = "me";
            $dbpass = "mdp";
            $db = "mail";
            $user="";
            $Liste="";
            $Message="";


            try
            {
                $bdd = new PDO('mysql:host=localhost;dbname='.$db.';charset=utf8', $dbuser, $dbpass);
            }
            catch (Exception $e)
            {
                    die('Erreur : ' . $e->getMessage());
            }

            if (isset($_GET["id"])){
                
                $id=$_GET['id'];
                
                $sql = "SELECT * FROM donnee WHERE id='".$id."'";
	           $reponse = $bdd->query($sql);
                
                
                while ($donnees = $reponse->fetch()) {
                    
                    /*echo "<h2 id='message_select'>From : ".$donnees['expediteur']."</h1>
                    <h3>To : ".$donnees['destinataire']."</h2>
                    <p>".$donnees['message']."</p>";
                    */
                    
                    echo "</br><p id='coucou'>Le : ".$donnees['date']."<br/>De : <b>".$donnees['expediteur']."</b><br/>A : <b>".$user."</b><br/><br/>".$donnees['message']."</p>";
                }
            }
        
        
        ?>
