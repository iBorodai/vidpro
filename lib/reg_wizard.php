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
		//Инициализация хранилища визарда
		$this->wizard_init();
		//$this->data=$this->wizard_data;

	  if( !empty($GLOBALS['Jlib_page_extra'][0]) && $GLOBALS['Jlib_page_extra'][0]=='loginza' ){
	    $this->loginza_reg();
		}

	  //Получить информацию о шагах
		//Определить шаг
		if((!empty($this->ctrl[ $this->params['ctrl_steps'] ]))){
		  $this->cur_step=$this->ctrl[ $this->params['ctrl_steps'] ];
		}else{
		  $this->cur_step=array_shift(array_keys( $this->params['steps'] ))  ;
		}

		//Оформить шаг
		$this->show_step();
		// Работает форма


	  //if( $GLOBALS['Jlib_page']=='registration' && !empty($_SESSION['Jlib_auth']) ) {redirect('/'); exit();}
		
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
		
		$this->load_params_reg();
		
		// инициализация
		$this->user=0;

		if ($this->user && $this->saller) {
			// режим update
		} else {
			// режим insert
			$this->form_params['cs_mode']='insert';
			//if( file_exists('img/users/tmp_'.session_id().'.jpg') )	$ava='tmp_'.session_id().'.jpg';
		}
		
		//if(empty($ava)) $ava=str_replace('{img_ava}','def.jpg',$this->tpl['not_img_ava']);
		//else $ava=str_replace('{img_ava}',$ava,$this->tpl['img_ava']);
		//$this->pg=str_replace('{img_ava}',$ava,$this->pg);

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
	  
	  //return true;
	  //Создать аккаунт
	  $data=array(
		  'u_email'=>$this->wizard_data['email'],
		  'u_name'=>$this->wizard_data['name'],
		  'u_url'=>translit($this->wizard_data['name']).'_'.uniqid(''),
		  'u_grp'=>'usr',
		  'u_img'=>$this->wizard_data['u_img'],
		  'u_createdate'=>date('Y-m-d H:i:s'),
		  'u_lastlogin'=>date('Y-m-d H:i:s'),
		  'u_pwd'=>$pwd,
		  'u_lock'=>0,
		  'u_openid'=>!empty($this->wizard_data['u_openid'])?$this->wizard_data['u_openid']:'',
		  'u_openidprov'=>!empty($this->wizard_data['u_openidprov'])?$this->wizard_data['u_openidprov']:'',
		);
		$uid=$GLOBALS[CM]->run('sql:user','insert',$data);
		
	  //Привязать темы
	  $sql="INSERT INTO user2theme VALUES ";
	  $vals=array(); foreach( $this->data['themes'] as $v )
	    $vals[]=" ( $uid, $v ) ";
	  $sql.=implode(',', $vals);
	  $db=init_db();
	  $db->query($sql);
	  $this->wizard_data['u_themes']=$this->data['themes'];
	  
	  //Отправляю мыло
	  require_once 'lib/class.phpmailer.php';
	  $data['proj_email_name']=$GLOBALS['Jlib_proj_name'];
	  $data['server']=$_SERVER['SERVER_NAME'];
	  $msg=strjtr($this->tpl['mail_msg'], $data);
	  
		$mail = new PHPMailer();
		$mail->From = $GLOBALS['Jlib_defaults']['proj_email'];
		$mail->FromName = $GLOBALS['Jlib_defaults']['proj_email_name'];
		$mail->IsHTML(true);
		$mail->AddAddress($form->data['u_email']);
		$mail->Subject = 'Доступ к Вашему акаунту на '.$GLOBALS['Jlib_proj_name'];
		$mail->Body = $msg;
		$mail->Send();
	  
	  //Авторизирую
	  $data['u_id']=$uid;
	  $this->wizard_data=array_merge($this->wizard_data, $data);
	  $this->auth_user();
	  
	  redirect('/');
	}
	
	function auth_user(){
	  $data=array(
	    'u_id'=>$this->wizard_data['u_id'],
	    'u_email'=>(!empty($this->wizard_data['u_email']))?$this->wizard_data['u_email']:$this->wizard_data['email'],
	    'u_name'=>(!empty($this->wizard_data['u_name']))?$this->wizard_data['u_name']:$this->wizard_data['name'],
	    'u_grp'=>$this->wizard_data['u_grp'],
	    'u_img'=>$this->wizard_data['u_img'],
	    'u_gender'=>$this->wizard_data['u_gender'],
	    'u_createdate'=>$this->wizard_data['u_createdate'],
	    'u_lastlogin'=>$this->wizard_data['u_lastlogin'],
	    'u_openid'=>$this->wizard_data['u_openid'],
	    'u_openidprov'=>$this->wizard_data['u_openidprov'],
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
	
	function loginza_reg(){
		if( empty($_POST) ) {redirect('/'); exit(); }
		$debug=false; $local=true;
		if(!empty($_GET['ref'])){ $_SESSION['Jlib_auth_ref']=$_GET['ref']; }
		$host='loginza.ru';
		if( $local )
			$loc='/api/authinfo?token='.$_POST['token'];
		else
			$loc='/api/authinfo?token='.$_POST['token'].'&id=50555&sig='.md5($_POST['token'].'077f18fec6c9c2748d31d7de8791c7e3');

	  $json_dt=get_page($host, $loc);
		//include 'lib/JSON.php';
		//$json = new Services_JSON();
		//$dt = $json->decode($json_dt);
		$dt=json_decode($json_dt);
		if($debug){
		  echo '<br />Данные от соц. ДО<pre class="debug">'.print_r ( $dt ,true).'</pre>';
		}
		if( !empty($dt->error_type) ){
		  return '<h1>Ошибка :(</h1><p>'.$dt->error_message.'</p><br />';
		}

		if(!empty($dt->name->first_name))	$first_name	=	($dt->name->first_name);
		if(!empty($dt->name->last_name))	$last_name	=	($dt->name->last_name);
		if(!empty($dt->name->full_name))	$full_name	=	($dt->name->full_name);
		if(!empty($dt->name->nickname))		$nickname		=	($dt->name->nickname);
		
		if($debug){
		  echo '<br />Данные от соц. ПОСЛЕ<pre class="debug">'.print_r ( $dt ,true).'</pre>';
		}

		//nm gen
		if(!empty($first_name)) $nm=$first_name;
		elseif(!empty($nickname)) $nm=$nickname;
		elseif(!empty($full_name)) $nm=$full_name;
		else $nm='';

		$tmp_data=array(
		  'u_openid'=>$dt->identity,
		  'u_openidprov'=>$dt->provider,
		  'name'=> $nm,
		  'email'=>( !empty($dt->email) )?$dt->email:'',
		  'u_gender'=>( empty($dt->gender) )?'hmm': ( ($dt->gender=='M')?'mle':'fme' ),
		  'u_img'=>( empty($dt->photo) )?'/img/def_usr.jpg':$dt->photo,
		);

		//Есть ли профайл
		$by_mail='';
		if( !empty( $tmp_data['u_email'] ) ) $by_mail=' OR u_email=\''.$tmp_data['u_email'].'\' ';
		$u_dt=$GLOBALS[CM]->run(
			'sql:user?u_openid=\''.$tmp_data['u_openid'].'\' '. $by_mail .'
			$auto_query=no'
		);

		//Создать пользователя если нету
		if( empty($u_dt) || count($u_dt)<1 ){
		  $this->wizard_data=$tmp_data;
		  //echo '<pre class="debug">'.print_r ( $this->wizard_data ,true).'</pre>'; exit();
		  
		  $this->auth_user();
		  redirect('/'); exit();
		}else{
		  //Если аккав несколько - попытаться найти с почтой
		  if( count($u_dt)>1 ){
				$first=false; $found=false;
				foreach( $u_dt as $uk=>$uv ){
		      if(!$first) $first=$uk;
		      if( empty($found) && $uv['u_email']!='' ){
		        $found=$uk;	break;
					}
				}
				if( $found ) $u_dt=$u_dt[$found];
				else  $u_dt=$u_dt[$first];
			}else{
			  $u_dt=$u_dt[0];
			}
		  if($debug){
		  	echo '<br />Пользователь найден <pre class="debug">'.print_r ( $u_dt ,true).'</pre>';
			}
		  unset($u_dt['u_pwd'], $u_dt['u_lock']);
			$uid=$u_dt['u_id'];
			$t=$GLOBALS[CM]->run('sql:user2theme#GROUP_CONCAT(u2t_key_t)?u2t_key_u='.$uid.'$auto_query=no shrink=yes');
			if(!empty($t)){
        $u_dt['u_themes']=$t;
			}

			$this->wizard_data=$u_dt;
			$this->auth_user();
			if(!$debug) redirect('/');
		}
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