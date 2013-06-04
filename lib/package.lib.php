<?php

/**
*	Single package administration class | Bura - Open Source Content Management System
*	------------------------------------------------------------------------
*	Copyright (C) 2013, Sergio Milardovich <smilardovich@frro.utn.edu.ar>
*	This program is Free Software.
*
*	@package	Bura
*	@license	http://www.gnu.org/copyleft/gpl.html GNU/GPL License 2.0
*	@author		Sergio Milardovich <smilardovich@frro.utn.edu.ar>
*/

if (!defined("BURA_BLOWS"))
	die("Bura isn't blowing! ¬¬");

class Package{

	var $package;
	var $package_info;
	var $package_type = 'apps';

	function selectPackage($package){
		$this->package = $package;
	}

	function checkDependences(){
		global $pacman;
		$pacman->package_type = $this->package_type;
		$this->package_info = $pacman->getPackageInfo($this->package);
		$buffer = xml2array($this->package_info);
		return $buffer['package']['dependences']['package'];
	}

}

?>
