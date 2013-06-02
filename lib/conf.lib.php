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

class Conf{
	function getOption($name,&$output=false){
		global $db;
		$query = &$db->Execute("SELECT * FROM ".DB_TABLE_PREFIX."settings WHERE name = '$name'");
		if(!$query){ 
			return $db->ErrorMsg();
		} else {
			if($output == false){
				return $query;
			} else {
				$output = $query;
			}
		}
	}
	function getOptionValue($name,&$output=false){
		global $db;
		$buffer = $this->getOption($name);
		if($output == false){
			return $buffer->fields['value'];
		} else {
			$output = $buffer->fields['value'];
		}
	}
}
