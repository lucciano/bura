<?php
/**
*	Simple HTTP Client
*	------------------------------------------------------------------------
*	Copyright (C) 2013, Sergio Milardovich <smilardovich@frro.utn.edu.ar>
*	This program is Free Software.
*
*	@package	Bura
*	@license	http://www.gnu.org/copyleft/gpl.html GNU/GPL License 2.0
*	@author		Sergio Milardovich <smilardovich@frro.utn.edu.ar>
*/

/*
 * This is an abstract class with generic functions to interact with cURL
 */
abstract class FormTest {

	var $fields;
	var $url;
	var $output;

	function startCurl($opts,&$buffer){
		$handler = curl_init();
		curl_setopt_array($handler, ($opts)); 
		$buffer = $handler;
	}

	function endCurl(){
		curl_close();
	}

	function makePost(){
		if(!is_array($this->fields)){
			die(_("There are no fields to parameterize"));
		}
		$fields_string = null;
		foreach($this->fields as $key=>$value){ 
			$fields_string .= $key.'='.$value.'&'; 
		}
		rtrim($fields_string, '&');
		$this->count_fields = count($this->fields);
		$this->fields = $fields_string;
	}

	// Send the post fields
	function sendPost($handler){
		$this->makePost();
		curl_setopt($handler,CURLOPT_URL, $this->url);
		curl_setopt($handler,CURLOPT_POST, $this->count_fields);
		curl_setopt($handler,CURLOPT_POSTFIELDS, $this->fields);
		$this->output = curl_exec($handler);
	}
}

?>
