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
  }
  else
  {
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
      setdef($options["wall_size"], array(20, 20));
      setdef($options["image_region"], "-1x-1+0+0");
      setdef($options["large"], false);
      $image = postitify($filename, $options);
    }
  }
}
?>


<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Post-It Wall Generator</title>
	<link rel="meta" type="application/rdf+xml" title="FOAF" href="/foaf.rdf">
	<link href="favicon.ico" type="image/x-icon" rel="icon" />
	<link rel="stylesheet" type="text/css" href="r/css/g.css" />
	<link rel="stylesheet" type="text/css" href="r/css/result.css" />
	<script type="text/javascript" src="r/js/jq1.6.2.js"></script>
	<script type="text/javascript" src="r/js/jq.ui.1.8.15.js"></script>
	<script type="text/javascript" src="r/js/farbtastic.js"></script>
	<script type="text/javascript" src="r/js/g.js"></script>
	<script type="text/javascript" src="r/js/result.js"></script>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->



<?php

if ($image !== false)
{
  $show_form = false;
  $nbrLine = sizeof($image["image"]);
  $nbrCol  = sizeof($image["image"][0]);
  $largeurPatern = $nbrCol*50;
  echo "<style>\n";
  $nbrColors = sizeof($image["colors"])-1;
  for($o=0;$o<$nbrColors;$o++){
	$color[$o] = $image["colors"][$o][0].",".$image["colors"][$o][1].",".$image["colors"][$o][2];
    echo ".c".$o."{background-color:rgb(".$color[$o].");border:1px solid rgb(".$color[$o].");}\n";
  }
	echo "::selection{background:rgb(".$color[0].");}\n";
	echo "::-moz-selection{background:rgb(".$color[0].");}\n";
	echo "::-webkit-selection{background:rgb(".$color[0].");}\n";
	echo ".containerPostIt{width:".$largeurPatern."px;}\n";
	echo "</style>";
}

?>


</head>
<body>

<?php include "r/php/ttl.php"; ?>

	<div class="head">
		<h3>Taille des post-it</h3>
		<div class="slider" id="slider1"></div>
	</div>

<div class="containerPostIt" data-largeur="<?php echo $nbrCol; ?>" sizePI="48">

<img id="original" src="<?php echo encode_original($image["original"]); ?>"/>

<?php /* Affichage du pattern */

// Initialize array
$coul = array();
for($a=0;$a<$nbrColors;$a++)
  $coul[$a] = 0;

for($ligne=0;$ligne<$nbrLine;$ligne++){
	for($col=0;$col<$nbrCol;$col++){
		if($image["image"][$ligne][$col]!=$nbrColors){$droppableStateClass = " dr sh".rand(1,5)." rot".rand(1,3);}else{$droppableStateClass = " white";}
		echo '<div class="postit '.$aleaShadow.' c'.$image["image"][$ligne][$col].''.$droppableStateClass.'"><span></span></div>';
 		for($a=0;$a<$nbrColors;$a++){
			if($a==$image["image"][$ligne][$col]){
				$coul[$a]++;// Pour obtenir le nombre de postit par couleurs 
			}
		}
	}
}


?>
</div>

<div class="console">
	
	<div class="colLeft">
		<h3>Vous devrez utiliser :</h3>
			<?php 

				$total = 0;
				for($b=0;$b<$nbrColors;$b++){
					echo '<div class="line">';
					echo isset($coul[$b]) ? $coul[$b] : 0;
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
				
				
				echo '<div class="total">Un total de <b>'.$total.'</b> Post-it, soit <b>'.$coutTotal.' €</b> en estimant 0.015€ par post-it.<br />';
				echo 'Vous devrez mettre <b>'.$temps.'</b> pour le faire (pose de scotch inclus, personne seule, en se basant sur 40 secondes par post-it)';
				echo '</div>';
			?>
			
			<div class="size block">Grille de <?php echo "<b>".$nbrCol."</b> post-it de large, <b>".$nbrLine."</b> de haut "; ?></div>
			
	</div>
	<div class="colRight">
		<form action="postit.php" method="post">
			<h3>Bonus :</h3>
			<div class="block">
				<label for="grid">Afficher la grille</label>
				<input id="grid" type="checkbox">
			</div>
			
			<div class="block">
				<label for="edit">Editer en live !</label>
				<input id="edit" type="checkbox">
			</div>
			
			<!--
			<a class="reduceme" href="http://annuaireblogbd.com/postitwar/postit.php?id=<?php //echo idify($image); ?>">Link</a>
			<a class="reduceme" href="postit.php?id=<?php //echo idify($image); ?>&download=1&size=40">Download</a>
			-->
			
			<div class="block slideImgOriginal">
				<span>Afficher l'image originale en surrimpression</span>
				<div class="wslide">
					<span>Transparent</span><div class="slider" id="slider2"></div><span>Opaque</span>
				</div>
			</div>
			
			<div class="block">
				<img src="postit.php?id=<?php echo idify($image); ?>&download=1&size=2"/>
			</div>
			
			<div class="block copyLink">
				<label for="urlImg">Copiez coller l'url de la page :</label>
				<input id="urlImg" readonly="readonly" type="text" value='http://annuaireblogbd.com/postitwar/postit.php?id=<?php echo idify($image); ?>&download=1&size=2' />
			</div>
			
		</form>
	
	</div>
	
</div>

<!--
<script type="text/javascript" charset="utf-8" src="http://bit.ly/javascript-api.js?version=latest&login=samuelcharron&apiKey=R_0f4c2ebe6ac9ebfc5b401a32f8e53275"></script>
<script type="text/javascript" charset="utf-8">

function bitly_answer(elt, data){
  elt.href = data.results[elt.href].shortUrl;
}

$(function(){
  $.each($(".reduceme"), function(idx, elt){
    BitlyClient.shorten(elt.href, function(data){ bitly_answer(elt, data); });
  });
});
</script>
-->



</body>
</html>
