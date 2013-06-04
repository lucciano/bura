<?php

class GroupsDaemon{
	function __construct(){
		$this->addDefaultGroup();
		$this->checkSection();
	}

	function addDefaultGroup(){
		global $security;
		if(!isset($_SESSION['current_group'])){
			$_SESSION['current_group'] = 1;
			$token = $security->generateToken('group_token');
			$this->addCurrentVisitor(1,$token);
		}

	}

	function checkSection(){
		global $GroupsManagement,$current_app;
		if(!$GroupsManagement->hasPrivilegies('app_'.$current_app.'_main',$_SESSION['current_group'])){
			die(_("You have no privilegies to see this section."));
		}

	}

	function addCurrentVisitor($group,$token){
		global $db;
		$ip = $_SERVER['REMOTE_ADDR'];
		$db->Execute("INSERT INTO ".DB_TABLE_PREFIX."groups_tokens (ip,token,\"group\",time) VALUES ('$ip','$token',$group,NOW())");
	}

	function removeVisitor($token){
		global $db;
		$db->Execute("DELETE FROM ".DB_TABLE_PREFIX."groups_tokens WHERE token = $token");
	}

	// Tokens should be stored on the DB
	function checkToken($token,$time,$ip=null){
		global $db;
		if(empty($ip)){
			$ip = $_SERVER['REMOTE_ADDR'];
		}

	}

	// This function should check all tokens and remove those who expired
	function purgeTokens(){

	}
}

?>
