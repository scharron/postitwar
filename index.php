<!doctype html>
<html lang="<?php echo $_SESSION['lang']; ?>">
<head>
	<meta charset="utf-8">
	<title>Post-It Generator</title>
	<link href="favicon.ico" type="image/x-icon" rel="icon" />
	<link rel="stylesheet" type="text/css" href="r/css/g.css" />
	<link rel="stylesheet" type="text/css" href="r/css/home.css" />
	<script type="text/javascript" src="r/js/jq1.6.2.js"></script>
	<script type="text/javascript" src="r/js/jq.ui.1.8.15.js"></script>
	<script type="text/javascript" src="r/js/farbtastic.js"></script>
	<script type="text/javascript" src="r/js/home.js"></script>
	<meta name="Description" content="Home page du post-it générateur, avec formulaires de soumission de l'image et choix des couleurs nécessaire pour les calculs afin d'obtenir une prévisualisation du nombre de post it nécessaire a un wall of 'postit' !">
	<meta name="Robots" content="all">
	<meta name="Keywords" content="postit, générator, générateur, post, it, wall, mur, fenêtre, fenêtres, post-it, postti, couleurs, motif, pattern, colle, scotch, bureau">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<?php include "r/php/jsForGG.php"; ?>
	
</head>
<body>
	<div class="container">
	<?php include "r/php/ttl.php"; ?>
		
		<section class="choose">

			<h3><strong>{tr id=STEP}Etape{/tr} 1 :</strong> <br />{tr id=CHOOSE_AMMO_COLOR}Choisissez la couleur de vos munitions{/tr} </h3>
			<p>{tr id=CHOOSE_AMMO_COLOR_NOTE}Vous pouvez choisir jusqu'à 10 couleurs différentes ! Prenez-en une parmi celles proposés,
			ou customisez-en une !{/tr}</p>
		
			<div class="colLeft">
				<h3>{tr id=CHOOSE}Choisissez{/tr} <span>{tr id=CHOOSE_NOTE1}(double clique ou drag'n'drop){/tr}</span> :</h3>
				<div class="list">
					<div data-color="1" data-valueColor="" class="post blue dr" title="{tr id=ADD_COLOR}Ajouter cette couleur{/tr}">
						<span>+</span>
					</div>
					<div data-color="2" data-valueColor="" class="post darkBlue dr" title="{tr id=ADD_COLOR}Ajouter cette couleur{/tr}">
						<span>+</span>
					</div>
					<div data-color="3" data-valueColor="" class="post purple dr" title="{tr id=ADD_COLOR}Ajouter cette couleur{/tr}">
						<span>+</span>
					</div>
					<div data-color="4" data-valueColor="" class="post yellow dr" title="{tr id=ADD_COLOR}Ajouter cette couleur{/tr}">
						<span>+</span>
					</div>
					<div data-color="5" data-valueColor="" class="post orange dr" title="{tr id=ADD_COLOR}Ajouter cette couleur{/tr}">
						<span>+</span>
					</div>
					<div data-color="6" data-valueColor="" class="post fushia dr" title="{tr id=ADD_COLOR}Ajouter cette couleur{/tr}">
						<span>+</span>
					</div>
					<div data-color="7" data-valueColor="" class="post green dr" title="{tr id=ADD_COLOR}Ajouter cette couleur{/tr}">
						<span>+</span>
					</div>
					<div data-color="8" data-valueColor="" class="post darkGreen dr" title="{tr id=ADD_COLOR}Ajouter cette couleur{/tr}">
						<span>+</span>
					</div>
					<div data-color="9" data-valueColor="" class="post rose dr" title="{tr id=ADD_COLOR}Ajouter cette couleur{/tr}">
						<span>+</span>
					</div>
					<div class="post addNew default" title="{tr id=CREATE_COLOR}Créer une couleur{/tr}">
						<span>...</span>
					</div>
				</div>
				<!-- ColorPicker -->
				<form class="hwjs" id="colorpicker" action="#">
				  <div id="picker"></div>
				  <div class="form-item">
					  <div type="text" data-color="rainbow" data-valueColor="" id="color1" name="color1" class="colorwell dr">
						<span class="deco"></span>
					  </div>
				  </div>
				</form>
				
			</div>
			<div class="colRight">
				<h3>{tr id=YOU_SELECTION}Votre sélection{/tr} <span>{tr id=MAX_SELECTION}(10 max){/tr}</span> :</h3>
				<div class="list">
					<div class="post default">
						<span data-color="1">?</span>
					</div>
				</div>
				<span class="hwjs warning">{tr id=MAX_COLOR}Vous avez atteint le nombre maximal de couleurs{/tr}</span>
				
				<span class="nextStep inactive" title="{tr id=STEP}Etape{/tr} 2 : {tr id=CHOOSE_IMAGE}Choisissez une image{/tr}"> {tr id=STEP}Etape{/tr} 2 ► </span>
				
				<a title="{tr id=DEMO_LINK_TITLE}demo video{/tr}" href="about.php#video" class="nextStep demolink">{tr id=DEMO_LINK_TEXT}Demo{/tr}</a>
			</div>
		</section>
		
		<section class="file hwjs">

			<h3><strong>{tr id=STEP}Etape{/tr} 2 :</strong> <br />{tr id=STEP2_TITLE}Choisissez une photo ou une image que vous voulez post-esthétiser !{/tr}</h3>
			<p>{tr id=STEP2_DESC}Vous pouvez choisir n'importe quelle image, mais sachez qu'elle ne dépassera pas plus de 30 post-it de hauteur !{/tr}</p>
			
			<div id="YourChoice" class="topBox box">
			
			</div>
			
			<form method="post" class="pushFile" action="postit.php" enctype="multipart/form-data">
				<div class="bottomBox box">
					<input type="hidden" name="MAX_FILE_SIZE" value="2097152">
					<input type="hidden" name="options" class="jsonValueColorPostIt" value="">
					<input type="hidden" name="wall_size" class="wall_size" value="20">
					<input type="file" size="55" class="fileInput" name="image"><br />
					<p>
						{tr id=UPLOAD_NOTE}Nous vous conseillons de vous baser sur une image de petite taille aux couleurs nativement réduite, 
						sous peine d'avoir un résultat très moyen.{/tr}
					</p>
					<div class="wslide">
					
						<div class="demoFuturHeight">
							<span class="profil"></span>
							<span class="futurHeight"></span>
						</div>
					
						<label>{tr id=CHOOSE_MAX_HEIGHT}Choisissez le nombre maximum de post-it de haut (1 post-it = 7,8 cm){/tr}</label>
						<p class="explainHeight"><b class="ttlHeight">156</b> {tr id=HEIGHT_INFO}cm de haut<br /> pour{/tr} <b class="nbr">20</b> {tr id=POST_IT}post-it{/tr}</p>
						<div class="slider" id="slider3"></div>
						
					</div>
				</div>
				<input type="submit" class="nextStep prevStep" value="◄ {tr id=GO_BACK}Revenir en arrière{/tr}">
				<input type="submit" class="inactive nextStep" value="{tr id=GENERATE}Générer{/tr}">
			</form>
		</section>

	
	<?php include "r/php/footer.php"; ?>
		
	</div>
</body>
</html>
