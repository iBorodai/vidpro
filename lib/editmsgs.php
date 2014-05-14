<?php
require('JsHttpRequest.php');
$JsHttpRequest = new JsHttpRequest('windows-1251');	// Create main library object. You MUST specify page encoding!

//if(strpos( $_SERVER['QUERY_STRING'], 'JsHttpRequest' )===false){echo "NO REQUEST";exit('JsHttpRequest:false');}

// Store resulting data in $_RESULT array (will appear in req.responseJs).

require('mysql_db.php');
require('db_conf.php');
if(!mysql_connect($db_prm['server'],$db_prm['usn'],$db_prm['pwd'])) die('connection_error');
if(!mysql_select_db( $db_prm['db'] )  ) die('select_db_error');

$sql="SET NAMES 'cp1251'"; mysql_query($sql);

function err($t){ global $_RESULT; $_RESULT['err']='Err: '.$t; exit(); }
if( empty($_REQUEST['s']) || empty($_REQUEST['m']) || empty($_REQUEST['l']) || !isset($_REQUEST['t']) ) err('no params');

//require('session.php');
session_start($_REQUEST['s']);
if(empty($_SESSION['Jlib_auth']['u_grp'])||$_SESSION['Jlib_auth']['u_grp']!='adm') err('no auth, admin access is required');

if( strpos($_REQUEST['m'],'err.')!==0 ){
	$tab='sys_msg'; $fld='msg_id';
}else{
	$tab='sys_err'; $fld='err_id';
	$_REQUEST['m']=substr($_REQUEST['m'],4);
}

$sql="SELECT $fld FROM $tab WHERE $fld='{$_REQUEST['m']}' AND ln='{$_REQUEST['l']}'";
$res=mysql_query($sql); if(!$res) err('sql '.$sql);

$_REQUEST['t']=trim(str_replace("'",'`',$_REQUEST['t']));
if(mysql_num_rows($res)>0){
	if($_REQUEST['t']){
		$sql="UPDATE $tab SET msg='{$_REQUEST['t']}' WHERE $fld='{$_REQUEST['m']}' AND ln='{$_REQUEST['l']}'";
		$_RESULT['msg']=$_REQUEST['t'];
		$_RESULT['ok']='upd';
	}else{
		$sql="DELETE FROM $tab WHERE $fld='{$_REQUEST['m']}' AND ln='{$_REQUEST['l']}'";
		$_RESULT['ok']='del';
	}
}else{
	if($_REQUEST['t']){
		$sql="SELECT $fld FROM $tab WHERE $fld='{$_REQUEST['m']}'";
		$res=mysql_query($sql); if(!$res) err('sql '.$sql);
		if(mysql_num_rows($res)>0){
			$_RESULT['ok']='ins';
		}else{
			$_RESULT['ok']='new';
		}
	}else{
		$_RESULT['ok']='nop';
		exit();
	}
	$sql="INSERT INTO $tab SET $fld='{$_REQUEST['m']}', ln='{$_REQUEST['l']}', msg='{$_REQUEST['t']}'";
	$_RESULT['msg']=$_REQUEST['t'];
}
$res=mysql_query($sql); if(!$res) err('sql '.$sql);

//require('trace.php'); trace($_RESULT['ok'],$sql);
?>