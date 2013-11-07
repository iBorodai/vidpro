<?php
//include('lib/helpers.php');
class lite_reg extends form {
	var $cur_step=false;
	/***************************
	 *    Методы для визарда
	 **************************/
	function params_init(&$params){
  	$GLOBALS[REG]->get_reg_part('/wizards/'.$params['wizard'],$params);
		parent::params_init($params);
		if(!empty($this->ctrl[ $this->params['ctrl'] ] ) && $this->ctrl[ $this->params['ctrl'] ]!='new')
			$this->mode='edit';
		else
			$this->mode='create';
	}

	function DEL_load_step_data(){
	  $this->data=array();
		if( empty($_SESSION['wizards'][$this->wizard_name]) ){
		  $_SESSION['wizards'][$this->wizard_name]=array(
		    'data'=>array(),
		    'data_steps_index'=>array(),
			);
		}elseif( !empty($_SESSION['wizards'][$this->wizard_name]['data_steps_index'][$this->cur_step]) ){
		  foreach( $_SESSION['wizards'][$this->wizard_name]['data_steps_index'][$this->cur_step] as $v){
		    $this->data[$v]=$_SESSION['wizards'][$this->wizard_name]['data'][$v];
			}
		}else{
		  $_SESSION['wizards'][$this->wizard_name]['data_steps_index'][$this->cur_step]=array();
		}
		return count( $this->data );
	}

	//Инициализация хранилища
	function wizard_init(){
	  //Имя мастера
		$this->wizard_name=$this->params['wizard'].'_'.$this->params['name'];

		//если данных еще не было
	  if(empty($_SESSION[$this->wizard_name]['data'])){
			$_SESSION[$this->wizard_name]=array(
			  'data'=>array(
			    'wizard_id'=>$this->wizard_name,
				),
			);

			//Получение данных в хранилище
		  $repl=array_merge($this->ctrl, array('lang'=>$GLOBALS['Jlib_lang']));
			if(!empty($this->data) && is_array($this->data))
				$repl=array_merge($repl,$this->data);
			if(!empty($this->params['get_data'])){
				foreach($this->params['get_data'] as $k=>$v){
				  $ucl=( is_numeric($k) )?$v:$k;
				  $to=( !is_numeric($k) )?$v:'data';

					//foreach ( $_SESSION['Jlib_auth'] as $kk=>$kv) $repl[ 'auth_'.$kk ]=$kv;

					$ucl=strjtr( $ucl,$repl );
					if( strpos($ucl, 'shrink')===false ){
					  if( strpos($ucl, '$')===false ) $ucl.='$';
		        $ucl.=' shrink=yes';
					}

					$dt=$GLOBALS[CM]->run($ucl);

		      if( !isset($_SESSION[$this->wizard_name][$to]) ) $_SESSION[$this->wizard_name][$to]=array();
		      $_SESSION[$this->wizard_name][$to]=array_merge($_SESSION[$this->wizard_name][$to], $dt);
		      $repl=array_merge($repl, $dt);
				}
			}
		}
		$this->wizard_data=&$_SESSION[$this->wizard_name]['data'];
	}

	function show_step(){
	  if( !empty( $this->params['steps'][ $this->cur_step ]['builder'] ) ){
	    $fn=$this->params['steps'][ $this->cur_step ]['builder'];
	    if( function_exists($fn) ){
				$this->pg=$fn($this);
	    }else{
	      set_error_ex('не найден компонент отображения шага',USR_ERR);
	      return false;
			}
		}else{
		  //$this->pg=strjtr( $this->tpl[ $this->params['steps'][ $this->cur_step ]['tpl'] ], $_SESSION['Jlib_auth'] );
		  $this->pg= $this->tpl[ $this->params['steps'][ $this->cur_step ]['tpl'] ];
		}
	}

	/***************************
	 *    Методы регистрации
	 **************************/
	var $user=0;
	// простой класс регистрации пользователя
	function init(){
    if( AJAX ){
	  	$this->ajax_process();
	  	parent::init();
			return true;
		}

	  parent::init(false);
	  
		if(!empty($this->ctrl['unlock'])){
		  //Выбираю пользователя
			$rs=$GLOBALS[CM]->run('sql:usr?u_lock=\''.$this->ctrl['unlock'].'\'$shrink=yes auto_query=no');
			unset($rs['u_pwd']);

			//Выбираю профайл
			if($rs){
			  if($rs['u_grp']=='saller') $rs2=$GLOBALS[CM]->run('sql:sallers?s_id='.$rs['u_key_subj'].'$auto_query=no shrink=yes ');
			}

			if($rs && $rs2){
			  $GLOBALS[CM]->run('sql:usr?u_id=\''.$rs['u_id'].'\'$auto_query=no' ,'update', array('u_lock'=>'', 'u_last_login'=>date('Y-m-d H:i:s')));
				$_SESSION['Jlib_auth']=array_merge($rs, $rs2, array('site_auth'=>1,'admin_auth'=>0));
				$this->pg=$this->tpl['reg_unlocked'];
			}else
				$this->pg=$this->tpl['reg_stilllocked'];
			$tmp=new iControl(array('pg'=>$this->pg)); $tmp->get_maked();
			$this->pg=$tmp->pg;
			unset($tmp);
			$this->parsed=true;
			$this->maked=true;
			return true;
		}
	  
		//Инициализация хранилища визарда
		$this->wizard_init();
//echo '<pre class="debug">HERE1:'.print_r ( $GLOBALS['Jlib_page_extra'] ,true).'</pre>';
	  if( !empty($GLOBALS['Jlib_page_extra'][0]) && $GLOBALS['Jlib_page_extra'][0]=='ulogin' ){
	    //$this->loginza_reg();
	    $this->ulogin_reg();
		}

	  //Получить информацию о шагах
		//Определить шаг
		if((!empty($this->ctrl[ $this->params['ctrl_steps'] ]))){
		  $this->cur_step=$this->ctrl[ $this->params['ctrl_steps'] ];
		}else{
		  //echo '<pre class="debug">'.print_r ( $this->wizard_data ,true).'</pre>';
		  $this->cur_step=array_shift(array_keys( $this->params['steps'] ))  ;
		}

		//Оформить шаг
		$this->show_step();

		$this->load_params_reg();
		
		// инициализация
		$this->user=0;

		if ($this->user && $this->saller) {
			// режим update
		} else {
			// режим insert
			$this->form_params['cs_mode']='insert';
		}
		
		parent::init(true);
		$this->inited=true;
	}
	
	function ajax_process(){
	    
			if(!empty($_REQUEST['mode'])){
	  	  switch($_REQUEST['mode']){
					case 'upload_photo':
					  if(!empty($_FILES['avatar'])){
					    $fnm=$_FILES['avatar']['tmp_name']; if(isset($fnm[0]))$fnm=$fnm[0];
					    $nnm='tmp_'.session_id();
					    if(!empty($this->saller) && $_SESSION['Jlib_auth']['u_grp']=='admin'){
								$nnm=intval($this->saller);
							}
					    $i=j_make_image(
								$fnm,
								$nnm ,
								array(
									'path' => 'img/sallers',
									'tmb_x' => -1,
									'tmb_y' => -1,
									'pic_nm' => '{name}',
									'pic_px' => 100,
									'pic_py' => 100,
									'pic_lx' => 100,
									'pic_ly' => 100,
									'pic_fix' => 2,
									'no_pic' => 'nophoto',
								),
								false
							);
							if($i && !empty($this->saller)){
							  $GLOBALS[CM]->run('sql:sallers#s_img?s_id='.$this->saller.'$auto_query=no','update',array('s_img'=>1));
							}
					    $this->pg='<img src="/img/sallers/'.$i.'?id='. rand(0,100) .'">';
						}else{
						  $this->pg='error';
						}
					  break;
					default: $this->pg=str_replace('{error}','<strong>Ошибка JS</strong> неизвестное значение режима "'.$_REQUEST['mode'].'"', $this->tpl['js_error']);
				}
			}else{
			  $this->pg=str_replace('{error}','<strong>Ошибка JS</strong>  Не передан режим', $this->tpl['js_error']);
			}
	}
	
	function load_params_reg( ){
		if(!$GLOBALS[REG]->get_reg_part('/controls/lite_reg', $this->params)) set_error_ex("paramsd_error", SYS_MSG);
	}
	
	function onUnvalid(){
		$this->data['badrobot']='';
	}

	function onValid(){
	  if(AJAX) return true;
	  $res=true;
	  if( !empty($this->params['steps'][ $this->cur_step ]['validator']) ){
	    if( function_exists( $this->params['steps'][ $this->cur_step ]['validator'] ) ){
	      $res=$this->params['steps'][ $this->cur_step ]['validator']($this);
			}
		}

		if($res){
		  	//Если указано кто будет сохранять
		    if(!empty( $this->params['steps'][$this->cur_step]['store_step'] )){
		      $fn=$this->params['steps'][$this->cur_step]['store_step'];
		      if( function_exists($fn) ) $fn( $this );
				}else{ //Штатное сохранение
			  //Запонить данные
					foreach($this->data as $k=>$v){
					  $this->wizard_data[$k]=(is_array($v))?implode(',',$v):$v;
					}
				}
				//echo '<pre class="debug">'.print_r ( $_SESSION[$this->wizard_name] ,true).'</pre>';
		    //GOTO Следующий шаг

		    foreach( $this->params['steps'] as $k=>$v ){
		      if( isset($ps) ){ $this->cur_step=$k; break; }
	      	if( $k!=$this->cur_step ) continue;
		      else{ $ps=$this->cur_step; continue; }
				}

				if( $ps!=$this->cur_step ) redirect( $this->get_url('step='.$this->cur_step) );
				else {
				  parent::onValid();
					$this->done=true;
				}
		}
	}

	function do_save(){
	  if(AJAX) return true;
	  //echo '<br />SESSION:<pre class="debug">'.print_r ( $_SESSION['Jlib_auth'] ,true).'</pre>';
	  //echo '<br />wizard_data:<pre class="debug">'.print_r ( $this->wizard_data ,true).'</pre>';
	  //exit();

	  //if(!empty($_SESSION['Jlib_auth'])) $uid=$_SESSION['Jlib_auth']['u_id']; else//что это пока не понятно... хм.
		if(empty($this->wizard_data['u_id'])){
			//Создание акка пользователя
	    if(!empty($this->wizard_data['name'])){ $this->wizard_data['u_name']=$this->wizard_data['name']; unset($this->wizard_data['name']); }
	    if(!empty($this->wizard_data['email'])){ $this->wizard_data['u_email']=$this->wizard_data['email']; unset($this->wizard_data['email']); }
		  //Создать аккаунт
		  $data=array(
			  'u_email'=>(!empty($this->wizard_data['u_email']))?$this->wizard_data['u_email']:uniqid('') ,
			  'u_name'=>$this->wizard_data['u_name'],
			  'u_sname'=>$this->wizard_data['u_sname'],
			  'u_url'=>translit($this->wizard_data['u_name'].'.'.$this->wizard_data['u_sname']),
			  'u_grp'=>'usr',
			  'u_img'=>$this->wizard_data['u_img'],
			  'u_gender'=>$this->wizard_data['u_gender'],
			  'u_createdate'=>date('Y-m-d H:i:s'),
			  'u_lastlogin'=>date('Y-m-d H:i:s'),
			  'u_pwd'=>( empty($this->wizard_data['oid_openid']) )?uniqid(''):'',
			  'u_lock'=>0,
			);
			//Проверить URL на уникальность
			$tst=$GLOBALS[CM]->run('sql:user?u_url=\''.$data['u_url'].'\'');
			if( !empty($tst) ) $data['u_url'].='-'.uniqid('');
			
			$uid=$GLOBALS[CM]->run('sql:user','insert',$data);
			if(empty($uid)){echo "ОШибка регистрации ".mysql_error(); exit();}
			
			if(!empty($this->wizard_data['u_email']) && !empty( $data['u_pwd'] ) ){
				//Отправляю мыло
			  require_once 'lib/class.phpmailer.php';
			  $data['proj_email_name']=$GLOBALS['Jlib_proj_name'];
			  $data['server']=$_SERVER['SERVER_NAME'];
			  $msg=strjtr($this->tpl['mail_msg'], $data);

				$mail = new PHPMailer();
				$mail->From = $GLOBALS['Jlib_defaults']['proj_email'];
				$mail->FromName = $GLOBALS['Jlib_defaults']['proj_email_name'];
				$mail->IsHTML(true);
				$mail->AddAddress($this->wizard_data['u_email']);
				$mail->Subject = 'Доступ к Вашему акаунту на '.$GLOBALS['Jlib_proj_name'];
				$mail->Body = $msg;
				$mail->Send();
			}

			//Мерджу измененные данные
		  $data['u_id']=$uid;
		  $this->wizard_data=array_merge($this->wizard_data, $data);
		}else{
		  //ПРофайл есть - проверяю поля: картинка, фамилия, т.п
		  //echo 'Ulogin:<pre class="debug">'.print_r ( $_SESSION['ulogin_data'] ,true).'</pre>';
		  //echo 'Wizard:<pre class="debug">'.print_r ( $this->wizard_data ,true).'</pre>';
		  if(
				(
					$this->wizard_data['u_img']=='/img/def_usr.jpg' ||
					strpos($this->wizard_data['u_img'], 'ulogin.ru')!==false
				) &&
				!empty( $_SESSION['ulogin_data']['u_img'] )
			)$update['u_img']=$_SESSION['ulogin_data']['u_img'];
			
			if(
				(
					empty($this->wizard_data['bdate']) ||
					$this->wizard_data['bdate']=='0000-00-00'
				)&&
					!empty( $_SESSION['ulogin_data']['u_bdate'] )
			){
				if( substr($_SESSION['ulogin_data']['u_bdate'], 4, 1)=='-' )	$update['u_bdate']= $_SESSION['ulogin_data']['u_bdate'];
				else	$update['u_bdate']= date_processor('store',$_SESSION['ulogin_data']['u_bdate'],array('store' => 'Y-m-d','display' => 'd.m.Y'));
			}
			
			if(
				empty($this->wizard_data['u_sname']) &&
				!empty( $_SESSION['ulogin_data']['u_sname'] )
			)$update['u_sname']=$_SESSION['ulogin_data']['u_sname'];
			
			if(!empty($update)){

			  $t=array(); foreach( $update as $k=>$v ) $t[]=$k."='".$v."' ";
				$sql="UPDATE user SET ".implode(',',$t)." WHERE u_id=".$this->wizard_data['u_id'];
				
				mysql_query($sql);
				if( mysql_error() ){}
				$this->wizard_data=array_merge($this->wizard_data,$update);
			}
			//echo '<pre class="debug">'.print_r ( $_SESSION['ulogin_data'] ,true).'</pre>';
			//echo '<pre class="debug">'.print_r ( $update ,true).'</pre>';
		}
		//привязываю к акку темы, если нужно
		if(!empty($this->data['themes'])){
			//Привязать темы
		  $sql="INSERT INTO user2theme VALUES ";
		  $vals=array(); foreach( $this->data['themes'] as $v )
		    $vals[]=" ( $uid, $v ) ";
		  $sql.=implode(',', $vals);
		  $db=init_db();
		  $db->query($sql);
		  $this->wizard_data['u_themes']=$this->data['themes'];
		}
		
		//echo '<pre class="debug">'.print_r ( $this->wizard_data ,true).'</pre>';
		//Создаю запись OpenID ели нужно
		if( empty($this->wizard_data['oid_id']) && !empty($this->wizard_data['oid_openid'])){
		  $data=array(
		    'oid_key_u'=>$this->wizard_data['u_id'],
		    'oid_openid'=>$this->wizard_data['oid_openid'],
		    'oid_provider'=>$this->wizard_data['oid_provider'],
			);
			$sql="INSERT INTO openid SET oid_key_u=".$this->wizard_data['u_id'].", oid_openid='".$this->wizard_data['oid_openid']."'";
			mysql_query($sql);
			$oid=mysql_insert_id();
			
			if(!empty($oid)){
			  $this->wizard_data['oid_id']=$oid;
			}
		}

		$this->auth_user();
		if(!empty($_SESSION['reg_from'])){
		  $t=$_SESSION['reg_from'];
		  unset($_SESSION['reg_from']);
			redirect($t);
		}else
			redirect('/');
		exit();
	}
	
	function auth_user(){
	  $data=array(
	    'u_id'=>$this->wizard_data['u_id'],
	    'u_email'=>(!empty($this->wizard_data['u_email']))?$this->wizard_data['u_email']:$this->wizard_data['email'],
	    'u_name'=>(!empty($this->wizard_data['u_name']))?$this->wizard_data['u_name']:$this->wizard_data['name'],
	    'u_grp'=>$this->wizard_data['u_grp'],
	    'u_img'=>$this->wizard_data['u_img'],
	    'u_gender'=>$this->wizard_data['u_gender'],
	    'u_bdate'=>$this->wizard_data['u_bdate'],
	    'u_createdate'=>$this->wizard_data['u_createdate'],
	    'u_lastlogin'=>$this->wizard_data['u_lastlogin'],
	    'oid_openid'=>(!empty($this->wizard_data['oid_openid']))?$this->wizard_data['oid_openid']:'',
	    'oid_provider'=>(!empty($this->wizard_data['oid_provider']))?$this->wizard_data['oid_provider']:'',
		);
		
		if(!empty( $this->wizard_data['u_themes'] )){
		  $data['u_themes']=(is_array( $this->wizard_data['u_themes']))?implode(',', $this->wizard_data['u_themes']):$this->wizard_data['u_themes'];
		}
		//echo '<pre class="debug">'.print_r ( $data ,true).'</pre>'; exit();
		
		$_SESSION['Jlib_auth']=$data;
		$_SESSION['Jlib_auth']['user_auth']=true;
		$_SESSION['Jlib_auth']['site_auth']=true;
		if(empty($_SESSION['Jlib_auth']['u_id']))$_SESSION['Jlib_auth']['u_id']=$this->wizard_data['uid'];
	}
	
	function ulogin_reg(){
	  if(empty($_POST['token'])){
	    echo "auth error";
	    exit();
		}
		$s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
	  $user = json_decode($s, true);
	  
		$tmp_data=array(
		  'oid_openid'=>$user['identity'],
		  'oid_provider'=>'',
		  'u_name'=> $user['first_name'],
		  'u_sname'=> $user['last_name'],
		  'u_email'=>( !empty($user['email']) )?$user['email']: '',
		  'u_bdate'=>( !empty($user['bdate']) )?date_processor('store',$user['bdate'],array('store' => 'Y-m-d','display' => 'd.m.Y')): '',
		  'u_gender'=>( empty($user['sex']) )?'hmm': ( ($user['sec']=='2')?'m':'f' ),
		  'u_img'=>( empty($user['photo_big']) )?( (!empty($user['photo']))?$user['photo']:'/img/def_usr.jpg' ):$user['photo_big'],
		);
		if( strpos($tmp_data['u_img'], 'ulogin.ru')!==false )
		  $tmp_data['u_img']=( strpos($user['photo'], 'ulogin.ru')!==false )?'/img/def_usr.jpg':$user['photo'];
		  
		//Сохраняю для дальнейшей проверки
		$_SESSION['ulogin_data']=$tmp_data;

		//Есть ли профайл
		$DB=init_db();
		if( !empty( $tmp_data['u_email'] ) ){
		//Пытаюсь выбрать пользователя по мылу и определить его существующий openID
		  $sql="SELECT	u_id,u_grp,u_url,u_email,u_pwd,u_name,u_sname,u_img,u_gender,u_createdate,u_lastlogin,u_lock,oid_id
						FROM		user LEFT JOIN openid ON(oid_key_u=u_id AND oid_openid='".$tmp_data['oid_openid']."')
						WHERE		u_email='".$tmp_data['u_email']."'	LIMIT 0,1";
		}else{
		//Пытаюсь выбрать пользователя только по openID
			$sql="SELECT	u_id,u_grp,u_url,u_email,u_pwd,u_name,u_sname,u_img,u_gender,u_createdate,u_lastlogin,u_lock,oid_id
						FROM		openid,user
						WHERE		oid_key_u=u_id AND oid_openid='".$tmp_data['oid_openid']."' LIMIT 0,1";
		}
		$u_dt=$DB->query($sql);
		if(mysql_error()) $u_dt=false;
		else	$u_dt=mysql_fetch_assoc($u_dt);
    //echo $sql.'<br /><pre class="debug">'.print_r ( $u_dt ,true).'</pre>';

		//Создать пользователя если нету (подставить данные и пустить визарда дальше)
		if( empty($u_dt['u_id']) ){
		  $this->wizard_data=$tmp_data;
		}else{
			$t=$GLOBALS[CM]->run('sql:user2theme#GROUP_CONCAT(u2t_key_t)?u2t_key_u='.$u_dt['u_id'].'$auto_query=no shrink=yes');
			if(!empty($t)) $tmp_data['u_themes']=$t;
			$this->wizard_data=array_merge($tmp_data,$u_dt);
		}

		redirect('/catigories');
	}
}

function array2line($arr, $cur=''){
	$ret=array();
	foreach($arr as $k=>$v){
	  if( is_array($v) ){
			$t=array2line($v,$cur.'['.$k.']');
			$ret=array_merge($ret, $t);
		}else{
		  $ret[ $cur.'['.$k.']' ]=$v;
		}
	}
	return $ret;
}
?>