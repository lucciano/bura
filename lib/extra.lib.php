<?php

/**
*	Extra libraries loader | Bura - Open Source Content Management System
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

class Extra {
	function loadLib($class){
		$r = new ReflectionClass($class);
		$lib = $r->newInstanceArgs();
		return $lib;
	}

	// Based on http://www.phpzag.com/php-–-delete-directory-and-content-recursively/
	function rmDir($dir){
		if (is_dir($dir)){
			$objects = scandir($dir);
			foreach ($objects as $object){
				if ($object != "." && $object != ".."){
					if (filetype($dir."/".$object) == "dir") $this->rmDir($dir."/".$object); else unlink($dir."/".$object);
				}
			}
			reset($objects);
			rmdir($dir);
		}
	} 

	function rCopy($src,$dst){ 
		$dir = opendir($src); 
		@mkdir($dst); 
		while(false !== ($file = readdir($dir)) ){ 
			if (($file != '.') && ($file != '..')){ 
				if (is_dir($src.'/'.$file)){ 
					rCopy($src.'/'.$file,$dst.'/'.$file); 
				} else { 
					copy($src.'/'.$file,$dst.'/'.$file); 
				} 
			} 
		} 
		closedir($dir); 
	} 
}

?>
