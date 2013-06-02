<?php
/**
*	FTP interaction lib
*	------------------------------------------------------------------------
*	This program is Free Software.
*
*	@license	http://www.gnu.org/copyleft/gpl.html GNU/GPL License 2.0
*/
/*
abstract class Ftp{

} */

$link = ftp_connect("ftp://ftp.milardovich.com.ar") or die("ERROR");
//ftp_nlist($link,"./");

?>
