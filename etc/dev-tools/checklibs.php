<?php
/**
*	Bura - Open Source Content Management System
*	------------------------------------------------------------------------
*	Copyright (C) 2013, Sergio Milardovich <smilardovich@frro.utn.edu.ar>
*	This program is Free Software.
*
*	@package	Bura
*	@license	http://www.gnu.org/copyleft/gpl.html GNU/GPL License 2.0
*	@author		Sergio Milardovich <smilardovich@frro.utn.edu.ar>
*/

$warns = null;
if(!in_array('curl', get_loaded_extensions())){
	$warns[] = _("Curl is not supported!. The package manager won't work.");
}

if(!in_array('zip', get_loaded_extensions())){
	$warns[] = _("Zip extension is not installed!. You won't be able to install new packages using Pacman.");
}

if(!in_array('xmlreader', get_loaded_extensions())){
	$warns[] = _("You have no XML reader. You won't be able to use Pacman.");
}

if(!empty($warns)){
	echo var_dump($warns);
}
?>
