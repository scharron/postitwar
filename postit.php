<?php

include("postitify.php");
include("misc.php");

$show_form = true;

if ((isset($_FILES["image"]) && isset($_POST["options"])) || isset($_GET["id"]) || isset($_GET["original"]))
{
  if (isset($_GET["original"]))
    download_original($_GET["original"]);
  if (isset($_GET["id"]))
  {
    $image = unidify($_GET["id"]);
    if (isset($_GET["download"]))
      download($image, $_GET["size"]);
  }else{
    $filename = $_FILES["image"]["tmp_name"];
    if ($_POST["options"] === "")
      $_POST["options"] = "{}";

    $_POST["options"] = stripslashes($_POST["options"]);

    $options = json_decode($_POST["options"], true);
    if (! is_uploaded_file($filename))
      print_r("file is not a valid file ;-)\n");
    if (null === $options)
      print_r($_POST["options"]);

    if (is_uploaded_file($filename) && null !== $options)
    {
      validate_colors($options["colors"], array("90-175-253", "255-195-250", "252-254-79", "196-239-170"));
      setdef($options["postit_size"], 40);
      setdef($options["resample"], true);
      setdef($options["wall_size"], 20);
      if (isset($_POST["wall_size"]))
      {
        $val = (int)$_POST["wall_size"];
        if ($val <= 0 || $val > 50)
          $val = 20;
        $options["wall_size"] = $val;
      }
      setdef($options["image_region"], "-1x-1+0+0");
      setdef($options["large"], false);
      $image = postitify($filename, $options);
    }
  }
  
  $imageUrl = 'http://postitwar.me/postit.php?id=' . idify($image);
  $_SESSION['imageUrl'] = $imageUrl;
}
elseif(isset($_SESSION['imageUrl']))
{
	header('Location: ' . $_SESSION['imageUrl']);
}
else
{
	_404();
}

?>


<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>{tr id=MAIN_TITLE}Post-it Générator !{/tr}</title>
	<link rel="meta" type="application/rdf+xml" title="FOAF" href="/foaf.rdf">
	<link href="favicon.ico" type="image/x-icon" rel="icon" />
	<link rel="stylesheet" type="text/css" href="r/css/g.css" />
	<link rel="stylesheet" type="text/css" href="r/css/result.css" />
	<link rel="stylesheet" type="text/css" href="r/css/printResult.css" media="print" />
	<script type="text/javascript" src="r/js/jq1.6.2.js"></script>
	<script type="text/javascript" src="r/js/jq.ui.1.8.15.js"></script>
	<script type="text/javascript" src="r/js/farbtastic.js"></script>
	<script type="text/javascript" src="r/js/g.js"></script>
	<script type="text/javascript" src="r/js/result.js"></script>
	<meta name="Description" content="Page de résultat ou l'image est matché avec les postits">
	<meta name="Robots" content="all">
	<meta name="Keywords" content="postit, bureau, résultat, génération, nombre, coût, post-it, investissement">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->



<?php

if ($image !== false)
{
  $show_form = false;
  $nbrLine = sizeof($image["image"]);
  $nbrCol  = sizeof($image["image"][0]);
  $largeurPatern = ($nbrCol*50)+1;
  echo "<style>\n";
  $nbrColors = sizeof($image["colors"])-1;
  for($o=0;$o<$nbrColors;$o++){
	$color[$o] = $image["colors"][$o][0].",".$image["colors"][$o][1].",".$image["colors"][$o][2];
    echo ".c".$o."{background:rgb(".$color[$o].");border:1px solid rgb(".$color[$o].");}\n";
  }
	echo "::selection{background:rgb(".$color[0].");}\n";
	echo "::-moz-selection{background:rgb(".$color[0].");}\n";
	echo "::-webkit-selection{background:rgb(".$color[0].");}\n";
	echo ".containerPostIt{width:".$largeurPatern."px;}\n";
	echo "</style>";
}

?>

<?php include "r/php/jsForGG.php"; ?>

	<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
	  {lang: 'fr'}
	</script>

	<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-25260998-1']);
	_gaq.push(['_trackPageview']);

	(function(){
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
	</script>

</head>
<body>

<?php include "r/php/ttl.php"; ?>

	<div class="head">
		<h3>{tr id=POST_IT_SIZE}Taille des post-it{/tr}</h3>
		<div class="slider" id="slider1"></div>
	</div>

<div class="wrapContainerPI">
	<div class="containerPostIt" data-largeur="<?php echo $nbrCol; ?>" sizePI="48">

	<?php /* Affichage du pattern */

	// Initialize array
	$coul = array();
	echo '<div class="origin">';
	for($a=0;$a<$nbrColors;$a++){
		echo '<div class="wPostit c'.$a.'"><div class="postit dr creatorz c'.$a.'"><span></span></div></div>';
	  $coul[$a] = 0;
	}
	echo "</div>";

	
	echo '<div class="core">';
        if (isset($image["original"]))
	  echo '<img id="original" src="'.encode_original($image["original"]).'"/>';
	
	$aleaShadow = ''; // Undefined variable line 155
	
	for($ligne=0;$ligne<$nbrLine;$ligne++){
		for($col=0;$col<$nbrCol;$col++){
			if($image["image"][$ligne][$col]!=$nbrColors){
				$droppableStateClass = " dr sh".rand(1,5)." rot".rand(1,3);
			}else{
				$droppableStateClass = " white";
			}
			echo '<div class="postit '.$aleaShadow.' c'.$image["image"][$ligne][$col].''.$droppableStateClass.'"><span>';
			if($image["image"][$ligne][$col]!=$nbrColors){echo "c".$image["image"][$ligne][$col];}
			echo '</span></div>';
			for($a=0;$a<$nbrColors;$a++){
				if($a==$image["image"][$ligne][$col]){
					$coul[$a]++;// Pour obtenir le nombre de postit par couleurs 
				}
			}
		}
		echo '<div class="clear"></div>';
	}
	echo '</div>';

	?>

	<div class="trash"></div>
	</div>
</div>

<div class="console">
	
	<div class="colLeft">
		<h3>{tr id=SHOULD_USED}Vous devrez utiliser{/tr} :</h3>
			<?php 

				$total = 0;
				for($b=0;$b<$nbrColors;$b++){
					echo '<div class="line">';
					echo isset($coul[$b]) ? '<span class="number">'.$coul[$b].'</span>' : 0;
					echo '<span class="hfp">color'.$b.' : </span>';
					echo '<div class="post c'.$b.'"><span></span></div><br />';
					echo '</div>';
					$total += $coul[$b];
				}
				$coutTotal = round($total*0.015,2);
				$TimeTotal = $total*40;
				$nombre = $TimeTotal;

				$secondes = 0;
				$minutes = 0;
				$heure = 0;

				$minutes = $nombre/60; 
				$secondes = bcmod($nombre,"60");
				$minutes = floor($minutes);

				while($secondes >= "60"){$secondes = $secondes-60;$minutes++;}
				while($minutes >= "60"){$minutes = $minutes-60;$heure++;}

				if($minutes < "10"){$minutes = "0".$minutes;}
				if($secondes < "10"){$secondes = "0".$secondes;}
				if($heure < "10"){$heure = "0".$heure;}

				$temps = $heure.":".$minutes.":".$secondes;

				echo '<div class="total">';
				echo '<h3>{tr id=COST}Vous allez coûter à votre entreprise{/tr} :</h3>';
				echo sprintf(translate('TOTAL', 'Un total de <b>%d</b> Post-it, soit <b>%d €</b> en estimant 0.015€ par post-it.'),  $total, $coutTotal);
				//echo '{tr id=TOTAL}Un total de{/tr} <b>'.$total.'</b> Post-it, soit <b>'.$coutTotal.' €</b> en estimant 0.015€ par post-it.<br />';
				//echo 'Vous devrez mettre <b>'.$temps.'</b> pour le faire (pose de scotch inclus, personne seule, en se basant sur 40 secondes par post-it)';
				echo sprintf(translate('TIME_AVG', 'Vous devrez mettre <b>%s</b> pour le faire (pose de scotch inclus, personne seule, en se basant sur 40 secondes par post-it)'),  $temps);
				echo '</div>';
			?>
			
		<div class="size block"><?php echo sprintf(translate('SIZE_AVG', 'Grille de <b>%d</b> post-it de large, <b>%d</b> de haut'), $nbrCol, $nbrLine); ?></div>
	
		
		<!--
		<div class="">
			postit.php?id=<?php echo idify($image); ?>
		</div>
		-->
		
	</div>
	<div class="colRight">
		<form action="postit.php" method="post">
			<h3>{tr id=BONUS}Bonus :{/tr}</h3>
			<div class="block">
				<label for="grid">{tr id=DISPLAY_GRID}Afficher la grille{/tr}</label>
				<input id="grid" type="checkbox">
			</div>
			
			<div class="block">
				<label for="edit">{tr id=LIVE_EDIT}Editer en live !{/tr}</label>
				<input id="edit" type="checkbox">
			</div>
			
			<!--
			<a class="reduceme" href="http://postitwar.me/postit.php?id=<?php echo idify($image); ?>">Link</a>
			<a class="reduceme" href="postit.php?id=<?php echo idify($image); ?>&download=1&size=40">Download</a>
			-->
			
                        <?php if (isset($image["original"])) { ?>
			<div class="block slideImgOriginal">
				<span>{tr id=DISPLAY_ORIGINAL}Afficher l'image originale en surrimpression{/tr}</span>
				<div class="wslide">
					<span>{tr id=TRASNPARENT}Transparent{/tr}</span><div class="slider" id="slider2"></div><span>{tr id=OPAQUE}Opaque{/tr}</span>
				</div>
			</div>
                        <?php } ?>

			<div class="block copyLink">
				<label for="urlImg">{tr id=COPY_PASTE}Copiez coller l'url de la page{/tr} :</label>
				<input id="urlImg" class="reduceme" readonly="readonly" type="text" value='<?php echo $imageUrl ?>' />
			</div>
			
			<div class="block miniature">
				<label>{tr id=PREVIEW}Aperçu miniature{/tr} :</label>
				<a href="http://postitwar.me/postit.php?id=<?php echo idify($image); ?>&download=1&size=2">
					<img src="postit.php?id=<?php echo idify($image); ?>&download=1&size=2"/>
				</a>
			</div>
			
			<div class="block last">
				<span class="nextStep print">
					{tr id=PRINT}Imprimer{/tr}
				</span>
				<a href="index.php" class="nextStep">
					{tr id=NEW_IMAGE}Une nouvelle image !{/tr}
				</a>
			</div>
			
		</form>
	
	</div>
	
	<?php
		include "r/php/footer.php";
	?>
	
</div>


<script type="text/javascript" charset="utf-8" src="http://bit.ly/javascript-api.js?version=latest&login=samuelcharron&apiKey=R_0f4c2ebe6ac9ebfc5b401a32f8e53275"></script>
<script type="text/javascript" charset="utf-8">

function bitly_answer(elt, data){
console.log(data);
   if(data.errorCode == 0 && data.results["error"] == undefined){
    elt.value = data.results[elt.value].shortUrl;
   }
}

$(function(){
  $.each($(".reduceme"), function(idx, elt){
    BitlyClient.shorten(
		elt.value, function(data){
			bitly_answer(elt,data);
		}
	);
  });
});
</script>




</body>
</html>
