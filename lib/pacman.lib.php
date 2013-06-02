<?php

/**
*	Package Manager | Bura - Open Source Content Management System
*	------------------------------------------------------------------------
*	Copyright (C) 2013, Sergio Milardovich <smilardovich@frro.utn.edu.ar>
*	This program is Free Software.
*
*	@package	Bura
*	@license	http://www.gnu.org/copyleft/gpl.html GNU/GPL License 2.0
*	@author		Sergio Milardovich <smilardovich@frro.utn.edu.ar>
*/

class Pacman{

	var $curl_handler;
	var $pacman_repo_url;
	var $pacman_sources_list = BURA_SOURCES_LIST;
	var $pacman_tmp_path = BURA_TMP_DIR;
	var $package_type = 'apps';
	var $package_content;
	var $package_tmp_abs_path;
	var $package_url;

	function __construct(){
		global $validate;
		$buffer = explode("\n",file_get_contents($this->pacman_sources_list));
		foreach($buffer as $line){
			if(!empty($line)){
				$new_repo = explode(" ",$line);
				if($validate->isWeb($new_repo[0])){
					$repos[$new_repo[1]] = $new_repo[0];
				}
			}
		}
		$this->pacman_sources_list = $repos;
		$this->pacman_repo_url = array_shift($repos);
	}

	function selectPackage($url){
		$this->package_url = $url;
		$this->curl_handler = curl_init($this->package_url);
	}

	function selectRepo($name){
		$this->pacman_repo_url = $this->pacman_sources_list[$name];		
	}

	function downloadPackage(){
		curl_setopt($this->curl_handler, CURLOPT_RETURNTRANSFER, true);
		$this->package_content = curl_exec($this->curl_handler);
		curl_close($this->curl_handler);
		$this->package_tmp_abs_path = $this->pacman_tmp_path.basename($this->package_url);
		file_put_contents($this->package_tmp_abs_path, $this->package_content);
	}

	function unzipPackage(){
		$zip = new ZipArchive;
		if ($zip->open($this->package_tmp_abs_path) === true) {
			$zip->extractTo($this->pacman_tmp_path);
			$zip->close();
			return true;
		} else {
			return false;
		}
	}

	function searchPackage($name){
		$this->curl_handler = curl_init($this->$pacman_repo_url.'/'.$this->package_type.'/'.$name.'/package-info.xml');
		curl_exec($this->curl_handler);

		if(!curl_errno($this->curl_handler)){
			return $this->getPackageInfo($name);		
		} else {
			return false;
		}
	}

	function getPackageInfo($name){
		$this->curl_handler = curl_init($this->pacman_repo_url.'/'.$this->package_type.'/'.$name.'/package-info.xml');
		curl_setopt($this->curl_handler, CURLOPT_RETURNTRANSFER, true);
		$package_info = curl_exec($this->curl_handler);
		curl_close($this->curl_handler);

		if(!empty($package_info)){
			file_put_contents($this->pacman_tmp_path.'tmp-info-'.$name.'.xml', $package_info);
			chmod($this->pacman_tmp_path.'tmp-info-'.$name.'.xml', 0755);
			return file_get_contents($this->pacman_tmp_path.'tmp-info-'.$name.'.xml');
			unlink($this->pacman_tmp_path.'tmp-info-'.$name.'.xml');
		} else {
			die(printf(_("The package %s does not exists. Please, check your sources file."),$name));
		} 

	}

	function addRepo($url,$name){
		$this->pacman_sources_list[$name] = $url;
	}

	function placePackage($name){
		if(file_exists($this->pacman_tmp_path.$name.'.zip')){
			$this->package_tmp_abs_path = $this->pacman_tmp_path.$name.'.zip';
			$this->unzipPackage();
			Extra::rCopy($this->pacman_tmp_path.$name,BURA_SOURCE_DIR);
		}
	}



	function cleanTmpDir(){
		Extra::rmDir($this->pacman_tmp_path);
	}
	
}

?>
