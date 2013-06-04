<?php

/**
*	Application Manager | Bura - Open Source Content Management System
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

class Appman{
	function loadApp($name){
		if(!file_exists(BURA_APPS_DIR.$name.'/controllers/main.php')){
			die(printf(_("Sorry, we found no main controller for the app %s. Load process aborted."),$name));
		}
		if(file_exists(BURA_APPS_DIR.$name.'/models/constants.php')){
			require_once BURA_APPS_DIR.$name.'/models/constants.php';
		}

		Appman::checkAppInstallation($name);

		require_once BURA_APPS_DIR.$name.'/controllers/main.php';
		$app = Extra::loadLib(ucfirst($name));

	}

	function isActiveApp($name){
		global $conf;
		$query = json_decode($conf->getOptionValue('active_apps'));
		$found = false;
		foreach($query->activeApps as $app){
			if($app->name == ucfirst($name)){
				$found = true;
				$this->checkAppInstallation($name);
				break;
			}
		}
		return $found;
	}

	function checkAppInstallation($name){
		global $conf;
		$query = json_decode($conf->getOptionValue('installed_apps'));
		$found = false;
		foreach($query->installedApps as $app){
			if($app->name == ucfirst($name)){
				$found = true;
				break;
			}
		}

		if(!$found){
			if(file_exists(BURA_APPS_DIR.$name.'/controllers/install.php')){
				require_once BURA_APPS_DIR.$name.'/controllers/install.php';
				$install = new Install();
				$this->addInstalledApp($name);
			}
		}
	}

	function getInstalledApps(){
		global $conf;
		return json_decode($conf->getOptionValue('installed_apps'));
	}

	function getActiveApps(){
		global $conf;
		return json_decode($conf->getOptionValue('active_apps'));
	}

	function addInstalledApp($name){
		global $db;

		$buffer = new stdClass();
		$buffer->name = ucfirst($name);
		$buffer->path = $name;

		$installed_apps = $this->getInstalledApps()->installedApps;

		array_push($installed_apps,$buffer);

		$buffer = new stdClass();
		$buffer->installedApps = $installed_apps;
	
		$update['value'] = json_encode($buffer);
		$update['date_modified'] = time();
		$rs = $db->Execute("SELECT * FROM ".DB_TABLE_PREFIX."settings WHERE name = 'installed_apps'"); 
		$db->Execute($db->GetUpdateSQL($rs, $update)); 
	}

	function removeInstalledApp($name){
		return false;
	}
}

?>
