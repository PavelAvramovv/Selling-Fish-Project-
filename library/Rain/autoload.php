<?php
if(!defined("BASE_DIR"))
    define("BASE_DIR", dirname( dirname(__DIR__) ) );

spl_autoload_register( "RainTplAutoloader" );


function RainTplAutoloader( $class ){

    if (strpos($class,'Rain\\Tpl') !== false){

        $path = str_replace("\\", DIRECTORY_SEPARATOR, $class );

        $abs_path = BASE_DIR . "/library/" . $path . ".php";

        if (!file_exists($abs_path)) {
            echo "<br />";
            echo $path;
            echo "<br />";
            echo $abs_path;
            echo "<br /><br />";
        }

        require_once $abs_path;
    }

}