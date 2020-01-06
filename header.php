<?php session_start(); ?>

<?php
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=app;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
	die('erreur:'.$e -> getMessage());
}
?>

<head>
	<link rel="stylesheet" href="CSS/header.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<header>
	<nav class="group">
		<div class="preheader">
			<div>
				<a href="index.php">
					<img src="Media/logoapp.png" id="logo">
				</a>
			</div>
			<div>
				<p id="user">
		          <strong> 
		            <?php
		            if (isset($_SESSION['id'])) {
		            	$req = $bdd -> prepare('SELECT * FROM compte WHERE id=:id');
						$req -> execute(array('id' => $_SESSION['id']));
						$BDD = $req->fetch();
						$_SESSION['prenom']=$BDD['prenom'];
						$_SESSION['nom']=$BDD['nom'];
						$_SESSION['mail']=$BDD['mail'];
						$_SESSION['mdp']=$BDD['mdp'];
						$_SESSION['typeUtilisateur']=$BDD['typeUtilisateur'];
						$_SESSION['birthday']=$BDD['birthday'];
						$_SESSION['phone']=$BDD['phone'];
						$_SESSION['pays']=$BDD['pays'];
						$_SESSION['ville']=$BDD['ville'];
						$_SESSION['ZIP']=$BDD['ZIP'];
						$_SESSION['adresse']=$BDD['adresse'];
						$_SESSION['adresse2']=$BDD['adresse2'];

		            	echo 'Bienvenue, '.$_SESSION['prenom'].' '.$_SESSION['nom'].' ';
		            }
		            ?>
		          </strong>
		        </p>
			</div>	
				
		</div>

		
		<div>
			
		

		<ul class="menuoptions"> 
			<div class="menu1">	   
				<li class="menuDeroulant">
					<button class="menubtn" id="leftbutton">À propos</button>
		  			<div class="contenuMenu">
						<a href="index.php">Accueil</a>
		 				<a href="about.php">À propos de nous</a>
		 				<a href="terms.php">Mentions légales</a>
		  			</div>
		  		</li>
				<li class="menuDeroulant">
		  			<button class="menubtn" id="leftbutton">Support</button>
		  			<div class="contenuMenu">
		 				<a href="privacy.php">Règlement</a>
		 				<a href="FAQ.php">FAQ</a>
		 				<a href="contactus.php">Nous Contactez</a>
		  			</div>
		  		</li>
		  		

				<li class="menuDeroulant">
		  				<?php 
				  		//on affiche les variables de session deja existants
						if (isset($_SESSION['id'])) { ?>
								<button class="menubtn" id="leftbutton">Mon Compte</button>
								<div class="contenuMenu">
		 							<a href="profil.php">Profil</a>
									<a href="logout.php">Se déconnecter</a>
		  						</div>
						<?php 
						}
						else{ ?>
  							<button class="menubtnsingle" id="rightbutton">
  								<a href="login.php">Se connecter</a>
							</button> 	
						<?php 
						}
						?>
		  				
		  			</button> 	
		  		</li>

		  		
  				<?php 
		  		//si on en a lautorisation on affiche le bouton pour creer un compte
				if (isset($_SESSION['typeUtilisateur']) and $_SESSION['typeUtilisateur']<=1) {
					echo "<li class='menuDeroulant'>";
						echo "<button class='menubtnsingle'>";
							echo "<a href='register.php'>Créer un compte</a>";
						echo "</button>"; 	
				  	echo "</li>";
				}?>

				<li class="menuDeroulant">
						<?php 
				  		//si on en a lautorisation on affiche le bouton pour creer un compte
						if (isset($_SESSION['typeUtilisateur']) and $_SESSION['typeUtilisateur'] == 0) { ?>
								<button class="menubtnsingle" id="rightbutton">
  								<a href="backOffice.php">Back Office</a>
							</button> 	
						<?php 
						}?>
		  			</button> 	
		  		</li>

			</div>
			<div class="menu2">
		  		<form class="menuinput" action="FAQ.php">
		  			<input type="search" name="searchtext" placeholder="Recherche..." id ="search-bar">	
					<button type="submit" id="search-button"><i class="fa fa-search"></i></button>
		  		</form>
			</div>

			
		</ul>
	</nav>
</header>