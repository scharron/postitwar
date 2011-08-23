<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>{tr id=MAIN_TITLE}Post-it Générator !{/tr}</title>
	<link href="favicon.ico" type="image/x-icon" rel="icon" />
	<link rel="stylesheet" type="text/css" href="r/css/g.css" />
	<link rel="stylesheet" type="text/css" href="r/css/about.css" />
	<script type="text/javascript" src="r/js/jq1.6.2.js"></script>
	<script type="text/javascript" src="r/js/jq.ui.1.8.15.js"></script>
	<script type="text/javascript" src="r/js/farbtastic.js"></script>
	<meta name="Description" content="A propos du post-it générator">
	<meta name="Robots" content="all">
	<meta name="Keywords" content="postit, générator, générateur, post, it, propos">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<?php include "r/php/jsForGG.php"; ?>
	
</head>
<body>

	<div class="container">
	<?php include "r/php/ttl.php"; ?>
	
		<img class="example" src="r/panda.png" width="768" height="343" alt="{tr id=EXAMPLE_IMG_ALT}Exemple d'application concréte du générateur{/tr}" />
		<div class="clear"></div>
		<p>
			{tr id=ABOUT_1}<a href="http://www.lavoixeco.com/actualite/Secteurs_activites/Commerces_et_Distribution/2011/08/20/article_guerre-des-post-it-apres-les-fenetres-qu.shtml">Phénomène à la mode</a>, 
			la post-it war consiste a coller sur les fenêtres (ou mur) de son entreprise des motifs de post-it, 
			et de surenchérir par rapport a ses voisins !{/tr}
		</p>
		<p>
			{tr id=ABOUT_2}Le <b>post-it war générator</b> est l'outil qui va vous permettre de remporter cette guerre haut la main !
			Choisissez le logo ou le pixel art de votre choix et transformer le automatiquement en une mosaïque de post-it aux dimensions concrétement applicable facilement !{/tr}
		</p>
		<p>	
			{tr id=ABOUT_3}Personne n'est oublié dans le monde de l'entreprise, car vous pourrez {/tr}
		</p>
		<p>
			{tr id=ABOUT_4}Evidemment, ce serait présomptueux d'affirmer que ce service est parfait... Aussi, 
			voici les questions que vous pouvez vous posez, et leur réponses :{/tr}
		</p>
		
		<ul>
			<li style="text-align:center;" id="video">
				<span class="ask">{tr id=QUESTION_1}Pour commencer... :{/tr}</span>
				<div>
				<object width="480" height="390"><param name="movie" value="http://www.youtube.com/v/tPKEpBInX8E?version=3&amp;hl=fr_FR&amp;rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/tPKEpBInX8E?version=3&amp;hl=fr_FR&amp;rel=0" type="application/x-shockwave-flash" width="480" height="390" allowscriptaccess="always" allowfullscreen="true"></embed></object>
				</div>
			</li>
			<li>
				<span class="ask">{tr id=QUESTION_2}Mon image est toute blanche ?{/tr}</span>
				<span class="answer">
					{tr id=ANSWER_2}C'est probablement que la couleur de vos post-it étaient trop clairs, et
					que ceux-ci n'ont pas put reconnaitre les zones sombres de votre image qui ne devaient
					présenter que des zones sombres. Notre algorithme est imparfait mais la vie est ainsi !{/tr}
				</span>
			</li>
			<li>
				<span class="ask">{tr id=QUESTION_3}Comment faire pour avoir un rendu nickel ?{/tr}</span>
				<span class="answer">
					{tr id=ANSWER_3}Choisissez des images petites, aux tons contrastés, et de préférences avec des post-its aux
					couleurs proches :){/tr}
				</span>
			</li>
			<li>
				<span class="ask">{tr id=QUESTION_4}Le site rame abominablement !{/tr}</span>
				<span class="answer">
					{tr id=ANSWER_4}C'est vrai. Plus vous mettrez une dimension monstrueuse, plus il ramera :s{/tr}
				</span>
			</li>
			<li>
				<span class="ask">{tr id=QUESTION_5}Et si je veux poser une question qui n'est pas présente dans la FAQ ?{/tr}</span>
				<span class="answer">
					{tr id=SEND_EMAIL}Envoyez moi un e-mail{/tr} : <a href="mailto:webmaster@simonertel.net">webmaster@simonertel.net</a> :)
				</span>
			</li>

		</ul>
		
	<?php include "r/php/footer.php"; ?>
	</div>

</body>
</html>
