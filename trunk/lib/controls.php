<?
require 'lib/ui/forms.php';
require 'lib/ui/core.php';
require 'lib/ui/navigation.php';
require 'lib/viewers.php';

/***********************************
 * Проектные Вспомогательные интерфейсные ф-ии и классы
 */

function logout_here($prm){
	if(!empty($_GET['logout'])){
	  $_COOKIE['jlib_mem_user']='-1';
	  setcookie("jlib_mem_user", '-1', time()-3600,'/');
	  session_destroy();
		header('Location:'.$prm['parent']->get_url());
	}
}

function addbraces($item){
	return '{'.$item.'}';
}

/***********************************
 * КОНЕЦ Проектные Вспомогательные интерфейсные ф-ии и классы
 */

class user_info extends icontrol {
	function init() {
		if (!empty($this->ctrl['logout'])) {
			setcookie("jlib_mem_user", "-1", time()-3600,'/' );
			session_destroy();
			redirect($this->get_url('logout='));
		}
		if(!empty($_SESSION['Jlib_auth']['u_nub'])) $this->pg=str_replace('{u_img}',$this->tpl['u_nub'],$this->pg);
		elseif(!empty($_SESSION['Jlib_auth']['u_img']) && !empty($this->tpl['u_img'])) $this->pg=str_replace('{u_img}',$this->tpl['u_img'],$this->pg);
		elseif(!empty($this->tpl['not_u_img'])) $this->pg=str_replace('{u_img}',$this->tpl['not_u_img'],$this->pg);
		else $this->pg=str_replace('{u_img}','',$this->pg);
		foreach($_SESSION['Jlib_auth'] as $k=>$v){
			$this->pg=str_replace('{'.$k.'}',$v,$this->pg);
		}
		$this->pg=str_replace('{rand}',rand(),$this->pg);
	}
}

function translit($str){
	$re_ar= array(" "=>"", "а"=>"a", "А"=>"a", "б"=>"b", "Б"=>"b", "в"=>"v", "В"=>"v", "г"=>"g", "Г"=>"g",
	"д"=>"d", "Д"=>"d", "е"=>"e", "Е"=>"e", "ё"=>"e", "Ё"=>"e", "ж"=>"j", "Ж"=>"j", "з"=>"z", "З"=>"z", "и"=>"i", "И"=>"I", "й"=>"i",
	"Й"=>"i", "к"=>"k", "К"=>"k", "л"=>"l", "Л"=>"l", "м"=>"m", "М"=>"m", "н"=>"n", "Н"=>"n", "о"=>"o", "О"=>"o", "п"=>"p", "П"=>"p",
	"р"=>"r", "Р"=>"r", "с"=>"s", "С"=>"s", "т"=>"t", "Т"=>"t", "у"=>"y", "У"=>"y", "ф"=>"f", "Ф"=>"f", "х"=>"h", "Х"=>"h", "ц"=>"c",
	"Ц"=>"c", "ч"=>"ch", "Ч"=>"ch", "ш"=>"sh", "Ш"=>"sh", "щ"=>"sh", "Щ"=>"sh", "ъ"=>"", "Ъ"=>"", "ы"=>"y", "Ы"=>"y", "ь"=>"", "Ь"=>"",
	"э"=>"e", "Э"=>"e", "ю"=>"u", "Ю"=>"u", "я"=>"ia", "Я"=>"ia", "ї"=>"yi","і"=>"i","І"=>"i", "Ї"=>"yi", "є"=>"e", "Є"=>"e");
	$str = strtr($str,$re_ar);
	$str=preg_replace('~\W~', '', $str);
	return $str;
}

/*#############################################################################
#####           Пользовательские viewers ("узкие")                        #####
#############################################################################*/

class jFuncCall extends control{
	function init(){
		parent::init();
		if(!empty($this->params['oninit'])) $this->do_call();
	}

	function make(){
		if(empty($this->params['oninit']))$this->do_call();
	}

	function do_call(){
		$fnk=$this->params['real_name'];
		if(function_exists($fnk)){
			if(empty($this->params['params']))$params=array();
			else $params=$this->params['params'];
			if(!is_array($params)) parse_str($params,$params);
			$params=array_merge($params,$this->ctrl);
			$params['parent']=&$this;
			$res=$fnk($params);
			if(empty($this->pg)) $this->pg=$res;
		}else set_error_ex('no_func',SYS_WRN,$fnk);
	}
}

/*****************************************************************************
*                           Функция обработки картинок                       *
******************************************************************************
* производит обработку файла картинки с генерацией пиктограмки. Картинки     *
* сохраняются в формате jpeg. Допустимые входные форматы - GIF, JPEG, PNG    *
******************************************************************************
* Входные параметры:                                                         *
*       $in_name  - ожидаемое имя картинки (имя поля в форме)                *
*       $out_name - имя, под которым картинку необходимо сохранить           *
*                   расширение неважно - будет установлено в .jpg            *
*       [$sz]     - ассоциативный массив контекста картинок. Пропущенные     *
*                   элементы будут выбраны из реестра (секция /system/pics)  *
*             tmb_x, tmb_y - размеры пиктограмки. Если хотя бы один из пара- *
*                   метров равен нулю, пиктограмка не создается              *
*             pic_px, pic_py - размеры картинки в книжной ориентации         *
*             pic_lx, pic_ly - размеры картинки в альбомной ориентации       *
*                   если хотя бы один из параметров ноль, картинка не        *
*                   обрезается                                               *
*             path  путь для сохранения картинки                             *
*             no_pic - картинка "нет картинки"                               *
*		[fix]		-Фиксирование одной из перезанных сторон				 *
*					0-ширину	1- высоту									 *
******************************************************************************
* Возвращаемое значение:                                                     *
*       имя файла картинки (без расширением и пути)                          *
*       или false в случае ошибочного типа картинки                          *
*****************************************************************************/

function j_make_image($in_name,$out_name,$sz=array(), $use_reg=true){
	// контекст картинки по умолчанию

	if ($use_reg) {
		if (!$GLOBALS[REG]->get_section('/system/pics',$sz_reg)) {
			set_error_ex('Unspecified picture proportions!',SYS_ERR);
			return '';
		}
		$sz=array_merge($sz_reg,$sz);
	}

	$tmp=$in_name;
	
	//echo $tmp.' '. file_exists($tmp);
	$inf=@getimagesize($tmp);

	if (empty($inf) || $inf[2]<1 || $inf[2]>3) return false;

	switch ($inf[2]) {
		case 1: $img=ImageCreateFromGIF($tmp); break;
		case 2: $img=ImageCreateFromJPEG($tmp); break;
		case 3: $img=ImageCreateFromPNG($tmp); break;
	}

	// prepare pic name
	if (empty($out_name) || (!empty($sz['no_pic']) && $out_name==$sz['no_pic'])) $out_name=uniqid('img',false);

	//Detect quality
	if(empty($sz['quality'])) $sz['quality']=100;

	//JOHN Генерация имен, фикс тумбнейла
	if(empty($sz['pic_nm'])) $sz['pic_nm']='{name}';
	if(empty($sz['tmb_nm'])) $sz['tmb_nm']='thumb_{name}';
	if(!isset($sz['pic_fix'])) $sz['pic_fix']=-1;
	if(!isset($sz['tmb_fix'])) $sz['tmb_fix']=-1;
	if(isset($sz['unsharp']) && (int) $sz['unsharp']<50 ) $sz['unsharp']=100;

	// process  tumbnail
	$i=min($sz['tmb_x'], $sz['tmb_y']);
	if ($i > 0) {
		//Вычисление пропорций
		$dx=$inf[0]/$sz['tmb_x']; $dy=$inf[1]/$sz['tmb_y'];
		if ($inf[0]>=$inf[1]) $pt='l'; else $pt='p';
		$sides=array('x','y');
		if($sz['tmb_fix']<0)	$mpl=min($dx,$dy);
		else 									$mpl=$inf[$sz['tmb_fix']]/$sz[ 'tmb_'.$sides[$sz['tmb_fix']] ];
		//Размеры превью
		$x=(int)$inf[0]/$mpl; $y=(int)$inf[1]/$mpl;

		// Создаю временные имеджи
		$tmb=ImageCreateTrueColor($x,$y);
		//$tmb=ImageCreateTrueColor($sz['tmb_x'],$sz['tmb_y']);

		if($sz['tmb_fix']<0){
			// find x,y and crop
			$px=(int)($x-$sz['tmb_x'])/2; $py=(int)($y-$sz['tmb_y'])/2;
		}else $px=$py=0;

		// Масштабирую превью
		ImageCopyResampled($tmb,$img,0,0,$px,$py,$x,$y,$inf[0],$inf[1]);
		// save tumbnail
		$path=sprintf('%s/%s',$sz['path'], str_replace('{name}',$out_name,$sz['tmb_nm']).'.jpg');
		if(!empty($sz['unsharp'])){
			$tmb=UnsharpMask($tmb, (int)($sz['unsharp']*2/($inf[0]/$x)), .5, 0);
		}
		ImageJPEG($tmb,$path,$sz['quality']);
	}

	// ПРоверка параметров
	$i=min($sz['pic_px'], $sz['pic_py'], $sz['pic_lx'], $sz['pic_ly']);

	// if -1 do nothing
	if ($i < 1) return $out_name;

	//Проверить, если картинка меньше чем нужно в настройке - ниче не делать
	if($inf[0]>$inf[1]){
		$cs=$inf[0]; $p='lx';
	}else{
		$cs=$inf[1]; $p='py';
	}
	//Если ничего не фиксируется и картинка меньше чем требуется - выдать как есть
	if( $sz['pic_fix']<0 && $cs< $sz['pic_'.$p]  ) $i=0;

	$out_name=str_replace('{name}',$out_name,$sz['pic_nm']).'.jpg';
	$path=sprintf('%s/%s',$sz['path'],$out_name);
	//$path=sprintf('%s/%s',$sz['path'],str_replace('{name}',$out_name,$sz['pic_nm']).'.jpg');

	if ( $i > 0){
		// resize main image
		if ($inf[0]>=$inf[1]) $pt='l'; else $pt='p';
		$sides=array('x','y');
		//echo '<pre class="debug">'.print_r ( $inf ,true).'</pre>';
		//координыты копирования нулевые
		$px=0;  $py=0;
		//Вычисление пропорций и(или) размеров результирующей картинки
		if($sz['pic_fix']<0){
			//Если не фиксировать размеры
			$mpl=max($inf[0]/$sz['pic_'.$pt.'x'],$inf[1]/$sz['pic_'.$pt.'y']);
			$w=$x=(int)$inf[0]/$mpl; $h=$y=(int)$inf[1]/$mpl;
		}else{
		  $fix_both=false;
			//Если фиксировать размеры
			if($sz['pic_fix']==2){//Если сказано зафиксировать обе стороны - т.е. Обработка как у превью
			  $fix_both=true;
				//Определяю по какой стороне приводить (должна быть меньшая)
				if($inf[0]<$inf[1]) $sz['pic_fix']=0; else $sz['pic_fix']=1;
				
				//Вычисление пропорций ширины и высоты
				$mpl=$inf[$sz['pic_fix']]/$sz[ 'pic_'.$pt.$sides[$sz['pic_fix']] ];
				
//echo '<br /> Приводить по '.$sz['pic_fix'];
				$x=(int)$sz['pic_'.$pt.'x'];
				$y=(int)$sz['pic_'.$pt.'y'];
//echo "<br /> Размеры картинки $x X $y";
//echo $inf[0].' '.$mpl;
				//Вычисление координат кропирования
				$px=(int)( $inf[0]*.5 - $x*.5*$mpl );
				//$py=(int)($y-$sz['pic_'.$pt.'y']/2);
				$py=(int)( $inf[1]*.5 - $y*.5*$mpl );
//echo ' '.$px.' '.$px*$mpl;
//echo "<br /> Кропировать $px X $py";
			}else{
			  //Вычисление пропорций ширины и высоты
			  $mpl=$inf[$sz['pic_fix']]/$sz[ 'pic_'.$pt.$sides[$sz['pic_fix']] ];
			}
			$w=(int)$inf[0]/$mpl; $h=(int)$inf[1]/$mpl;
			//Если фиксация только одной из сторон - размеры равны высоте и ширине
			if(!$fix_both){ $x=$w; $y=$h;}
		}
//echo "Размер:$x X $y Высота ширина: $w X $h <br /> Начиная с: $px , $py НА {$inf[0]},{$inf[1]} ";
		$tmp_img=ImageCreateTrueColor($x,$y);
		ImageCopyResampled($tmp_img,$img,
												0,0,
												$px,$py,
												$w,$h,
												$inf[0],$inf[1]
											);
		//imagecopyresampled  ( Куда , что , х_куда  , y_куда  , x_что  , y_что  , w_куда  , h_куда  , w_что  , $h_что  )
		// save original as
		if(!empty($sz['watermark']) &&  file_exists($sz['watermark']) ){
			//$fh=fopen('wm_log.txt', 'w');  fwrite($fh, print_r($sz,true)); fclose($fh);
			$wm=imagecreatefrompng($sz['watermark']);
			imagecopy($tmp_img, $wm, ($x*.5-200), ($y-150), 0, 0, 401, 150);
			//imagecopy($tmp_img, $wm, 0, 0, 0, 0, 401, 150); ImagePNG($wm,'tst.png');
		}

		if(!empty($sz['unsharp'])){
			$tmp_img=UnsharpMask($tmp_img, (int)($sz['unsharp']/($inf[0]/$w)), .5, 0);
		}

		ImageJPEG($tmp_img,$path,$sz['quality']);
	} else {
		// save main image without  resize
		ImageJPEG($img,$path,$sz['quality']);
	}
	return $out_name;
}

class list_editor extends form{
	function before_params_init(&$params){
		//получение конкретизирующих параметров
		if(empty($params['dir_name']) && !empty($params['name'])) $params['dir_name']=$params['name'];

		if(empty($params['dir_name'])) return;
		if(!$GLOBALS[REG]->get_reg_part('/directory/'.$params['dir_name'], $params))  set_error_ex("no_outside_definition", SYS_MSG,$params['name']);
		if(!empty($params['based_on'])) $base=$params['based_on'];
		else $base=false;
		while(!empty($base)){
			$tmp=array();
			$GLOBALS[REG]->get_reg_part($base, $tmp);
			$params=array_merge($tmp,$params);
			if(!empty($tmp['based_on']))$base=$tmp['based_on'];
			else $base=false;
		}
		if(!empty($params['url_stack'])) $params['url']=$params['url_stack'];
	}

	function params_init(&$params) {
		$this->before_params_init($params);
		parent::params_init($params);
	}

	function init(){
		$ucl=$this->params['ucl'];
		//foreach($this->ctrl as $k=>$v) $ucl=str_replace('{'.$k.'}',$v,$ucl);
		$ucl=strjtr( $ucl, $this->ctrl );
		$ucl=str_replace('{lang}',$GLOBALS['Jlib_lang'],$ucl);
		$this->base_data=$GLOBALS[CM]->run($ucl);
		$lines=array();
		foreach($this->base_data as $k=>$v){
			//складывание
			$line=$this->tpl['line'];
			foreach($v as $vk=>$vv) {
				if($vk==$this->params['ctrl_line']){
					$line=str_replace('{'.$vk.'}', $vv , $line);
					continue;
				}
				//форматирование
				if(!empty($this->params['format']) && !empty($this->params['format'][$vk])){
					$ftype=$this->params['format'][$vk];
					if(empty($this->format_table))
						if(!$GLOBALS[REG]->get_reg_part('/system/format',$this->format_table))
							set_error_ex('no_format_table', SYS_ERR);
					if(!empty($this->format_table[$ftype])){
						$vv=call_format_processor('display',$vv,$this->format_table[$ftype]);
					}
				}
				
				$line=str_replace('{value_'.$vk.'}', $vv , $line);
				$this->data[$vk.'_'.$k]=$vv;
				if(!empty($this->tpl[$vk])) $tmp=str_replace('{name}', $vk.'_'.$k, $this->tpl[$vk]);
				else 						$tmp=str_replace('{name}', $vk.'_'.$k, $this->tpl['default_field']);
				$line=str_replace('{'.$vk.'}', $tmp, $line);
			}
			$lines[]=$line;
		}
		
		$body=implode($this->tpl['separator'],$lines);
		$this->pg=str_replace('{body}',$body,$this->tpl['body']);
		if(!empty($_POST))$this->old_data=$this->data;
		parent::init();
	}

	function make_store($data){
		if(empty($this->params['store'])) $this->params['store'][]=$this->params['ucl'];
		if(!is_array($this->params['store'])) {
			$tmp=$this->params['store'];
			$this->params['store']=array();
			$this->params['store'][]=$tmp;
		}
		foreach($this->params['store'] as $k=>$v){
			$ucl=$v;
			foreach($this->ctrl as $ck=>$cv)	if(!empty($cv))$ucl=str_replace('{'.$ck.'}',$cv,$ucl);
			foreach($data as $ck=>$cv)			$ucl=str_replace('{'.$ck.'}',$cv,$ucl);
			$store[]=$ucl;
		}
		return $store;
	}

	function store($dt,$mode='update'){
		$store=$this->make_store($dt);
		foreach($store as $s) {
			$GLOBALS[CM]->run($s,$mode,$dt);
		}
	}

	function do_save(){
		$tdt=$this->data;
		//echo '<pre class="debug">'.print_r ( $this->base_data ,true).'</pre>';
		//echo '<pre class="debug">'.print_r ( $this->data ,true).'</pre>';
		foreach($this->base_data as $k=>$v){
			$dt=array();
			foreach($v as $vk=>$vv){
				if($vk==$this->params['ctrl_line']) continue;
				$tf=$vk.'_'.$v[ $this->params['ctrl_line'] ];
				//echo '<br />'.$tf.' '.$this->data[$tf];
				if( isset($this->data[$tf])  ) $dt[$vk]=$this->data[$tf];
				unset($this->data[$tf]);
			}
			if(empty($this->data['delete_'.$v[ $this->params['ctrl_line'] ]])){
				$mode='update';
			}else{
				$mode='delete';
				unset($this->data['delete_'.$v[ $this->params['ctrl_line'] ]]);
			}
			//echo '<pre class="debug">'.print_r ( $dt ,true).'</pre>';
			if($mode=='delete'||!empty($dt)){
				$dt[ $this->params['ctrl_line'] ]=$v[ $this->params['ctrl_line'] ];
				$this->store($dt,$mode);
			}
		}

		//Новое
		unset($this->data[$this->name]);
		$nw=false; foreach($this->data as $v) $nw|=!empty($v);
		if($nw) $this->store($this->data,'insert');
		$this->data=$tdt;
	}
}

function debug(){
echo '<pre>',print_r($GLOBALS['Jlib_page_extra'],true),'</pre>';
}

function myscandir( $dn ){	// служебная для функции editmsgs() - поиск файлов с данным расширением, рекурсивная, отфильтровывает 'svn/'
	$ra=array();
	if(
		strpos($dn,'svn/')!==false ||
		strpos($dn,'sync/')!==false ||
		strpos($dn,'/z_')!==false ||
		strpos($dn,'tiny_mce')!==false ||
		strpos($dn,'/img')!==false ||
		strpos($dn,'/fancybox')!==false ||
		strpos($dn,'/css')!==false ||
		strpos($dn,'/video')!==false
	) return $ra;
	$ea=array('php','txt','htm','html');
	if($dh=opendir($dn)){
		while($fn=readdir($dh)) if( $fn!=='.' && $fn!=='..' ){
			$fullname=$dn.$fn;
			if(is_dir( $fullname )){
				$ra=array_merge($ra,myscandir($fullname.'/'));
			}elseif(is_file( $fullname )){
				$ft=substr( $fn, strrpos($fn,'.')+1 );
				if(in_array( $ft, $ea	 )) $ra[ $fullname ]=array();
			}
		}
		closedir($dh);
	}
	return $ra;
}

function editmsgs(){	// в админке выводит для редактирования список мессаг из sys_msg и sys_err
	if(empty($_SESSION['Jlib_auth']['u_grp'])||$_SESSION['Jlib_auth']['u_grp']!='admin') return 'Err: admin access is required';

	// взять из базы
	$ma=array();
	$mt=mysql_query("SELECT * FROM sys_msg ORDER BY msg_id ASC");
	while($m=mysql_fetch_assoc($mt)){
		$mi=$m['msg_id'];
		if(!isset($ma[$mi])) $ma[$mi]=array();
		if(!isset($ma[$mi]['ln'])) $ma[$mi]['ln']=array(); $ma[$mi]['ln'][$m['ln']]=$m['msg'];
	}
	$mt=mysql_query("SELECT * FROM sys_err ORDER BY err_id ASC");
	while($m=mysql_fetch_assoc($mt)){
		$mi='err.'.$m['err_id'];
		if(!isset($ma[$mi])) $ma[$mi]=array();
		if(!isset($ma[$mi]['ln'])) $ma[$mi]['ln']=array(); $ma[$mi]['ln'][$m['ln']]=$m['msg'];
	}

	// взять из файлов и сопоставить
	$fa=myscandir( './' ); $ha=array('msg:','sys:','err:','?:'); foreach($fa as $fi=>$fv) {
	  if(!file_exists($fi)){ continue; }
		$trimlast=array("'",'"','}',')',']');
		$ta=explode( PHP_EOL, file_get_contents($fi) ); $tl=count($ta); for($ti=0;$ti<$tl;++$ti){
			$tv=$ta[$ti]; foreach($ha as $hv){
				$pl=strlen($hv)-1; $p1=-1; while( ($p1=strpos($tv,$hv,$p1+1))!==false && $p1+1<strlen($tv) ){
					if($p1>0) $ps=array($tv[$p1-1]); else $ps=array(' '); if($ps[0]=='$'||$ps[0]=='-') continue; $pb=0;
					$pi=$p1+$pl-1; for(;$pi<strlen($tv);++$pi){
						if( $tv[$pi]=='{' || $tv[$pi]=='(' || $tv[$pi]=='[' ) { ++$pb; $ps[$pb]=$tv[$pi]; }
						if($ps[$pb]=='(')$ps[$pb]=')'; if($ps[$pb]=='{')$ps[$pb]='}'; if($ps[$pb]=='[')$ps[$pb]=']';
						if( $tv[$pi]==$ps[$pb] ) --$pb;
						if( $pb<0 ){
							if($pi+1<strlen($tv) && $tv[$pi+1]=='.') { $pb=0; $ps=array(';'); }
							else break;
						}
					}
					$p2=$pi+2; $tt=trim(substr($tv,$p1-1,$p2-$p1)); if($tt){
						$t1=$tt[0]; $t2=$tt[strlen($tt)-1];
						if( $t1=='{'&&$t2=='}' || ($t1==$t2&&($t1=='"'||$t1=="'"||$t1=='-')) ) $mi=trim(substr($tt,$pl+2,-1)); else $mi=trim(substr($tt,$pl+2));
						//echo $fi,' | ',$tt,' | ',$mi,'<br>';
						if($mi) for($ci=strlen($mi)-1;$ci>=0;--$ci){ $cc=$mi[$ci]; if( $cc=='*' || $cc=='\\' || $cc==')' || $cc=='&' || $cc=='$' ){ $mi=''; break; }}
						if($mi){
							if(!isset($ma[$mi])) $ma[$mi]=array(); if(!isset($ma[$mi]['ln'])) $ma[$mi]['ln']=array();
							if(!isset($ma[$mi]['fa'])) $ma[$mi]['fa']=array();
							if(!isset($ma[$mi]['fa'][$fi])) $ma[$mi]['fa'][$fi]=array();
							if(!isset($ma[$mi]['fa'][$fi][$hv])) $ma[$mi]['fa'][$fi][$hv]=array(); $ma[$mi]['fa'][$fi][$hv][]=$ti;
							if(!isset($fa[$fi][$mi])) $fa[$fi][$mi]=array();
							if(!isset($fa[$fi][$mi][$hv])) $fa[$fi][$mi][$hv]=array(); $fa[$fi][$mi][$hv][]=$ti;
						}
					}
				}
			}
		}
	}
	ksort($ma);	//echo '<pre>$ma = ',print_r( $ma ,true),'</pre>';
	ksort($fa);	//echo '<pre>$fa = ',print_r( $fa ,true),'</pre>';

	// подготовить вывод

	//$la=array_flip(split(',', $GLOBALS['Jlib_defaults']['langset'] ));
	$la=array_flip(explode(',', $GLOBALS['Jlib_defaults']['langset'] ));
	//foreach($ma as $mv) foreach($mv['ln'] as $li=>$lv) $la[$li]=1;
	$ll=count($la);
	$res="\n".'<tr valign="top"><td colspan="2"><a href="#add" onclick="addmsg();return false;">добавить новое</a><br><span id="_-_"></span><div id="_--_" style="display:none;"></div></td></tr>'."\n";
	foreach($ma as $mi=>$mv){
		$ts='<td width="40%"><a name="'.$mi.'"><b>'.$mi.'</b></a>';
		if(!empty($mv['fa'])){
			$ts.='<span style="color:#999999;">';
			ksort($mv['fa']);
			foreach($mv['fa'] as $fi=>$fv){
				$ts.='<br>'.$fi.': ';
				foreach($fv as $hi=>$hv){
					$ts.=$hi.' '; $tk=0;
					foreach($hv as $ti){
						if($tk) $ts.=', '; $tk=1;
						$ts.=$ti;
					}
				}
			}
			$ts.='</span>';
		}
		$ts.='</td><td>';
		if( strpos($mi,'{')!==false || strpos($mi,'}')!==false ) $ts.='проверь наличие всех возможных вариантов';
		else{
			foreach($la as $li=>$lv) $ts.="\n<a href=\"#edit\" onclick=\"editmsg('$mi','$li');return false;\"".
				( empty($mv['ln'][$li]) ? ( empty($mv['fa']) ? ' style="color:#990000;"' : ' style="color:#990000;font-weight:bold;"' ) : '' ).
				">$li</a>: <span id=\"_{$mi}-{$li}_\">".
				( empty($mv['ln'][$li]) ? '' : $mv['ln'][$li] ).
				"</span><div id=\"_{$mi}--{$li}_\" class=\"ifrm\" style=\"display:none;\"></div><br>";
		}
		$ts.='</td>';
		$res.="\n<tr".(empty($ma[$mi]['fa'])?' style="color:#666666;"':'').' valign="top">'.$ts."</tr>\n";
	}
	// завернуть в обертку и отдать на вывод
	return "
		<script type=\"text/javascript\" src=\"http://www.google.com/jsapi\"></script>
		<script type=\"text/javascript\" src=\"/js/JsHttpRequest.js\"></script>
		<script type=\"text/javascript\" src=\"/js/cms/admin_messages.js\"></script>
		<style>.ifrm{display:inline-block;}</style>
		<div style=\"display:none;\" id=\"sessID\">". session_id() ."</div>
		<table border=\"0\" width=\"100%\">{$res}</table>";
}

class get_form extends form{
	function init($auto_parse=true){
	  parent::init(false);
	  if(isset($_GET[$this->name])){
			 //$_POST=&$_GET;
			//echo "IN";
			$this->data=&$_GET;
		}elseif(!empty($this->ctrl)){
			$this->data=$this->ctrl;
		}
		
	  parent::init($auto_parse);
	  $this->form_params['method']='GET';
	}
}

if(
	empty( $_SESSION['Jlib_auth']) ||
	empty( $_SESSION['Jlib_auth']['u_themes'])
) require_once 'lib/reg_wizard.php';

class reg_handler extends handler{
	function handle(){
	  if(!empty($_GET['reg_skip'])){  $_SESSION['reg_skip']=true; redirect( '/' );}
	  if(!empty($_GET['reg'])){
			unset($_SESSION['reg_skip']);
			
			if(!empty($GLOBALS['Jlib_page_extra']) && $GLOBALS['Jlib_page_extra'][0]!='loginza')
				redirect( '/' );
		}
	  
	  if(empty($_SESSION['reg_skip'])){
	    if( empty($_SESSION['Jlib_auth']) ){
				$this->add_reg_obj();
	    }elseif( empty($_SESSION['Jlib_auth']['u_themes']) ){
	      if( $GLOBALS['Jlib_target']!='catigories' ) {
					redirect('/catigories'); exit();
				}
	      $this->add_reg_obj();
			}
		  if(!empty($_SESSION['Jlib_auth_ref'])){
		    $r=$this->get_url('Jlib_target='.$_SESSION['Jlib_auth_ref']);
		    unset($_SESSION['Jlib_auth_ref']);
		    redirect( $r );
		    exit();
			}

		}
	}
	function add_reg_obj(){
	    $GLOBALS[REG]->get_object('/controls','lite_reg',$params);
	    $params['wizard']='registration';
			$obj=new lite_reg($params,$this);
			$this->tpl=array();$this->params['tpl']='';
			$this->pg='{'.$obj->params['name'].'}';
			$this->add($obj);
	}
}

function reg_check_name($obj){
  if( empty($obj->data['name']) || empty($obj->data['email'])) return false;
  $t=$GLOBALS[CM]->run('sql:user?u_email=\''. mysql_real_escape_string($obj->data['email']) .'\'$shrink=yes');
  if(!empty($t)) {
		set_error_ex('Пользователь с таким e-mail уже зарегистрирован');
		return false;
	}
	return true;
}

function reg_build_cats($obj){
	//$t=$GLOBALS[CM]->run('sql:theme');
	//echo '<pre class="debug">'.print_r ( $t ,true).'</pre>';
	$t=new list_viewer(array(
	    'ctrl'=>'t_id',
	    'vars'=>'t_id',
	    'url'=>'t_id',
	    'ucl'=>'sql:theme?t_fs_id=\'\' AND t_pid=0 ',
	    'quantity'=>false,
	));
	$t->tpl=array(
	  'body'=>$obj->tpl['categories'],
	  'line'=>$obj->tpl['categories_line'],
	  'separator'=>$obj->tpl['categories_sep'],
	  'empty'=>$obj->tpl['categories_empty'],
	);
	$t->get_maked();
	$obj->parsed=false;
	$obj->maked=false;
	return $t->pg;
}

function get_page($source_domain, $link){
		$fp = fsockopen($source_domain, 80, $errno, $errstr, 30);
		if (!$fp) {
		    //echo "$errstr ($errno)<br />\n";
		} else {
	    $out = "GET $link HTTP/1.1\r\n";
	    $out .= "Host: $source_domain\r\n";
	    $out .= "Connection: Close\r\n\r\n";
	    fwrite($fp, $out);
	    $i=0; $start=false; $sqler=500; $sqlcnt=$sqler; $content='';
	    while (!feof($fp) ){
	        $dn=fgets($fp);
	        if(!$start){
						//echo 'Заголовок: '.$dn.'<br>';
	        	if( strpos($dn, '404')!==false ){ $content="404"; fclose($fp); break; }
		        if($dn=="\r\n") $start=true;
						continue;
					}
	        $content.=$dn;
	        $i++; $sqlcnt--;
	    }
	    @fclose($fp);
		}
		return $content;
}

function server_name(){
  return $_SERVER['SERVER_NAME'];
}

function loginza_token_url(){
	$rs='http://'.$_SERVER['SERVER_NAME'].'/loginza/?reg=true&ref='.$GLOBALS['Jlib_target'];
	return urlencode($rs);
}
function show_ip(){
	return '93.72.207.151';
	return !empty($_SERVER['HTTP_CLIENT_IP']) ?
          $_SERVER['HTTP_CLIENT_IP'] : (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) ?
                  $_SERVER['HTTP_X_FORWARDED_FOR'] : (!empty($_SERVER['REMOTE_ADDR']) ?
                          $_SERVER['REMOTE_ADDR'] : null));
}
function show_geo(){
	if(!empty($_GET['lat']) && !empty($_GET['lng'])){
	  $_SESSION['geolocation']=array(
	    'lat'=>$_GET['lat'],
	    'lng'=>$_GET['lng'],
		);
	}
	if(!empty($_SESSION['geolocation'])) return $_SESSION['geolocation']['lat'].','.$_SESSION['geolocation']['lng'];
	else{
	  //Обращение к сервису
	  $ip=show_ip();
	  $json=get_page('freegeoip.net','/json/'.$ip );
		if(empty($json)) return '';
		$dt=json_decode($json);
		if(empty($dt)) return '';
		$_SESSION['geolocation']['lat']=$dt->latitude;
		$_SESSION['geolocation']['lng']=$dt->longitude;
		$_SESSION['geolocation']['city']= strtolower($dt->city);
		$_SESSION['geolocation']['reg']= strtolower($dt->region_name);
		
		/*
		$rega='~<Latitude>([^<]+)</Latitude>\s+<Longitude>([^<]+)</Longitude>~';
	  preg_match_all($rega, $content, $m);
		if( !empty($m) && !empty($m[1][0]) && !empty($m[1][0])){
			$_SESSION['geolocation']['lat']=$m[1][0];
			$_SESSION['geolocation']['lng']=$m[2][0];
			
			return $m[1][0].','.$m[2][0];
		}else{
		  return 'false';
		}
		*/
	}
}

function logo_link($prm){
	if( $GLOBALS['Jlib_page'] =='default' ) $sec='not_logo_link';
	else $sec='logo_link';

	return $prm['parent']->parent->tpl[$sec];
}
?>