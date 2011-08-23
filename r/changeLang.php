<?php

session_start();

if(isset($_GET['lang']))
{
	$_SESSION['lang'] = $_GET['lang'];
}

if(isset($_SERVER['HTTP_REFERER']))
{
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}
else
{
	header('Location: /');
}