<?php
/**
*	Example App | Bura - Open Source Content Management System
*	------------------------------------------------------------------------
*	Copyright (C) 2013, Sergio Milardovich <smilardovich@frro.utn.edu.ar>
*	This program is Free Software.
*
*	@package	Bura
*	@license	http://www.gnu.org/copyleft/gpl.html GNU/GPL License 2.0
*	@author		Sergio Milardovich <smilardovich@frro.utn.edu.ar>
*/

class Groups{
	function __construct(){
		$this->showSection();
	}

	function showSection(){
		switch($_GET['action']){
			case 'about':
				$this->getAboutSection();
			break;
			default:
				$this->getDefaultSection();
			break;
		}
	}

	function getDefaultSection(){
		/*
		 * If the designer followed our standards then it will probably be a "WEB_CONTENT" TPL section to be replaced.
		 * We can use the tplSet function to load it.
		 * Remember that the global var $skeleton will always have the output buffer of our website.
		 */
		global $template,$skeleton;
		$template->tplSet("WEB_CONTENT", "HALLO WELT!", $skeleton, $skeleton);
	}

	function getAboutSection(){
		global $template,$skeleton;
		$template->tplLoad(BURA_APPS_DIR.MY_APP_NAME.'/views/about.tpl', $buffer);
		$template->tplSet("WEB_CONTENT",$buffer,$skeleton,$skeleton);
	}
}
?>
