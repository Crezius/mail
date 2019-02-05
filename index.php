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

	
if ((isset($_POST["mailConnexion"])) || (isset($_GET["user"]))){
    
	if (isset($_POST["mailConnexion"])){
        
		$user = $_POST["mailConnexion"];
        
	}
	else{
        
		$user = $_GET["user"];
        
	}
	

	if ((isset($_POST["message"])) && (isset($_POST["dest"]))){
        
		$prep = $bdd->prepare('INSERT INTO donnee (destinataire,expediteur,date,message) VALUES (?,?,NOW(),?)');
		$prep->execute(array($_POST["dest"],$user,$_POST["message"]));
        
	}

	
	$sql = "SELECT * FROM donnee WHERE destinataire='".$user."'";
	$reponse = $bdd->query($sql);
	while ($donnees = $reponse->fetch()) {
        
		$point_fin=""; 
		$apercu = substr($donnees['message'], 0, 10);
		if(strlen($donnees['message'])>10){
			$point_fin="...";
		}
        
		$echoListe .= "<li class=\"liste_mail\" onclick=\"afficherMail(".$donnees['id'].",'".$user."')\">
							<a id=\"listeMail\"  href=\"#l\">
								".$donnees['date']." <b>".$donnees['expediteur']."</b> : ".$apercu."".$point_fin."
							</a>
							<a id=\"croix\" onclick=\"supprimer(".$donnees['id'].",'".$user."')\" href=\"#\">
								<span class=\"croixgauche\"></span>
                                <span class=\"croixdroite\"></span>
							</a>
						</li>";
    
	}
	
	if (isset($_GET["id"])){
        
		$req = "SELECT message,expediteur, date FROM donnee WHERE id=".$_GET["id"]."";
		$reponse = $bdd->query($req);
		while ($donnees = $reponse->fetch()) {
            
			$echoMessage = "</br><p>Le : ".$donnees['date']."<br/>De : <b>".$donnees['expediteur']."</b><br/>A : <b>".$user."</b><br/><br/>".$donnees['message']."</p>";
            
		}
	}
	
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
		
			function afficherMail(id,user){
				xhr = new XMLHttpRequest();
				
				xhr.open('GET', 'http://localhost/DIP/test/mail/index.php?user=' + user + '&id=' + id);
				xhr.send(null);
				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4) {
						window.location.href="index.php?user=" + user + '&id=' + id;
					}
				}	
			}
			
			function supprimer(id,user){
				xhr = new XMLHttpRequest();
				xhr.open('DELETE', 'http://localhost/DIP/test/mail/index.php?user=' + user + '&idSUP=' + id);
				xhr.send(null);
					
				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4) {
						window.location.href="index.php?user=" + user;
					}
				}
                
                var list_mail = document.getElementById("_liste_mail");
                list_mail.removeChild(list_mail.childNodes[id_liste]);
			}
		</script>
        
        <div id="Connexion" <?php if($user!="")echo ("style=\"background-color:#055ddd\"")?>>
            <h1>Ma Boite Mail</h1>
           
            <form id="form_connexion" action="index.php" method="post">
				<input type="text" name="mailConnexion" maxlength="20"/>
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
					<input type="submit" value="Envoyer" id="btnEnvoyer">
				</div>
			</form>
        </div>
		
		

		<div id="gauche">
			<ul id="_liste_mail">
				<?php
					if($Liste!="") {
                        echo Liste
                    }
				?>
			</ul>
		</div>
		<div id="droite">
			<?php
				if($Message!="") {
                    echo $Message
                }
			?>
		</div>
	</body>
</html>

