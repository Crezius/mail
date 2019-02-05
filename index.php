<?php

//Info base
$dbhost = "localhost";
$dbuser = "me";
$dbpass = "mdp";
$db = "mail";
$user="";
$iduser="";
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

    function maj_titre(){
    
        if (isset($_GET["user"])){

            echo "<h1>Ma mail-lerie : ".$_GET['user']."</h1>";
        }
    }


    if (isset($_GET['user'])){


        $user = $_GET['user'];

        if ((isset($_POST["message"])) && (isset($_POST["dest"]))){

            $prep = $bdd->prepare('INSERT INTO donnee (destinataire,expediteur,date,message) VALUES (?,?,NOW(),?)');
            $prep->execute(array($_POST["dest"],$user,$_POST["message"]));

        }

        /*
        $sql = "SELECT * FROM donnee WHERE destinataire='".$user."'";
        $reponse = $bdd->query($sql);
        while ($donnees = $reponse->fetch()) {

            $point_fin=""; 
            $apercu = substr($donnees['message'], 0, 10);
            if(strlen($donnees['message'])>10){
                $point_fin="...";
            }



            $Liste .= "<li class=\"liste_mail\" onclick=\"afficherMail(".$donnees['id'].")\">
                                <a id=\"listeMail\"  href=\"#l\">
                                    ".$donnees['date']." <b>".$donnees['expediteur']."</b> : ".$apercu."".$point_fin."
                                </a>
                                <a id=\"croix\" onclick=\"supprimer(".$donnees['id'].",'".$user."')\" href=\"#\">
                                    <span class=\"croixgauche\"></span>
                                    <span class=\"croixdroite\"></span>
                                </a>
                            </li>";

        }*/

        /*if (isset($_GET["id"])){

            $req = "SELECT message,expediteur, date FROM donnee WHERE id=".$_GET["id"]."";
            $reponse = $bdd->query($req);
            while ($donnees = $reponse->fetch()) {

                $Message = "</br><p id='coucou'>Le : ".$donnees['date']."<br/>De : <b>".$donnees['expediteur']."</b><br/>A : <b>".$user."</b><br/><br/>".$donnees['message']."</p>";

            }
        }*/

        if (isset($_GET["idSUP"])) {

            $prep = $bdd->prepare('DELETE FROM donnee WHERE id=?');
            $prep->execute(array($_GET["idSUP"]));

        }
    }	

?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body> 
       
       		<script>
		
			function afficherMail(id){
				xhr = new XMLHttpRequest();
				
				xhr.open('GET', 'get.php?id=' + id);
				xhr.send(null);
				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4) {
                        
                        
						document.getElementById('droite').innerHTML= xhr.responseText;
					}
				}    
			}
                
            function listerMail(user){
				xhr = new XMLHttpRequest();
				
				xhr.open('GET', 'list.php?user=' + user);
				xhr.send(null);
				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4) {
                        
                        
						document.getElementById('_liste_mail').innerHTML= xhr.responseText;
					}
				}    
			}    
                
            function ajouterMail(user){
				xhr = new XMLHttpRequest();
				
				xhr.open('GET', '/index.php?user=' + user);
				xhr.send(null);
				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4) {
						window.location.href="index.php?user=" + user + '&id=' + id;
					}
				}	
			}
			
			function supprimer(id,user, id_liste){
				xhr = new XMLHttpRequest();
				xhr.open('DELETE', '/index.php?user=' + user + '&idSUP=' + id);
				xhr.send(null);
					
				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4) {
						//window.location.href="index.php?user=" + user;
					}
				}
                
                var list_mail = document.getElementById("_liste_mail");
                list_mail.removeChild(list_mail.childNodes[id_liste]);
			}
		</script>
        
        <div id="Connexion" <?php if($user!="")echo ("style=\"background-color:#055ddd\"")?>>
            <?php maj_titre(); ?>   
            <form id="form_connexion" action="index.php" method="get">
				<input type="text" name="user" maxlength="20"/>
				<input type="submit" value="Connexion">
			</form>
        </div>
		
		<div id="creation_mail" >
			<form id="envoi" action="index.php<?php if($user!="")echo("?user=".$user."")?>" method="post">
				<div id="_Destinataire">
					<label for="dest">Destinataire:  </label>
					<input type="text" id="dest" name="dest" style="width:100%" maxlength="20"/>
				</div>
				<div id="_Message">
					<label for="message">Message:  </label>
					<input type="text" id="message" name="message"  style="width:100%" maxlength="300"/>
					<input type="submit" value="Envoyer" <?php echo "onclick=ajouterMail(".$user.")"?> id="btnEnvoyer">
				</div>
			</form>
        </div>
		
		

		<div id="gauche">
            <input type="submit" value="FLETCH"  onclick="listerMail(<?php echo "'$user'"?>)" id="fletch">

			<ul id="_liste_mail">
				<?php
					if($Liste!="") {
                        echo $Liste;
                    }
				?>
			</ul>
		</div>
		<div id="droite">
		

			<?php
				if($Message!="") {
                    echo $Message;
                }
			?>
		</div>
	</body>
</html>

