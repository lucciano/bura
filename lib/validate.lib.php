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

if (!defined("BURA_BLOWS"))
	die("Bura isn't blowing! ¬¬");

class Validate{
	function isEmail($email){
		if(preg_match("/^[a-zA-Z0-9\.\-\_]*@[a-zA-Z0-9\.\-\_]*$/", $email, $matches)){
			return true;
		} else {
			return false;
		}
	}
	function isWeb($web){
		if(preg_match("/^(?:http:\/\/)?((?:[\w\-]+(?:\.[\w^_]+)+){1}\S*)$/", $web, $matches)){
			return true;
		} else {
			return false;
		}
	}
	function isImage($image){
		if(getimagesize($image) !== null){
			return true;
		} else {
			return false;
		}
	}
}
