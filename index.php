<?

function getmicrotime($elapsed=false){
    list($usec, $sec) = explode(" ", microtime());
    $tm = ((float)$usec + (float)$sec);
    if ($elapsed) return $tm-$GLOBALS['jl_time_start'];
    else return $tm;
}
define ('DEBUG',0); // 3-extended debug
define ('MSG_LEVEL',0);
define ('Jlib_USE_CACHE',0);
define ('Jlib_USE_PHP_REG',1);
define ('Jlib_USE_USER_REG',0);
//Константы РПД
define ('accR',32);
define ('accW',16);
define ('accC',8);
define ('accD',4);
define ('accM',2);
define ('accI',1);

//Переброс на www
if( 1==3 && substr($_SERVER['HTTP_HOST'], 0, 4)!='www.' && strpos($_SERVER['REQUEST_URI'], 'admin')===false ){
 	header('HTTP/1.1 301 Moved Permanently');
	header('Location: http://www.'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	exit();
}
//Переброс на старый сайт
if( strpos($_SERVER['REQUEST_URI'], 'ukr')!==false || strpos($_SERVER['REQUEST_URI'], 'eng')!==false ){
 	header('HTTP/1.1 301 Moved Permanently');
	header('Location: http://old.grani-t.com.ua'.$_SERVER['REQUEST_URI']);
	exit();
}

ini_set('default_charset','utf-8');

if (isset($_POST["PHPSESSID"]))		{	session_id($_POST["PHPSESSID"]);	}
elseif (isset($_GET["PHPSESSID"])){ session_id($_GET["PHPSESSID"]);		}
session_start();
//echo '<pre class="debug">'.print_r ( $_SESSION['Jlib_auth'] ,true).'</pre>';
require "lib/jlib.php";
require 'lib/system.php';
require 'lib/suppliers.php';
require 'lib/controls.php';
require 'lib/project.php';
require 'lib/cache.php';
require 'lib/foursquare.php';
$jl_time_start=getmicrotime();

// use cache
if (Jlib_USE_CACHE && $_SERVER['REQUEST_METHOD']!='POST'){
	$cf='lib/cache/' . $_SERVER['QUERY_STRING'];
	if (file_exists($cf))
		echo file_get_contents($cf);
	else
		$GLOBALS['Jlib_need_cache']=$cf;
}

if (!Jlib_USE_CACHE || !empty($GLOBALS['Jlib_need_cache'])){
	if(!empty($_REQUEST['JsHttpRequest'])){
		require_once "lib/JsHttpRequest.php";
		$JsHttpRequest = new JsHttpRequest("utf-8");
		$GLOBALS['result']=&$_RESULT;
		define('AJAX',true);
	}else define('AJAX',false);
	// создали сайт
	$site=new site();
	
	// сделали все включения
	while (!$site->load()) {
		while ($inc=inc()) {
			include_once($inc);
		}
	} ;

	// сделали все включения и пропарсили до полного удовлетворения
	while (!$site->get_parsed()) {
		while ($inc=inc()) {
			include_once ($inc);
		}
	} ;
	$_SESSION['tiny_mce']=!empty($_SESSION['Jlib_auth']['admin_auth']);
	// Ну и коронный номер на бис:	
	$site->show();
}
?>