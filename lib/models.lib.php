<?php
/**
*	Simple HTTP Client
*	------------------------------------------------------------------------
*	Copyright (C) 2013, Sergio Milardovich <smilardovich@frro.utn.edu.ar>
*	This program is Free Software.
*
*	@package	Bura
*	@license	http://www.gnu.org/copyleft/gpl.html GNU/GPL License 2.0
*	@author		Sergio Milardovich <smilardovich@frro.utn.edu.ar>
*/

class Models{
	function loadModel($filename, $classname, &$usename){
		if(file_exists($filename)){
			require_once $filename;
			$usename = new $classname();
		} else if(file_exists(BURA_SOURCE_DIR.'/'.$filename)){
			require_once BURA_SOURCE_DIR.'/'.$filename;
			$usename = new $filename();
		}  else if(file_exists(BURA_SOURCE_DIR.'/'.BURA_MODELS_DIR.'/'.$filename)){
			require_once BURA_SOURCE_DIR.$filename;
			$usename = new $filename();
		} 
	}
}

?>
