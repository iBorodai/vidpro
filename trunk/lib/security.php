<?php
//DBD defines
define ('VW',0x20);
define ('RD',0x10);
define ('WR',8);
define ('CR',4);
define ('DL',2);
define ('MN',1);

/*****************************************************************************
*                         Security manager                                   *
******************************************************************************/
class security {
var $sds=array();
var $tpls=array();
var $allow=null;
var $auth=null;
var $sd=null;
var $obj=null;
var $need_form=false;

	function security() {
		//Стартовое определение политики - по умолчанию злая (ничего не разрешено) - потому как секции default - нет
		$def=$GLOBALS[REG]->get('/security','default');
		if (empty($def) || $def=='allow') $this->allow=true;
		else $this->allow=false;
	}

	function _init(&$sec) {
		//Инициализатор (не конструктор) Определяет дискриптор и его параметры. Возвращает результат инициализации секретности.
		$this->auth=true; $this->need_form=false;
		if (is_object($sec)) {
			if (empty($sec->params['security'])) return $ok=false;
			if (!is_array($sec->params['security'])) {			
				$obj['descriptor']=$sec->params['security'];
				if (!empty($sec->params['auth_tpl'])) $obj['tpl']=$sec->params['auth_tpl'];
				if (!empty($sec->params['auth_on'])) $obj['redirect']=$sec->params['auth_on'];
				if (!empty($sec->params['auth_redirect'])) $obj['on_auth']=$sec->params['auth_redirect'];
				if (!empty($sec->params['auth_msg'])) $obj['auth_msg']=$sec->params['auth_msg'];
				if (!empty($sec->params['acc_obj'])) $obj['acc_obj']=$sec->params['acc_obj'];
//echo '<br>Маска-'.$sec->params['acc_msk'].' control-'.$sec->params['name'];				
				if (!empty($sec->params['acc_msk'])) $obj['acc_msk']=$sec->params['acc_msk']; else $obj['acc_msk']=accR; 
				if (isset($sec->params['no_auth_form'])) $this->need_form=false; else $this->need_form=true;
			} else $obj=&$sec->params['security'];
		} else $obj=&$sec;		
		if (is_array($obj)) {
			if (empty($obj['descriptor'])) return $ok=false;
		} elseif (is_string($obj)) {
			if (empty($obj)) return $ok=false;
			$obj=array('descriptor'=>$obj);
		} else
			die('Wrong security request!');

		// получить ссылку на объект
		$this->_get_sd($obj);
		return true;
	}
	//Есть  ли доступ?
	function access(&$sec) {
		//"Детектор секретности" 
		if ($this->_init($sec)==false) return $this->allow;
		// проверка аутентификации
		$this->auth=$this->sd->auth(&$this); if (!$this->auth) return false;
		//если не подразумевается РПД  - вернуть  доступ
		if (empty($this->obj['acc_obj'])) return true;
		
		if(!empty($sec->params['acc_geo']) && !access_geo($sec->params['acc_geo'])) return false;

		// Если объект доступа таки указан, установка доступа. Осуществляется уже дискриптором доступа(его методом access)
		$rs=$this->sd->access(&$this->obj['acc_obj'], &$this->obj['acc_msk']);
//echo "<br>Результата проверки объект:".$this->obj['acc_obj']." маска:".$this->obj['acc_msk']." «".print_r($rs,true)." »";
		return $rs;
	}
	
	//Метод проверяет аутентификацию
	function auth($sec,$data=false) {
		if ($this->_init($sec)==false) return $this->allow;
		// проверка аутентификации
		return $this->auth=$this->sd->auth(&$this,&$data);
	}

	function _get_sd(&$obj) {
		// инициализация дескриптора секретности
		$name=$obj['descriptor'];
		$this->obj=&$obj;
		if (empty($this->sds[$name])) {
			if (!$GLOBALS[REG]->get_section("/security/$name",$dscr))
				die(" Wrong security descriptor '$name'.");
			if (empty($dscr['class']) || !class_exists($dscr['class']))
				die(" Wrong class name for security descriptor '$name'.");
			$this->sds[$name] = new $dscr['class']($name,$dscr);
		}
		$this->sd = &$this->sds[$name];
		if ($this->need_form && !empty($obj['tpl'])) $this->obj['tpl']=$obj['tpl'];
		if (empty($this->obj['tpl'])) $this->obj['tpl']=$this->sd->params['tpl'];
		if (!empty($obj['auth_msg'])) $this->obj['auth_msg']=$obj['auth_msg']; else $this->obj['auth_msg']='';
	}

	function &get_auth_form(&$o_prm) {
		// загрузка шаблона
		if (!empty($this->obj['redirect']))
			redirect($this->obj['redirect'],false,true);

		$tpl=$this->obj['tpl'];
		if (empty($this->tpls[$tpl])) $this->tpls[$tpl]=load($tpl);
		// форма уже выведена, вернуть шаблон-подстановку
		if ($this->sd->auth_lock || !$this->need_form) {
			$prm=array();
			if(!empty($this->tpls[$tpl]['stub'])) $prm['pg']=$this->tpls[$tpl]['stub'];
			$pnl=new iControl($prm);
			return $pnl;
		} else {
			// вывести форму
			$this->sd->auth_lock=true;
			if(empty($this->tpls[$tpl]['form'])){
				$frm=new icontrol(array('pg'=>'Authentification form is missing!'));
				return $frm;
			}
			$form=$this->tpls[$tpl]['form'];
			return $this->sd->get_auth($form);
		}
	}
}

/*****************************************************************************
*                         Security descriptor                                *
******************************************************************************/
	// user rights variable
	//          read edit create delete manage
	//   deny    00    00    00    00    00
	//  allow    01    01    01    01    01
	// inherit   1x    1x    1x    1x    1x
	
	// access rights operation - OR
	// $child  = o1 o1 o1 o1 o1 o1
	// $parent = xx xx xx xx xx xx 
	// $access = $child | parent
	
	// inheritance
	// $child  = 1x 1x 1x o1 o1 o1
	// $parent = xx xx xx xx xx xx 
	// $mask = 11 11 11 00 00 00
	// $access = ($child | $parent) & $mask | ($child & ~ $mask) 
	//           ($child & $parent & $mask) | ($child & ~ $mask) 
	// формирование маски
	// $mask=(($child & 0xAAA) | (($child & 0xAAA) >> 1))//  & ~(($child & 0x555) | (($child & 0x555) << 1)) & $mask;
	
	// get access from cache

function acl($acl) {
	$out=' '; $j=0;
	for ($i=2048;$i>0;$i>>=1) { 
		if ($acl & $i) $out.='1'; else $out.='0';
		if ($j++ & 1)  $out.=' ';
	}
	return $out;
}

class sd {
var $params=array();
var $auth_lock=false;
var $auth_checked=false;
var $auth_form=false;
var $auth_msg='';

var $urc=array(); // users rights cache
var $ugc=array(); // users groups cache
var $tar=null;    // temporary access reference
var $dac=array(); // 3-rd level cache
var $obj=0;
var $db=null;

var $masks=array( //Массив проверяемых масок доступа
	'accR'=>accR,
	'accW'=>accW,
	'accC'=>accC,
	'accD'=>accD,
	'accM'=>accM,
	'accI'=>accI,
);


	function sd($name,$params) {
		$this->params=&$params;
		$this->params['name']=$name;
		if (empty($this->params['auth_class'])) $this->params['auth_class']='form';
		if (empty($this->params['auth_var'])) $this->params['auth_var']='usr';
		if (empty($this->params['acc_var'])) $this->params['acc_var']='acc_subj';
		$this->auth_checked=$this->already_auth();
		$this->db=init_db();
	}
	//Загадочный метод -возвращает набор групп, которые могут получать доступ к обьекту - рагуль. 
	/*Использовался для viewers и navigation, чтобы обеспечить распределение доступа по данным - будет упразнен!*/
	function get_groups($obj, $usr=false, $mask=false) {
		// if (!$mask) $mask=0x3f; if (!$usr) $usr=$_SESSION['Jlib_auth']['u_id'];if (isset($this->ugc[$obj][$usr][$mask])) return $this->ugc[$obj][$usr][$mask]; $ret=array();$sql="SELECT o_id FROM acs_obj WHERE o_type=$obj"; $rs=$this->db->query($sql);while ($row=$this->db->fetch_array($rs)) {$acl=$this->access($row['o_id'],$usr);if ($acl & $mask) $ret[$row['o_id']]=$acl;}$this->ugc[$obj][$usr][$mask]=$ret; /* print_r($ret); echo "\n\n";$ret=array(2=>0x3f,3=>0x3f);*/ 
		$ret=false; return $ret;
	}
	
	//Метод получения иерархии групп пользователя
	function _get_subj_groups($subj,$mod=false){
		if(!empty($_SESSION['Jlib_access']['subj_groups'][$subj])) return $_SESSION['Jlib_access']['subj_groups'][$subj];
		$query="SELECT * FROM access_subj2subj,access_subj WHERE subj_id=ss_pid AND ss_child = $subj AND ss_weight>0 ORDER BY ss_weight DESC";
		if(!$rs=$this->db->query($query,true)) return false;
		$ret=array();
		while( $row=$this->db->fetch_array($rs) ){
			if($mod=='full'){
				$ret[]=$row;
			}elseif($mod=='names'){
				$ret[]=$row['subj_login'];
			}else $ret[]=$row['ss_pid'];
			if($tst=$this->_get_subj_groups($row['ss_pid'])) $ret=array_merge($ret,$tst);
		}
		$_SESSION['Jlib_access']['subj_groups'][$subj]=$ret;
		return $ret;
	}
		
	//Метод верхнего уровня РПД
	function access($obj,$mask=accR,$sbj=false,$base=false){
		//$this->parent=false; echo "Security<pre>",print_r( $this ,true),"</pre>"; exit();
		
		//Патч для уменьшения кол-ва запросов защет однозначного разрешения на чтение.
		//if($obj>10 && $mask==accR) return true;
		//echo "<br>$obj,' ',$mask";
		//Если объект доступа передается по имени
		if(!is_numeric($obj)){//Это задумано только для системных объектов доступа - назначенных сатично
			$rs=$GLOBALS[CM]->run('sql:access_obj#obj_id,obj_type?obj_type=\''.$obj.'\' AND obj_owner=0 $shrink=yes auto_query=no');
			if(empty($rs)) return false;
			$obj=$rs['obj_id'];
			$obj_typ=$rs['obj_type'];
		}
		//Если стоит признак -ровняться на базовые объекты доступа
		if($base){
			//Если тип объекта не был выбран при поиске объекта по базовому имени
			if(empty($obj_typ)){
				//$rs=$this->db->query_row('SELECT obj_type FROM access_obj WHERE obj_id=\''.$obj.'\'',true);
				$obj_typ=$GLOBALS[CM]->run('sql:access_obj#obj_type?obj_id=\''.$obj.'\'$auto_query=no shrink=yes');
				if(empty($obj_typ)){
					set_error_ex('strange_accobj_type ',USR_ERR,'obj_id='.$obj);
					return false;
				}
			}
			//Получаю сам номер объекта, к которому будут производиться вычисления
			//$rs=$this->db->query_row('SELECT obj_id FROM access_obj WHERE obj_owner=0 AND obj_type=\''.$obj_typ.'\'',true);
			$obj=$GLOBALS[CM]->run('sql:access_obj#obj_id?obj_owner=0 AND obj_type=\''.$obj_typ.'\'$auto_query=no shrink=yes');
			if(empty($obj)){
				set_error_ex('base_acc_obj_not_found ',USR_ERR,$obj_typ);
				return false;
			}
		}		
		
		//Определить субьект доступа 
		if(!empty($sbj)){
			$subj=$sbj;
		}elseif(!empty($_SESSION['Jlib_auth'][ $this->params['acc_var'] ])){
			$subj=$_SESSION['Jlib_auth'][ $this->params['acc_var'] ];
		}elseif(!empty($_SESSION['Jlib_access']['subj'])){
			$subj=$_SESSION['Jlib_access']['subj'];
		}else{
			$subj=$GLOBALS[CM]->run('sql:access_subj#subj_id?subj_login=\'guest\' OR subj_login=\'guests\' $shrink=yes auto_query=no');
			$_SESSION['Jlib_access']['subj']=$subj;
		}
		
		//Подруливаю маску - если она передана строкой
		if( is_string($mask)  ){
			if(!empty($this->masks[ $mask ])) $mask=$this->masks[ $mask ];
			else{
				set_error_ex("acc_mask_not_detected", SYS_ERR,$mask);
				$mask=accM; 
			}
		}
		//echo "<br>Проверка obj:$obj mask:$mask subj:$subj";		

		//Проверка сессии				
		if(empty($sbj) && isset($_SESSION['Jlib_access'][$subj][$obj][ $mask ])){
			//echo $_SESSION['Jlib_access'][$subj][$obj][ $mask ];
			return $_SESSION['Jlib_access'][$subj][$obj][ $mask ];
		}
		
		//Если не база - сделать базу
		if(!$this->db)$this->db=init_db();
		//Проверка Таблицы кэша
		if($rs=$this->db->query_row('SELECT * FROM access_cache WHERE ac_obj='.$obj.' AND ac_subj='.$subj.' AND ac_mask='.$mask,true )){
			//echo "in CACHE ";
			$_SESSION['Jlib_access'][$subj][$obj][ $mask ]=$rs['ac_acc'];
			
			return $_SESSION['Jlib_access'][$subj][$obj][ $mask ];
		}
		
		/* Запрос для вычисления: 
				Алгоритм пытается выбрать все права для указанной пары и умолчасния.
				Формиирование запроса организовано таким образом, чтобы он выбирал имеющиеся права в следующей последовательности:
					СПЕЦИАЛЬНЫЕ - для реализации административного и модераторского доступов 
						спец.права(-1) субъект
						спец.права(-1) группы субъекта
					ПРИНАДЛЕЖНЫЕ - все комбинации, где определен объект
						Объект Субъект
						Объект ко всем группам субъекта, отсортированых по весу
						Объект для всех
					УМОЛЧАНИЯ - все правила, где объект не определен
						Субъект ко всем объектам
						Все группы субъекта ко всем объектам в порядке выборки к родителю
						Полное умолчание
					
				Актуальной является первая строка в выборке (запрос на тесте MySQL 5.0.45 выдал 0 сек. ))
		*/
		//Получаю список всех родителей данного субъекта доступа
		$sgrps=$this->_get_subj_groups( $subj );
		//echo "<pre>",print_r( $sgrps ,true),"</pre>";
		//формирую запросы с учетом вложенности субъекта в группы
		$squeries=array(
			'adm'=>array(
			),
			'obj'=>array(
				"SELECT at_obj,at_subj,at_rights FROM access_table WHERE at_subj=$subj AND at_obj=$obj",
			),
			'noobj'=>array(
				"SELECT at_obj,at_subj,at_rights FROM access_table WHERE at_subj=$subj AND at_obj=0"
			)
		);
		for($i=0,$cnt=count($sgrps);$i<$cnt;$i++){
			if(empty($sgrps[$i])) continue;
			$squeries['adm'][]="SELECT at_obj,at_subj,at_rights FROM access_table WHERE at_obj=-1 AND at_subj=".$sgrps[$i];
			$squeries['obj'][]="SELECT at_obj,at_subj,at_rights FROM access_table WHERE at_obj=$obj AND at_subj=".$sgrps[$i];
			$squeries['noobj'][]="SELECT at_obj,at_subj,at_rights FROM access_table WHERE at_obj=0 AND at_subj=".$sgrps[$i];
		}
		//Замыкающие правила
		$squeries['obj'][]="SELECT at_obj,at_subj,at_rights FROM access_table WHERE at_subj=0 AND at_obj=$obj";
		$squeries['noobj'][]="SELECT at_obj,at_subj,at_rights FROM access_table WHERE at_subj=0 AND at_obj=0";
		
		foreach($squeries as $v) if(!empty($v))$query[]=implode(' UNION ',$v);

		$query=implode(' UNION ',$query);
		//ECHO "<br>$query<hr>"; exit();
		if(!$rs=$this->db->query_row($query,true)) return false;
		
		//Разбираю по маскам и сохраняю в таб. кэша и в сессии
		$query="INSERT INTO `access_cache` ( `ac_obj` , `ac_subj` , `ac_mask` , `ac_acc` ) VALUES "; $t=false;
		foreach($this->masks as $v){
			$_SESSION['Jlib_access'][$subj][$obj][ $v ]=$rs['at_rights']&$v;
			if($t)$query.=',';
			$query.='('.$obj.','.$subj.','.$v.', '.($rs['at_rights']&$v).')';
			$t=true;
		}
		$this->db->query($query,true);
		return $_SESSION['Jlib_access'][$subj][$obj][ $mask ];
	}

	function get_objs($mask=accR, $subj=false, $inverse=false){
		//метод получения объектов, к которым субъект имеет право доступа по маске
		// inverse - указывет что нужно вернуть параметры, к тоторым у субъекта НЕТ доступа
		
		//Получаю пользователя
		if(!$subj) if(!empty($_SESSION['Jlib_auth']['acc_subj'])) $subj=$_SESSION['Jlib_auth']['acc_subj']; 
		elseif(!empty($_SESSION['Jlib_access']['subj'])){
			$subj=$_SESSION['Jlib_access']['subj'];
		}else{
			$subj=$GLOBALS[CM]->run('sql:access_subj#subj_id?subj_login=\'guests\'$shrink=yes auto_query=no');
			$_SESSION['Jlib_access']['subj']=$subj;
		}
		
		$sessnm='objs'.$inverse;
		if( !empty( $_SESSION['Jlib_access'][$subj][$sessnm][$mask] ) ) return $_SESSION['Jlib_access'][$subj][$sessnm][$mask]; 
		//Поучаю список объектов, с привязкой к таблице доступа (чтобы видеть для кого доступы определены)
		//Прохожу по Полученному и выбираю доступные
		$query="SELECT obj_id,at_id FROM access_obj LEFT JOIN access_table ON(obj_id=at_obj) GROUP BY obj_id";
		if(!$rs=$this->db->query($query,true)) return array(0);
		$ret=array(0); $def_right=false;
		while($row=$this->db->fetch_array($rs)){
			if(empty($row['at_id']) && $def_right!==false) $tst=$def_right;
			else $tst=$this->access($row['obj_id'],$mask);
			
			if(!$inverse && $tst) $ret[]=$row['obj_id']; //Если выбор разрешенных
			elseif($inverse && !$tst) $ret[]=$row['obj_id']; //Если выбор запрещенных
			if($def_right===false) $def_right=$tst;
		}
		$_SESSION['Jlib_access'][$subj][$sessnm][$mask]=$ret;
//print_r($ret);
		return $ret;
	}

	//Судя по бесталковости, метод явно для реальизации в наследнике ))
	function check_auth($data) {
		$ret=($data['usr']=='test') && ($data['pwd']=='test');
		if ($ret) {
			$_SESSION['Jlib_auth'][$this->params['name']][$this->params['auth_var']]=$data;
			$this->$auth_checked=true;
		}
		return $ret;
	}
	//Метод показывает что чел уже в системе авторизирован.
	//Метод обеспечивающий авторизацию - проверка и авторизация или не авторизация пользователя
	function already_auth() {
		return !empty($_SESSION['Jlib_auth'][$this->params['name']][$this->params['auth_var']]);
	}
	//Метод обеспечивающий аутентификацию - вывод формы, получение данных входа
	function auth($sm,$data=false) {
		if (!empty($data)) { $this->auth_checked=true; return $this->check_auth($data); }
		if ($this->auth_checked) return $this->already_auth();
		if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['jlib_auth_form'])) {		
			if ($sm->need_form) {
				if (empty($sm->obj['auth_msg'])) $this->auth_msg='msg:access_denied';
				else $this->auth_msg=$sm->obj['auth_msg'];
				$tpl=$sm->obj['tpl']; 
				if (empty($sm->tpls[$tpl])) $sm->tpls[$tpl]=load($tpl);
				$form=$this->get_auth($sm->tpls[$tpl]['form']); $this->auth_checked=true;
				if ($form->valid) {
					if ($this->check_auth(&$form->data)) {
						if (!empty($_SESSION['Jlib_auth_redirect'])) {
							$url=$_SESSION['Jlib_auth_redirect']['from'];
							unset ($_SESSION['Jlib_auth_redirect']);
							redirect($url);
						} else if (!empty($sm->obj['on_auth'])) redirect($sm->obj['on_auth']);
						return true;
					}
					if ($this->auth_msg!='none') set_error_ex($this->auth_msg,USR_ERR);
				}
			} elseif (!empty($_POST['usr']) && !empty($_POST['pwd'])) {
				$dat['usr']=strip_tags($_POST['usr']);
				$dat['pwd']=strip_tags($_POST['pwd']);
				return $this->check_auth($dat);
			}
		}
		return false;
	}
	//Метод создает объект авторизации
	function &get_auth($tpl) {
		if (empty($this->auth_form)) {
			$this->auth_form=new $this->params['auth_class']();
			$this->auth_form->form_params['name']='jlib_auth_form';
			//echo 'tpl', nl2br(str_replace(' ','&nbsp;',print_r($tpl,true)));
			$this->auth_form->pg=&$tpl; $this->auth_form->init();
		}
		return $this->auth_form;
	}
}

?>
