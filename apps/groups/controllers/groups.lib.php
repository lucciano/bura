<?php

class GroupsManagement{
	function __construct(){
	}

	function hasPrivilegies($action,$group){
		global $db;
		$check = $db->Execute("SELECT * FROM ".DB_TABLE_PREFIX."groups_actions WHERE name = '$action'");
		$action_id = $check->fields['ID'];
		$query = $db->Execute("SELECT * FROM ".DB_TABLE_PREFIX."groups_assoc WHERE action_id = $action_id AND group_id = $group");
		if($query->RecordCount() == 0){
			return false;
		} else {
			return true;
		}
	}
}
?>
