<?php

/**
*	Template engine | Bura - Open Source Content Management System
*	------------------------------------------------------------------------
*	Copyright (C) 2013, Sergio Milardovich <smilardovich@frro.utn.edu.ar>
*	This program is Free Software.
*
*	@package	Bura
*	@license	http://www.gnu.org/copyleft/gpl.html GNU/GPL License 2.0
*	@author		Sergio Milardovich <smilardovich@frro.utn.edu.ar>
*/

class Template{

	var $JSQueue;

	function tplLoad($file, &$buffer, $cache=false, $search=false){
		if(file_exists($file)){
			$buffer = file_get_contents($file);
		} else {
			die(printf(_("The requested file (%s) does not exists"),$file));
		}
	}

	function tplSet($pattern, $replace, $buffer, &$buffer){
		if(!is_array($pattern)){
			$buffer = preg_replace("/{".$pattern."}/", $replace, $buffer);			
		} else {
 			foreach($pattern as $key => $value) {
   				$buffer = preg_replace("/{".$key."}/", $value, $buffer);
			}
		}
	}

	function tplFindConstants($buffer, &$buffer){
		$buffer = preg_replace_callback('/\{=const\(([\w\-]+)\)\}/', create_function('$constant', 'return constant($constant[1]);'), $buffer);
	}

	function tplFindIncludes($buffer, &$buffer){
		// The regex... (hacerla con callback me costó un huevo y medio)
		if(preg_match('/\{=include\((.*)\)\}/', $buffer, $matches)){
			if(file_exists($matches[1])){
				$buffer = preg_replace_callback('/\{=include\((.*)\)\}/', create_function('$file', 'return file_get_contents($file[1]);'), $buffer);
			} else {
				die(printf(_("The requested file (%s) does not exists"),$matches[1]));
			}
		}
	}

	function tplFindConfValues($buffer, &$buffer){
		global $conf;
		if(preg_match_all('/\{=conf\(([\w\-]+)\)\}/', $buffer, $matches, PREG_SET_ORDER)){
			for ($i=0; $i<count($matches); $i++) {
               			$buffer = str_replace($matches[$i][0],$conf->getOptionValue($matches[$i][1]),$buffer);
        		}
		}
	}

	function tplFindConditionals($buffer,&$buffer){
		if(preg_match_all('|<!--\s*if\s*\((.+)\)\s*-->(.*)<!--\s*endif\s*-->|Uis', $buffer, $matches, PREG_SET_ORDER)){
		  $i=0;
		  foreach($matches as $match){
			$clauses = explode(" ",$match[1]);
			$conditional_buffer = null;
			switch($clauses[1]){
				case '==':
				if(eval("return ".$clauses[0].";") == eval("return ".$clauses[2].";")){
					$conditional_buffer = $match[2];
				}
				break;
				case '!==':
				if(eval("return ".$clauses[0].";") !== eval("return ".$clauses[2].";")){
					$conditional_buffer = $match[2];
				}
				break;
				case '>':
				if(eval("return ".$clauses[0].";") > eval("return ".$clauses[2].";")){
					$conditional_buffer = $match[2];
				}
				break;
				case '<':
				if(eval("return ".$clauses[0].";") < eval("return ".$clauses[2].";")){
					$conditional_buffer = $match[2];
				}
				break;
				case '<=':
				if(eval("return ".$clauses[0].";") <= eval("return ".$clauses[2].";")){
					$conditional_buffer = $match[2];
				}
				break;
				case '>=':
				if(eval("return ".$clauses[0].";") >= eval("return ".$clauses[2].";")){
					$conditional_buffer = $match[2];
				}
				break;
		      }


			$buffer = str_replace($matches[$i][0],$conditional_buffer,$buffer);
			$this->tplCompile($conditional_buffer,$result);
			unset($conditional_buffer);
		    $i++;
		  }
		}
	}

	function tplAddToJSQueue($name,$url){
		$this->JSQueue[$name] = $url;
	}

	function tplAddJS($url,$buffer,&$buffer){
		if(!defined("BURA_DISABLE_JS")){
			foreach($this->JSQueue as $name => $url){
				if(preg_match_all('/\<head\>/',$buffer,$matches,PREG_SET_ORDER)){
					$buffer = str_replace($matches[0][0], $matches[0][0]."\n".'<script stype="text/javascript" src="'.$url.'"></script>'."\n",$buffer);
				}
			}
		}
	}

	function tplCompile($buffer,&$buffer){
		$this->tplFindConstants($buffer,$buffer);
		$this->tplFindConfValues($buffer,$buffer);
		$this->tplFindIncludes($buffer,$buffer);
	}
}

?>
