<?php

include("structs.php");

function setdef(&$var, $val)
{
  if (! isset($var))
    $var = $val;
}

function validate_colors(&$var, $def)
{
  if (! is_array($var))
    $var = $def;

  foreach ($var as &$val)
  {
    $rgb = explode("-", $val);
    if (count($rgb) != 3)
      unset($val);
    $val = array((int)$rgb[0], (int)$rgb[1], (int)$rgb[2]);
  }
}

function segment($image)
{
  $dest = new Image(null, 0, 0, $image->rect->w, $image->rect->h);

  for ($i = 0; $i < $image->rect->w; ++$i)
  {
    for ($j = 0; $j < $image->rect->h; ++$j)
    {
      //$dest = 
    }
  }
}

function a($c)
{
  return array($c["red"], $c["green"], $c["blue"]);
}

function rgb2lab($rgb)
{
  $eps = 216/24389; $k = 24389/27;
  // reference white D50
  $xr = 0.964221; $yr = 1.0; $zr = 0.825211;

  $rgb[0] = $rgb[0]/255; //R 0..1
  $rgb[1] = $rgb[1]/255; //G 0..1
  $rgb[2] = $rgb[2]/255; //B 0..1

  // assuming sRGB (D65)
  $rgb[0] = ($rgb[0] <= 0.04045)?($rgb[0]/12.92):pow(($rgb[0]+0.055)/1.055,2.4);
  $rgb[1] = ($rgb[1] <= 0.04045)?($rgb[1]/12.92):pow(($rgb[1]+0.055)/1.055,2.4);
  $rgb[2] = ($rgb[2] <= 0.04045)?($rgb[2]/12.92):pow(($rgb[2]+0.055)/1.055,2.4);

  // sRGB D50
  $x =  0.4360747*$rgb[0] + 0.3850649*$rgb[1] + 0.1430804 *$rgb[2];
  $y =  0.2225045*$rgb[0] + 0.7168786*$rgb[1] + 0.0606169 *$rgb[2];
  $z =  0.0139322*$rgb[0] + 0.0971045*$rgb[1] + 0.7141733 *$rgb[2];

  $xr = $x/$xr; $yr = $y/$yr; $zr = $z/$zr;

  $fx = ($xr > $eps)?pow($xr, 1/3):($fx = ($k * $xr + 16) / 116);
  $fy = ($yr > $eps)?pow($yr, 1/3):($fy = ($k * $yr + 16) / 116);
  $fz = ($zr > $eps)?pow($zr, 1/3):($fz = ($k * $zr + 16) / 116);

  $lab = array();
  $lab[] = round(( 116 * $fy ) - 16);
  $lab[] = round(500*($fx-$fy));
  $lab[] = round(200*($fy-$fz));     
  return $lab;
} 

function deltaE($lab1, $lab2)
{
  // CMC 1:1
  $l = 1; $c = 1;

  $c1 = sqrt($lab1[1]*$lab1[1]+$lab1[2]*$lab1[2]);
  $c2 = sqrt($lab2[1]*$lab2[1]+$lab2[2]*$lab2[2]);

  $h1 = (((180000000/M_PI) * atan2($lab1[1],$lab1[2]) + 360000000) % 360000000)/1000000;

  $t = (164 <= $h1 AND $h1 <= 345)?(0.56 + abs(0.2 * cos($h1+168))):(0.36 + abs(0.4 * cos($h1+35)));
  $f = sqrt(pow($c1,4)/(pow($c1,4) + 1900));

  $sl = ($lab1[0] < 16)?(0.511):((0.040975*$lab1[0])/(1 + 0.01765*$lab1[0]));
  $sc = (0.0638 * $c1)/(1 + 0.0131 * $c1) + 0.638;
  $sh = $sc * ($f * $t + 1 -$f);

  return sqrt(
    pow(($lab1[0]-$lab2[0])/($l * $sl),2) +
    pow(($c1-$c2)/($c * $sc),2) +
    pow(sqrt(
      ($lab1[1]-$lab2[1])*($lab1[1]-$lab2[1]) +
      ($lab1[2]-$lab2[2])*($lab1[2]-$lab2[2]) +
      ($c1-$c2)*($c1-$c2)
    )/$sh,2)
  );
}


function hsv($c)
{
  $chroma = max($c) - min($c);
  $hh = 0;
  if ($chroma != 0)
    switch(max($c))
    {
    case $c[0]: $hh = ($c[1] - $c[2]) / $chroma % 6; break;
    case $c[1]: $hh = ($c[2] - $c[0]) / $chroma + 2; break;
    case $c[2]: $hh = ($c[0] - $c[1]) / $chroma + 4; break;
    }
  $hue = $hh * 60;
}


function postitify($filename, $options)
{
  // Use image_region if we want
  $origin = new Image($filename);
  if (! $origin->is_valid)
    return false;

  $colors = $options["colors"];

  foreach ($colors as &$color)
    if ($color == array(255, 255, 255))
      unset($color);
  $colors[] = array(255, 255, 255);


  $ratio_x = (float)$origin->rect->w / $options["wall_size"][0];
  $ratio_y = (float)$origin->rect->h / $options["wall_size"][1];
  
  $ratio_x = max($ratio_x, $ratio_y);
  $ratio_y = max($ratio_x, $ratio_y);

  if ($options["large"])
    $ratio_x *= 1.8;

  // Reduced image (pixelisation)
  $reduced = new Image(null, 0, 0, $origin->w / $ratio_x, $origin->h / $ratio_y);
  if (! $reduced->is_valid)
    return false;
}
