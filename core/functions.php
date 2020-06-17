<?php
/*******************************************************************************
*  @Author:   Pavel Avramov
*******************************************************************************/

require_once("config.php");

if(preg_match ( "/MSIE/i", getenv("HTTP_USER_AGENT") ))
{
	die("<center>Този сайт е забранил достъпа на Internet Explorer, моля използвайте Някой от следните браузъри! <br /><img src='#' alt='Firefox' /> <img src='#' alt='Google Chrome' /> <img src='#' alt='Opera' /></center>");
}

$filename = 'core/config.php';

if (file_exists($filename))
{
    return;
} else {
    echo "The file $filename does not exist";
	die();
}
?>