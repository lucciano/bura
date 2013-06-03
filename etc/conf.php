<?php
/**
*	Bura configuration file | Bura - Open Source Content Managment System
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

define("BURA_DEFAULT_ICON_THEME", "default");

/*
 * If this function is enabled Bura will force PHP to show errors.
 * Furthermore, Bura will include some scripts placed on the folder
 * devel-tools, which may help you if you are developing or testing
 * the CMS.
 */
define("BURA_TESTING_MODE", true);

/*
 * Uncomment this line if you want to disable the tplAddJS function @template.lib.php
 * This may be useful if you want to have an special version of jQuery.
 */
//define("BURA_DISABLE_JS",true);
/*
if(!defined(BURA_TESTING_MODE)){
	ini_set('display_errors','0');
} else {
	ini_set('display_errors','1');
	error_reporting(E_ALL);
} */

/*
 * This is the absolute path where Bura is installed.
 */
define("BURA_SOURCE_DIR",substr(dirname(__FILE__),0,-4).'/');

define("BURA_LIB_DIR",BURA_SOURCE_DIR.'lib/');

define("BURA_APPS_DIR",BURA_SOURCE_DIR.'apps/');

define("BURA_TEMPLATES_DIR",BURA_SOURCE_DIR.'templates/');

define("BURA_TMP_DIR",BURA_SOURCE_DIR.'tmp/');

define("BURA_CONF_DIR",BURA_SOURCE_DIR.'etc/');

define("BURA_JS_DIR",BURA_SOURCE_DIR.'js/');

define("BURA_SOURCES_LIST", BURA_CONF_DIR.'sources.list');

/*
 * This is the name of the directory where the language files are saved
 * Bura requires php-gettext to work, if you are having errrors with
 * translations, please visit http://www.php.net/gettext .
 */
define("BURA_LOCALE_DIR", BURA_SOURCE_DIR."locale/");

/*
 * If somehow we can't connect to the DB, we will try to load the following
 * language file:
 */
define("BURA_DEFAULT_LANGUAGE","en_US");


/*
 * I still don't know whether I will use an ORM or not :-(...
 */
define("BURA_MODELS_DIR", BURA_SOURCE_DIR."models");

/*
 * If the default theme is not defined yet in the database, Bura will load it from this constant
 */
define("BURA_DEFAULT_TEMPLATE", "aficionado");

define("BURA_DEFAULT_TOKEN_TIME", 60*60*2); // Default token session time = two hours

?>
