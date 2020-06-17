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
	'VersionCSS'	=> mt_rand()
);

if(isset($_SESSION['online']) && $_SESSION['online'] === true)
{
	$sql_count_all = mysqli_query($connection, "SELECT count(id) as total FROM listings WHERE user_id = '" . $_SESSION['id'] . "'");
	$count_all = mysqli_fetch_assoc($sql_count_all);
	
    $var += array(
		"UserMoney"		=>	$_SESSION['money'],
		"UserListings"	=>	$count_all['total'],
        "UserName"		=>	$_SESSION['username']
    );
}
	else
{
    $_SESSION['online'] = false;
}
$tpl->assign($var);
$tpl->draw("header");
if(isset($_SESSION['online']) && $_SESSION['online'] === true)
{
	$tpl->draw("my_profile");
	require( CORE_DIR . 'my_profile_info.php' );
} else {
	echo '<div style="width:600px;margin-left:490px">';
	$database->message_box(1, "Не сте влезнали в акаунта си!");
	echo '</div><br />';
}
require( CORE_DIR . 'footer.php' );
$tpl->draw("footer");
?>