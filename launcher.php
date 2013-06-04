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

require_once 'etc/conf.php';
require_once 'etc/db.php';

/*
 * Import the XML parser
 */
require_once BURA_LIB_DIR.'/third_party/xml2array.php';

/*
 * Link to the database
 */ 
require_once BURA_LIB_DIR.'third_party/adodb/adodb.inc.php';
$db = NewADOConnection(DB_DRIVER);
$db->Connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

/*
 * Create the settings global variable
 */
require_once BURA_LIB_DIR.'conf.lib.php';
$conf = new Conf;

/*
 * Create the template global variable
 */
require_once BURA_LIB_DIR.'template.lib.php';
$template = new Template;

/*
 * Load extra goodies
 */
require_once BURA_LIB_DIR.'extra.lib.php';

/*
 * Set the Gettext language options
 */
$conf->getOptionValue('language',$lang);
if(empty($lang)){
	$lang = BURA_DEFAULT_LANGUAGE;
}

/*
 * Set the language working directory
 */
putenv('LC_ALL='.$lang);
setlocale(LC_ALL, $lang);
bindtextdomain("bura-cms", BURA_LOCALE_DIR);
textdomain("bura-cms");

// Just for now, we will just use a default layout
$layout = 'default';

/*
 * Load default template skeleton
 */
$conf->getOptionValue('template_name',$template_name);
if(empty($template_name)){
	$template_name = BURA_DEFAULT_TEMPLATE;
}

/*
 * Load the validation library
 */
require_once BURA_LIB_DIR.'validate.lib.php';
$validate = new Validate;

require_once BURA_LIB_DIR.'pacman.lib.php';
$pacman = new Pacman;
$pacman->pacman_tmp_path = BURA_TMP_DIR;

/*
 * Load applications manager
 */
require_once BURA_LIB_DIR.'appman.lib.php';
$appman = new Appman;

/*
 * Load security class
 */
require_once BURA_LIB_DIR.'security.lib.php';
$security = new Security;

/*
 * Small test to require a package dependences
 */
/*require_once BURA_LIB_DIR.'package.lib.php';
$package = new Package();
$package->selectPackage('test-package');
echo var_dump($package->checkDependences());*/


define("BURA_ABS_TEMPLATE_PATH", BURA_TEMPLATES_DIR.$template_name.'/');
define("BURA_TEMPLATE_PATH", $conf->getOptionValue('siteurl').'/'.str_replace(BURA_SOURCE_DIR,'',BURA_TEMPLATES_DIR).$template_name.'/');

$template->tplLoad(BURA_TEMPLATES_DIR.BURA_DEFAULT_TEMPLATE.'/layouts/'.$layout.'/framework.tpl', $skeleton);

// Javascript load test
$template->tplAddToJSQueue("jQuery","http://code.jquery.com/jquery-2.0.0.min.js");
$template->tplAddToJSQueue("ajaxForm",BURA_JS_DIR.'ajaxForm.js');

$template->tplCompile($skeleton,$skeleton);

if(defined('BURA_TESTING_MODE')){
	require_once BURA_CONF_DIR.'dev-tools/checklibs.php';
}

$current_app = $conf->getOptionValue('default_app');
if(isset($_GET['app'])){
	if(file_exists(BURA_APPS_DIR.$_GET['app'].'/controllers/main.php') && ($appman->isActiveApp($_GET['app']) == true)){
		$current_app = $_GET['app'];
	}
}

define('CURRENT_APP_PATH',BURA_APP_DIR.$current_app);

/*
 * Check all active apps and require all extra libraries
 */
$active_apps = json_decode($conf->getOptionValue('active_apps'));
foreach($active_apps->activeApps as $active_app){
	if(!empty($load_libs)){
		unset($load_libs);
	}
	if(file_exists(BURA_APPS_DIR.$active_app->path.'/models/extra.php')){
		require_once BURA_APPS_DIR.$active_app->path.'/models/extra.php';
		if(is_array($extra_libs)){
			foreach($extra_libs as $extra_lib => $libfile){
				if(file_exists(BURA_APPS_DIR.$active_app->path."/controllers/".$libfile)){
					require_once BURA_APPS_DIR.$active_app->path."/controllers/".$libfile;
					eval("\$$extra_lib = Extra::loadLib(ucfirst($extra_lib));");
				}
			}
		}
	}
}

$app = $appman->loadApp($current_app);

$db->close();
// This should be always the last action in this file
echo $skeleton;

// Primitive debugging
echo var_dump($_REQUEST);
?>
