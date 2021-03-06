<?php
/**
*	Elemental security class | Bura - Open Source Content Management System
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

class Security{

	/*
 	 * Token functions are 'stolen' from Delos Framework
	 * Coded by Ciro Pedrini
	 * https://github.com/CPedrini/Delos/blob/master/system/core/Security.php
	 */
	function generateToken($name='default', $exp=BURA_DEFAULT_TOKEN_TIME){
		$token = md5(uniqid(microtime(), true));
		$_SESSION['tokens'][$name.'_token'] = array('token' => $token, 'time' => time() + $exp);
		return $token;
	}

	function isValidToken($name, $token){
		if(!isset($_SESSION['tokens'][$name.'_token'])){
			return false;
		}

		if($expTime > 0){
			if($_SESSION['tokens'][$name.'_token']['time'] < time()){
				return false;
			}
		}

		if($_SESSION['tokens'][$name.'_token']['token'] !== $token){
			return false;
		}	

		return true;
	}

	/*
  	 * This function should check all tokens and unset those who are expired
	 */
	function checkTokens(){
	}

	function removeToken($name){
		unset($_SESSION['tokens'][$name.'_token']);
	}
}

?>
