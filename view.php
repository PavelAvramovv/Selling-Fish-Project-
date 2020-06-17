<?php
/*******************************************************************************
*  @Author: Pavel Avramov
*******************************************************************************/

session_start ();
error_reporting ( E_ALL ^ E_WARNING ^ E_NOTICE );

define ( 'WEB', true );
define ( 'ROOT_DIR', dirname ( __FILE__ ) );
define ( 'CORE_DIR', ROOT_DIR . '/core/' );

require_once ( CORE_DIR . 'class.database.php' );
require( CORE_DIR . 'functions.php' );
require( 'library/Rain/autoload.php' );

use Rain\Tpl;

class Template extends Tpl
{
    function __get( $key = null )
	{
        return $key ? $this->var[$key] : $this->var;
    }
    function __set( $key, $value )
	{
        $this->var[$key] = $value;
    }
}

Template::configure( $config );
Template::registerPlugin( new Tpl\Plugin\PathReplace() );

$tpl = new Template;

$tpl->title = "SMART Fish";
$tpl->version = "v1.0";
$tpl->author = "Pavel Avramov";

$var = array(
	'VersionCSS'	=> mt_rand(),
	);
$tpl->assign($var);
$tpl->draw("header");

$id = mysqli_real_escape_string($connection, $_GET['id']);

$query = mysqli_query($connection, 'SELECT l.id, l.user_id, l.time_added, l.title, l.fish_cat, l.description, l.price, l.photo_url, c.cat_button_class, c.cat_id, c.cat_name
		  FROM listings l, fish_cats c 
 WHERE l.id="' . $id . '" AND l.fish_cat = c.cat_id');
$result = mysqli_fetch_assoc($query);
if($id != $result['id'])
{
	$database->message_box(1,"Обявата не съществува!");
}
	else
{
if($id)
{
	require( CORE_DIR . 'view_fish.php' );
}
	else
	{
		echo "<meta http-equiv='refresh' content='0;url=index.php'>";
	}
}

require( CORE_DIR . 'footer.php' );
$tpl->draw("footer");
?>