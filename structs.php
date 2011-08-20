<?php


class Rect
{
  function __construct($x, $y, $w, $h)
  {
    $this->x = $x;
    $this->y = $y;
    $this->w = $w;
    $this->h = $h;
  }
  var $x, $y, $w, $h;
}

function create_from($filename)
{
  $type = exif_imagetype($filename);
  switch ($type)
  {
  case IMAGETYPE_GIF: $handle = imagecreatefromgif($filename); break;
  case IMAGETYPE_JPEG: $handle = imagecreatefromjpeg($filename); break;
  case IMAGETYPE_PNG: $handle = imagecreatefrompng($filename); break;
  }
  return $handle;
}

class Image
{
  function __construct($filename, $x = 0, $y = 0, $w = -1, $h = -1)
  {
    $this->filename = $filename;
    $this->is_valid = true;

    if ($filename !== null)
    {
      $handle = create_from($filename);

      if ($handle === false)
      {
	$this->is_valid = false;
	return;
      }
      $rw = imagesx($this->handle);
      $rh = imagesy($this->handle);
      $this->data = array();
      for ($i = 0; $i < $rw; ++$i)
      {
	$col = array();
	for ($j = 0; $j < $rh; ++$j)
        {
	  $color = imagecolorat($reduced->handle, $j, $i);
	  $rgb = imagecolorsforindex($reduced->handle, $color);
	  $col[] = array($rgb["red"], $rgb["green"], $rgb["blue"]);
        }
        $this->data[] = $col;
      }
      $this->w = $rw;
      $this->h = $rh;
    }
    else
    {
      for ($i = 0; $i < $w; ++$i)
      {
	$col = array();
	for ($j = 0; $j < $h; ++$j)
        {
	  $col[] = array(255, 255, 255);
        }
        $this->data[] = $col;
	$this->w = $w;
	$this->h = $h;
      }
    }
  }

  var $filename;
  var $data;
  var $is_valid;
  var $w;
  var $h;
}
