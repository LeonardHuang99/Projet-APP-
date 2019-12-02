<!DOCTYPE html>
<html lang="fr">
<head>
	<title> Bienvenue</title>
	<link rel="stylesheet" href="CSS/main.css">
</head>
<body>
	<?php include("header.php"); ?>
	<section>
		<h1> Cr&eacute;ation du compte </h1>
		<p> Voici les informations saisies : </p>
		<p>
			<link rel = "stylesheet" href="CSS/saisie.css">

			<?php
				//on essaie e se connecter a la bdd, s'il y a une erreur on affiche juste une erreur au lieu d'afficher le lien vers la bdd par securité
				try
				{
					$bdd = new PDO('mysql:host=localhost;dbname=app;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				}
				catch(Exception $e)
				{
					die('erreur:'.$e -> getMessage());
				}
			?>
			<?php

			//fonction chargé de generer un mot de passe aleatoire temporaire
			function RandomString(int $nbrcaracteres)
		    {//créer une chaine de caractère aléatoir avec minuscules, majuscules, chiffres (parfait pour des mdp aléatoire)
		        $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		        $randstring = "";
		        for ($i = 0; $i < $nbrcaracteres; $i++) {
		            $randstring .= $characters[rand(0, strlen($characters)-1)];
		        }
		        return $randstring;
		    }

			//on remplis les infos
			$nom = $_POST['nom'];
			$prenom = $_POST['prenom'];
			$genre = $_POST['genre'];
			$birthday = $_POST['birthday'];
			$mail = $_POST['mail'];
			$phone = $_POST['phone'];
			$pays = $_POST['pays'];
			$ville = $_POST['ville'];
			$ZIP = $_POST['ZIP'];
			$adresse = $_POST['adresse'];

			if(isset($_POST['adresse2']))
			{
				$adresse2 = $_POST['adresse2'];
			}
			else
			{
				$adresse2 = 'NR';
			}

			$typeUtilisateur = 2;

			echo 'mail =', $mail, '='; 
			echo "<br>";
			echo 'birthday =', $birthday, '='; 
			echo "<br>";
			echo 'phone =', $phone, '='; 
			echo "<br>";
			echo 'nom =', $nom, '='; 
			echo "<br>";
			echo 'prenom =', $prenom, '='; 
			echo "<br>";
			echo 'genre =', $genre, '='; 
			echo "<br>";
			echo 'pays =', $pays, '='; 
			echo "<br>";
			echo 'ville =', $ville, '='; 
			echo "<br>";
			echo 'ZIP =', $ZIP, '='; 
			echo "<br>";
			echo 'adresse =', $adresse, '='; 
			echo "<br>";
			echo 'adresse2 =', $adresse2, '='; 
			echo "<br>";
			echo 'typeUtilisateur =', $typeUtilisateur, '='; 
			echo "<br>";

			//on cherche le mail dans la base de donné
			$req1 = $bdd->prepare('SELECT mail FROM compte WHERE mail=:mail');
			$req1 -> execute(array('mail' => $mail));
			$mailBDD = $req1->fetch();

			//on test si mail est deja present pour eviter les erreurs
			if (isset($mailBDD['mail'])) {
				echo "<a href = \"register.php\">no chance</a>";
				header('Location: register.php');
				setcookie('nom',$nom,time() + 600);
				setcookie('prenom',$prenom,time() + 600);
				setcookie('genre',$genre,time() + 600);
				setcookie('birthday',$birthday,time() + 600);
				setcookie('phone',$phone,time() + 600);
				setcookie('pays',$pays,time() + 600);
				setcookie('ville',$ville,time() + 600);
				setcookie('ZIP',$ZIP,time() + 600);
				setcookie('adresse',$adresse,time() + 600);
				if(isset($adresse2))
				{
					setcookie('adresse2',$adresse2,time() + 600);
				}
				
			}
			//s'il n'est pas present on ajoute les infos et on redirige a lindex
			else
			{
			$req = $bdd->prepare(' INSERT INTO compte(mail, mdp, birthday, phone, nom, prenom, genre, pays, ville, ZIP, adresse, adresse2, typeUtilisateur) VALUES (:mail, :mdp, :birthday, :phone, :nom, :prenom, :genre, :pays, :ville, :ZIP, :adresse, :adresse2, :typeUtilisateur) ');
			$req -> execute(array(
			'mail' => $mail,
			'birthday'=> $birthday,
			'phone'=> $phone,
			'nom'=> $nom,
			'prenom'=> $prenom,
			'genre'=> $genre,
			'pays'=> $pays,
			'ville'=> $ville,
			'ZIP'=> $ZIP,
			'adresse'=> $adresse,
			'adresse2'=> $adresse2,
			'typeUtilisateur'=> $typeUtilisateur,		  
		    'mdp'=> RandomString(10)));

			echo "<br>";
			echo 'Votre compte a été créé avec succès!';

   			ini_set( 'display_errors', 1 );
    		error_reporting( E_ALL );
 
   			$motPasseProvisoire = "Xa123§wY";
 
    		$subject = "Votre mot de passe provisoire pour vous connecter sur Psitech";
 			$message = "Vous venez de vous inscrire sur le site de Psitech. Voici votre mot de passe provisoire : ".$motPasseProvisoire." \n Vous devrez le changer lors de la première connexion. \n L'équipe Psitech";

    		mail($mail,$subject,$message);
 
   			echo "L'email a été envoyé.";

			//on redirige
			header("Location: index.php");
			}
			
			?>
			</p>
		</section>
	<?php include("footer.php"); ?>
		
</body>