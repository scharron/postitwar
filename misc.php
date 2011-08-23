<?php

function compress($str)
{
  $ret = "";
  $cur_char = ' ';
  $count = 0;
  for ($i = 0; $i < strlen($str); ++$i)
  {
    if ($str[$i] != $cur_char)
    {
      if ($count > 4)
      {
        $ret .= "-" . $count . "-" . $cur_char;
      }
      else
      {
	for ($j = 0; $j < $count; ++$j)
          $ret .= $cur_char;
      }
      $count = 1;
      $cur_char = $str[$i];
    }
    else
      $count++;
  }
  if ($count > 4)
  {
    $ret .= "-" . $count . "-" . $cur_char;
  }
  else
  {
    for ($j = 0; $j < $count; ++$j)
      $ret .= $cur_char;
  }
  return $ret;
}

function decompress_cb($matches)
{
  $ret = "";
  $count = (int)$matches[1];
  for ($i = 0; $i < $count; ++$i)
    $ret .= $matches[2];
  return $ret;
}

function decompress($str)
{
  return preg_replace_callback("|-([0-9]+)-([0-9a-z])|", decompress_cb, $str);
}

$encoding_data = "0123456789abcdefghijklmnopqrstuvwxyz";

function urlify($str)
{
  $str = gzdeflate($str);
  $str = base64_encode($str);
  $str = strtr($str, "+/=", "-_,");
  return $str;
}

function deurlify($str)
{
  $str = strtr($str, "-_,", "+/=");
  $str = base64_decode($str);
  $str = gzinflate($str);
  return $str;
}

function idify($obj)
{
  global $encoding_data;
  $x = count($obj["image"]);
  $y = count($obj["image"][0]);
  $str = /*$obj["original"] . "." . */$x . "." . $y . ".";
  $tmp = array();
  foreach ($obj["colors"] as $color)
  {
    $tmp[] = implode("-", $color);
  }
  $str .= implode("_", $tmp);
  $str .= ".";

  $image_str = "";
  foreach ($obj["image"] as $row)
  {
    foreach ($row as $px)
    {
      $image_str .= $encoding_data[$px];
    }
  }

  $str .= $image_str;

  return urlify($str);
}

function unidify($str)
{
  global $encoding_data;

  $str = deurlify($str);

  $arr = explode(".", $str);
  /*$original = $arr[0];*/
  $x = $arr[0];
  $y = $arr[1];
  $color_str = $arr[2];
  $image_str = $arr[3];

  $colors = array();
  foreach (explode("_", $color_str) as $color)
  {
    $colors[] = explode("-", $color);
  }
  
  $image = array();
  for ($i = 0; $i < $x; ++$i)
  {
    $l = array();
    for ($j = 0; $j < $y; ++$j)
    {
      for ($k = 0; $k < strlen($encoding_data); ++$k)
        if ($encoding_data[$k] == $image_str[$i * $y + $j])
	  $l[] = $k;
    }
    $image[] = $l;
  }

  $obj = array("colors" => $colors, "image" => $image, "original" => $original);
  return $obj;
}

function download($image, $size)
{
  $size = (int)$size;
  if ($size <= 0)
    $size = 50;

  $x = count($image["image"]);
  $y = count($image["image"][0]);
  $im = imagecreate($y * $size, $x * $size);

  $colors = array();
  $white_idx = -1;
  foreach($image["colors"] as $color)
  {
    $colors[] = imagecolorallocate($im, $color[0], $color[1], $color[2]);
    if ($color == array(255, 255, 255))
      $white_idx = count($colors) - 1;
  }
  
  for ($i = 0; $i < $x; ++$i)
    for ($j = 0; $j < $y; ++$j)
      for ($k = 0; $k < $size; ++$k)
	for ($l = 0; $l < $size; ++$l)
	  imagesetpixel($im, $j * $size + $k, $i * $size + $l, $image["image"][$i][$j]);

  if ($white_idx != -1)
    imagecolortransparent($im, $white_idx);

  header('Content-Disposition: Attachment;filename=image.png'); 
  header('Content-Type: image/png');
  imagepng($im);
  exit;
}

function encode_original($filename)
{
  $imgbinary = fread(fopen($filename, "r"), filesize($filename));
  $filetype = filetype($filename);
  $str = 'data:image/' . $filetype . ';base64,' . base64_encode($imgbinary);
  return $str;
}

