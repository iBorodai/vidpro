<?
$dfh=false;
function debug_e($txt){
	return true;
	global $dfh;
	//echo '<div style="display:none">'.txt.'</div>';
	if(!$dfh) $dfh=fopen('lib/debug_log.txt','w');
	fwrite($dfh,"\n$txt");
}
class site_sd extends sd {
	function noaccess($obj) {
		return $_SESSION['Jlib_auth'];
	}
	
	function already_auth(){
	  if(!empty($_SESSION['Jlib_auth'][$this->params['name']])){
	    //echo '<pre class="debug">'.print_r ( $_SESSION['Jlib_auth'] ,true).'</pre>';
			return true;
		};
	}
	
	function check_auth($data) {
		$db=init_db(); if(!$db) return false;

		$login=str_replace("'",'',str_replace(';','',$data['usr']));
//		$sql="SELECT acc_subj,u_id,u_email,u_nick,LOWER(u_url) u_url,u_grp,u_img,u_name,u_sname,u_twitter,u_showtwit,u_maketwit,u_country,u_city,u_gender,u_birth,u_phone,u_sms,u_smoke,u_alcohol,u_lifestyle,u_about,u_musicstyles,u_last_login,u_pwd,u_id,u_nub,u_weight,u_bg,u_bg_mod FROM usr where u_lock='' AND u_grp!='fdj' AND  (u_nick='$login' OR u_email='$login')";
		$sql="SELECT * FROM user where u_email='$login'";

		if(!$usr) return false;

		if ($usr['u_pwd']!=$data['pwd']) return false;
		if(!empty($usr['u_lock'])){
			set_error_ex('user_locked',USR_MSG);
			return false;
		}

		$auth_groups=array(
			'admin'=>array('site_auth','admin_auth'),
			'saller'=>array('site_auth'),
			'vendor'=>array('site_auth'),
		);
		$acc=array(
		  'site_auth'=>false,
		  'manager_auth'=>false,
		  'admin_auth'=>false,
		);
		foreach($auth_groups[ $usr['u_grp'] ] as $descriptor)	$acc[$descriptor] = 1;

		if (!$acc[$this->params['name']]) return false;
		//$GLOBALS['auth_login_id']=$usr['u_id']; $GLOBALS['auth_login_subj']=$usr['acc_subj'];
		// success. Store last in date
		$sql="UPDATE usr SET u_last_login='" . date('YmdHis') . "' WHERE u_id='$usr[u_id]'";
		$db->query($sql);

		// correct date
		if (substr($usr['u_last_login'],0,4)=='0000') $usr['u_last_login']=date('d.m.Y');
		else $usr['u_last_login']= date('d.m.Y',strtotime($usr['u_last_login']));

		// store user data
		unset ($usr['u_pwd']);

		switch($usr['u_grp']){
		  case 'saller':
		    $sql="SELECT * FROM sallers WHERE s_id=".$usr['u_key_subj'];
		    $add=$db->query_row($sql);
		    break;
		  case 'vendor':
		    $sql="SELECT * FROM vendors WHERE v_id=".$usr['u_key_subj'];
		    $add=$db->query_row($sql);
		    break;
		  default: $add=array();
		}
		$usr=array_merge($usr, $add);
		
		$_SESSION['Jlib_auth']=$usr;
		$_SESSION['Jlib_auth']=array_merge($_SESSION['Jlib_auth'],$acc);
		return true;
	}
}

class undercon extends sd {
	function access($obj) {
		return $_SESSION['Jlib_udc'];
	}
	function already_auth() {
	  if(
	    1==3 &&
			in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1','192.168.0.237'))
		)
		$_SESSION['Jlib_udc']=true;
		return !empty($_SESSION['Jlib_udc']);
	}
	function check_auth($data) {
		if ($data['usr']=='uStudio' && $data['pwd']=='underCon') {
			$_POST=array();
			return $_SESSION['Jlib_udc']=true;
		}
		else return false;
	}
}

class passreminder extends form{
	function init(){
		if(empty($this->params['short'])){	// вызвано не возле короткой формы логина, а в теле страницы
			if( empty($_GET['k']) ) redirect($this->get_url('Jlib_target=default'));
			else{

				// если стоял таймер и он не прошел - продлить таймер и отфутболить в корень сайта
				if( !empty($_SESSION['Jlib_auth']['passre_locker']) && $_SESSION['Jlib_auth']['passre_locker']+5>time() ){
					$_SESSION['Jlib_auth']['passre_locker']=time();
					redirect($this->get_url('Jlib_target=default'));
				}

				// выдержать для солидности пару секунд и проверить наличие такого кода в базе
				sleep(2); $sql='sql:usr?u_passre=\''.$_GET['k'].'\' $shrink=yes auto_query=no';
				$res=$GLOBALS[CM]->run($sql); if($res){

					// есть такой код - вывести форму для смены пароля
					if(isset($_SESSION['Jlib_auth']['passre_locker']))unset($_SESSION['Jlib_auth']['passre_locker']);
					$this->pg=$this->tpl['change'];

				}else{

					// код левый - поставить таймер и отфутболить в корень сайта
					$_SESSION['Jlib_auth']['passre_locker']=time();
					redirect($this->get_url('Jlib_target=default'));
				}
			}
		}
		parent::init();
	}
	function before_parse(){

		if(empty($this->params['short'])){	// вызвано не возле короткой формы логина, а в теле страницы

			// процедура изменения пароля
			if( !empty($_GET['k']) && isset($_POST['newpass']) && isset($_POST['accpass']) ) {
				$sql='sql:usr?u_passre=\''.$_GET['k'].'\' $shrink=yes auto_query=no'; $res=$GLOBALS[CM]->run($sql); if($res){
					if( empty($_POST['newpass']) || $_POST['newpass']!=$_POST['accpass'] ){
						$this->pg=str_replace('<!--err:changepass-->','{msg:reg_pwd_att}',$this->pg);
						return false;	// пусто или не совпадает
					}else{
						$GLOBALS[CM]->run($sql,'update',array('u_passre'=>'','u_pwd'=>$_POST['newpass']));
						$this->pg=$this->tpl['changed'];
						return true;	// пароль изменен
					}
				}
			}

		}else{	// вызвано возле формы логина кнопкой "напомнить"

			if(empty($_POST['passremail'])){
				$this->pg=str_replace('<!--err:passremail-->','',$this->pg);	// если его не зачищать, то ява-скрипт отобразит блок, чтобы показать результат
			}else{

				// проверить наличие данного емыла в базе
				$sql='sql:usr?u_email=\''.$_POST['passremail'].'\' $shrink=yes auto_query=no'; $res=$GLOBALS[CM]->run($sql); if(!$res){
					$this->pg=str_replace('<!--err:passremail-->','Пользователь с таким e-mail не найден.',$this->pg);
					return false;	// емыл не найден
				}elseif(!empty($res['u_lock']) && $res['u_lock']!=''){
					$this->pg=str_replace('<!--err:passremail-->','Пользователь заблокирован',$this->pg);
					return false;	// акк заблокирован
				}

				// создать секретный код для беспарольного входа и отправить его на емыл юзера
				if(empty($res['u_passre'])) { $res['u_passre']=substr(uniqid(mt_rand()),0,24); $GLOBALS[CM]->run($sql,'update',array('u_passre'=>$res['u_passre'])); }
				$ml=new mailer(array('tpl'=>$this->params['email_tpl'])); $ml->send($res,$res['u_email']);
				$this->pg=str_replace('<!--err:passremail-->','Письмо отправлено',$this->pg);
				return true;	// пароль отправлен
			}
		}
		$tmp=new iControl(array('pg'=>$this->pg));
		$tmp->get_maked();
		$this->pg=$tmp->pg; 
		unset($tmp);
		//parent::onValid();
	}
}

?>