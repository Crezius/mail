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




    


    

        /*
        if ((isset($_POST["message"])) && (isset($_POST["dest"]))){

            $prep = $bdd->prepare('INSERT INTO donnee (destinataire,expediteur,date,message) VALUES (?,?,NOW(),?)');
            $prep->execute(array($_POST["dest"],$user,$_POST["message"]));

        }
        */

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

        /*
        if (isset($_GET["idSUP"])) {

            $prep = $bdd->prepare('DELETE FROM donnee WHERE id=?');
            $prep->execute(array($_GET["idSUP"]));

        }*/	

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

                return false;
			}
                
            function listerMail(user){
				xhr = new XMLHttpRequest();
				
				xhr.open('GET', 'list.php?user=' + user);
				xhr.send(null);

                
                return false;
			}    
                
            function ajouterMail(user){
				xhr = new XMLHttpRequest();
                
                //let mess = document.getElementById('message').value;
                //let dest = document.getElementById('dest').value;
				//let req = "message="+mess+"&dest="+dest;
				
                var formElement = document.getElementById("envoi");
                var formData = new FormData(formElement);

                xhr.open('POST', 'ajouter.php');
				formData.append("user", user);
                
                alert(formData.get('dest'));
                xhr.send(formData);
                
                document.getElementById('message').value = "";
                document.getElementById('dest').value = "";
                
                return false;
			}
                
                
			
			function supprimer(id, id_liste){
				xhr = new XMLHttpRequest();
				xhr.open('DELETE', 'supprimer.php?idSUP=' + id);
				xhr.send(null);

                
                var list_mail = document.getElementById("_liste_mail");
                list_mail.removeChild(document.getElementById("liste_mail"+id_liste));
                
                return false;
			}
                
            function connexion(user){
				xhr = new XMLHttpRequest();
				xhr.open('GET', 'connexion.php?user=' + user);
				xhr.send(null);
                
                return false;
			}
                
		</script>
        
        <div id="Connexion" <?php if($user!="")echo ("style=\"background-color:#055ddd\"")?>>
            <form id="form_connexion" onsubmit="return connexion('<?=$user?>')" method="get">
				<input type="text" name="user" maxlength="20"/>
				<input type="submit" value="Connexion">
			</form>
        </div>
		
		<div id="creation_mail" >
			<form id="envoi" onsubmit="return ajouterMail(<?php echo "'$user'" ?>)">
				<div id="_Destinataire">
					<label for="dest">Destinataire:  </label>
					<input type="text" id="dest" name="dest" style="width:100%" maxlength="20"/>
				</div>
				<div id="_Message">
					<label for="message">Message:  </label>
					<input type="text" id="message" name="message"  style="width:100%" maxlength="300"/>
					<input type="submit" value="Envoyer"  id="btnEnvoyer">
				</div>
			</form>
        </div>
		
		

		<div id="gauche">
            <input type="submit" value="FLETCH"  onclick="listerMail(<?php echo "'$user'"?>)" id="fletch">

			<ul id="_liste_mail">
				
			</ul>
		</div>
		<div id="droite">
		
		</div>
	</body>
</html>

