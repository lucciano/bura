<?php

class GroupsDaemon{
	function __construct(){
		global $security;
		if(!isset($_SESSION['current_group'])){
			$_SESSION['current_group'] = 0;
			$token = $security->generateToken('group_token');
			$this->addCurrentVisitor(0,$token);
		}
	}

	function checkSection(){
		global $groups,$current_group;
		if(!$groups->hasPrivilegies('app_'.$current_app.'_main',$current_group)){
			die(_("You have no privilegies to see this section."));
		}

	}

	function addCurrentVisitor($group,$token){

	}

	function removeVisitor($token){

	}

	// Tokens should be stored on the DB
	function checkToken($token,$time,$ip=null){
		if(empty($ip)){
			$ip = $_SERVER['REMOTE_ADDR'];
		}

	}

	// This function should check all tokens and remove those who expired
	function purgeTokens(){

	}
}

?>
