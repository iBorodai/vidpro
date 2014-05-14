<?php
class ajax extends icontrol{
	function before_parse(){
		if(!empty($_REQUEST['mode'])) {
			switch($_REQUEST['mode']) {
			  case 'points_comm_last':{
					$this->pg=show_geo();
					//Вывожу
       		$t=new list_viewer(array('dir_name'=>'comms_list_last'));
							
					$queries=array();
					
			    if( !empty($_SESSION['geolocation']['city']) ){
			      if(!isset($queries[0])) $queries[0]=array();
			      $queries[0][]=str_replace('{city}',("'".$_SESSION['geolocation']['city']."','".$_SESSION['geolocation']['reg']."'"),$t->params['ucl_city']);
					}
					
					if( !empty($_SESSION['Jlib_auth']['u_themes']) ){
					  if(!isset($queries[0])) $queries[0]=array();
					  $queries[0][]=str_replace('{themes}',$_SESSION['Jlib_auth']['u_themes'],$t->params['ucl_themes']);
					}
					
					if(!empty($queries[0])) $queries[0]=implode(' AND ', $queries[0]);
					if(!empty($queries[1])) $queries[1]=implode(' AND ', $queries[1]);
					$repl['queries']=' AND ('.implode(') OR (', $queries).')';
					
			    $t->params['ucl'] = strjtr($t->params['ucl'], $repl);
			    $t->params['page_ctrl']='t_pg';
			    $t->params['vars'].='&t_pg='. intval($_REQUEST['page']);
			    $t->init();
			    $t->get_maked();
			    
			    if(empty($t->ctrl['theme']))
        		$title=$t->tpl['title_def'];
			    else
			      $title=$GLOBALS[CM]->run('sql:theme#t_name?t_url=\''. mysql_real_escape_string($t->ctrl['theme']) .'\'$shrink=yes');
			    $this->pg = str_replace('{title}',$title,$t->pg);
			    
			    //Рекомендовать в списке только для авторизированных
			    if(!empty($_SESSION['Jlib_auth']))$rec_func=$t->tpl['rec_func'];
			    else $rec_func='';
			    $this->pg = str_replace('{rec_func}',$rec_func,$this->pg);
			    
			    unset($t);

			    break;
				}
				case 'points_user_subscribed':{
       		$t=new list_viewer(array('dir_name'=>'comms_user_subscribed'));
			    $t->get_maked();
			    $this->pg = str_replace('{title}', $t->tpl['title_users'] ,$t->pg);
			    
					//Рекомендовать в списке только для авторизированных
			    if(!empty($_SESSION['Jlib_auth']))$rec_func=$t->tpl['rec_func'];
			    else $rec_func='';
			    $this->pg = str_replace('{rec_func}',$rec_func,$this->pg);
			    unset($t);
				  break;
				}
				case 'points_subscribed':{
       		$t=new list_viewer(array('dir_name'=>'comms_points_subscribed'));
			    $t->get_maked();
			    $this->pg = str_replace('{title}', $t->tpl['title_points'] ,$t->pg);

					//Рекомендовать в списке только для авторизированных
			    if(!empty($_SESSION['Jlib_auth']))$rec_func=$t->tpl['rec_func'];
			    else $rec_func='';
			    $this->pg = str_replace('{rec_func}',$rec_func,$this->pg);
			    unset($t);
				  break;
				}
				case 'points_group':{
				  $this->pg=show_geo();
					break;
				}
				case 'send_review':{
					if(empty($_REQUEST['point']) || empty($_REQUEST['text'])){
						$GLOBALS['result']['error']='не переданы данные';
						return false;
					}
					
					$text=mysql_real_escape_string( strip_tags($_REQUEST['text']) );
					if(strlen($text)>255){
						$tst=strpos($text, ' ', 200);
						if( $tst>252 ) $tst=252;
						$short=substr($text, 0, $tst).'...';
					}else
					  $short=$text;

					if(!empty($_REQUEST['recomend'])) {
					  //l_id 	l_weight 	l_type 	l_key_obj 	l_key_u 	l_date
					  $like=( ($_REQUEST['recomend']>0)?1:-1 );
						$l_id=$GLOBALS[CM]->run('sql:likes','replace',array(
						  'l_type'=>'pnt',
							'l_key_obj'=> intval($_REQUEST['point']),
							'l_key_u'=>$_SESSION['Jlib_auth']['u_id'],
							'l_date'=>date('Y-m-d H:i:s'),
							'l_weight'=>$like
						));
					}else{
					  $like=0;
					}
					//echo '<pre class="debug">'.print_r ( $_REQUEST ,true).'</pre>';
					if(!empty($_REQUEST['parent'])) {
					  if( !is_numeric($_REQUEST['parent']) ) exit();
					  $parent=$_REQUEST['parent'];
					}else{
					  $parent=0;
					}
					
					
					$dt=array(
					  'com_type'=>'pnt',
						'com_key_obj'=> intval($_REQUEST['point']),
						'com_pid'=> $parent,
						'com_key_u'=>$_SESSION['Jlib_auth']['u_id'],
						'com_date'=>date('Y-m-d H:i:s'),
						'com_weight'=>$like,
						'com_text'=>$text,
						'com_short'=>$short
					);
					
					if(!empty($_REQUEST['com_id'])) {
					  $GLOBALS[CM]->run('sql:comment#com_text,com_short,com_date?com_id='.intval($_REQUEST['com_id']) ,'update',$dt);
					}else{
					  $com_id=$GLOBALS[CM]->run('sql:comment','insert',$dt);
						if(!empty($com_id)){
						}else{
						  $GLOBALS['result']['error']='Отзыв не добавлен';
						  $this->pg='';
						  return false;
						}
					}
					
					
					if(!empty($_REQUEST['parent']) || !empty($_REQUEST['com_id'])){
				    $tpl=$this->tpl['send_answer_success'];
				    $ans=str_replace('{com_id}',$com_id,$tpl);
				    $ans=strjtr($ans, $dt);
				    $ans=strjtr($ans, $_SESSION['Jlib_auth']);
				    $this->pg=preg_replace('~\{[^\}]+\}~', '', $ans)  ;
					}else
					  $this->pg=$this->tpl['send_review_success'];
				  break;
				}
				case 'send_vote':{
					if(empty($_REQUEST['point']) || empty($_REQUEST['recomend'])){
						$GLOBALS['result']['error']='Data not send';
						return false;
					}

				  $like=( ($_REQUEST['recomend']>0)?1:-1 );
					$l_id=$GLOBALS[CM]->run('sql:likes','replace',array(
					  'l_type'=>'pnt',
						'l_key_obj'=> intval($_REQUEST['point']),
						'l_key_u'=>$_SESSION['Jlib_auth']['u_id'],
						'l_date'=>date('Y-m-d H:i:s'),
						'l_weight'=>$like
					));
					
					if( mysql_error() ){
					  $GLOBALS['result']['error']='Отзыв не добавлен';
					}else
					  $this->pg=$this->tpl['send_vote_success'];
				  break;
				}
				case 'store_profile':{
/*
<pre class="debug">Array
(
    [Jlib_target] => ajax
    [pro_name] => Иван
    [pro_sname] => Бородай
    [pro_gender] => m
    [pro_bdate] =>
    [fields] => Array
        (
            [0] => block
        )

    [mode] => store_profile
    [Jlib_lang] => RU
    [Jlib_skin] =>
)
</pre><pre class="debug">Array
(
    [avatar] => Array
        (
            [name] =>
            [type] =>
            [tmp_name] =>
            [error] => 4
            [size] => 0
        )

)
</pre>
*/
					$data=array(
					  'u_name'=> 	mysql_real_escape_string($_REQUEST['pro_name']) ,
					  'u_sname'=>	mysql_real_escape_string($_REQUEST['pro_sname']) ,
					  'u_gender'=>'',
					  'u_bdate'=>'',
					);

					if(!empty($_FILES['avatar']['name']) && empty($_FILES['avatar']['error'])){
					  $fname=date('ymdhis').uniqid('');
					  $tmim=j_make_image(
							$_FILES['avatar']['tmp_name'] ,
							$fname ,
							array(
								'tmb_x' => '-1',
								'tmb_y' => '-1',
								'pic_px' => '180',
								'pic_py' => '180',
								'pic_lx' => '180',
								'pic_ly' => '180',
								'pic_fix' => 2,
								'no_pic' => 'nophoto',
								'path' => 'img/users',
							),
							false
						);
						if($tmim){
						  $data['u_img']='/img/users/'.$fname.'.jpg';
						  $_SESSION['Jlib_auth']['u_img_path']=$data['u_img'];
						  $_SESSION['Jlib_auth']['u_img']=$data['u_img'];
						}
					}
					if(!empty($_REQUEST['pro_gender'])){
					  $data['u_gender']=($_REQUEST['pro_gender']=='f')?'f':'m';
					}
					if(!empty($_REQUEST['pro_bdate']))
						$data['u_bdate']= date_processor('store',$_REQUEST['pro_bdate'],array('store' => 'Y-m-d','display' => 'd.m.Y') );
						
					$GLOBALS[CM]->run('sql:user?u_id='.$_SESSION['Jlib_auth']['u_id'],'update',$data);
					if( mysql_error() ){
					  $this->pg=$this->tpl['profile_store_fail'];
					}else{
          	$this->pg=$this->tpl['profile_store_success'];
          	$_SESSION['Jlib_auth']=array_merge($_SESSION['Jlib_auth'], $data);
          }
          
          $this->pg=strjtr($this->pg,$_SESSION['Jlib_auth']);
				  break;
				}
				case 'search_points':{
				  if(!empty($_REQUEST['val']['reg_new'])) {
				    $this->pg='';
				    return true;
					}
				  //echo '<pre class="debug">'.print_r ( $_REQUEST ,true).'</pre>';
					if(empty($_REQUEST['val'])){
						$GLOBALS['result']['error']='не передан запрос для поиска';
						return false;
					}
					if(empty($_REQUEST['query']['reg'])){
						$GLOBALS['result']['error']='не передан регион поиска';
						return false;
					}
					
					$GLOBALS['result']['val']=$_REQUEST['val']['query'];
					$GLOBALS['result']['reg']=$_REQUEST['val']['reg'];

					$query=preg_replace('/[\-+\/\\_&^%$#*!`"]/',' ',$_REQUEST['val']['query']);
					$query=explode(' ',$query);

					$inp=array();
					foreach($query as $v){
						if(!empty($v) && empty($inp[$v])) {
						  $v=strtr($v, array("'"=>'`'));
						  mysql_real_escape_string($v);
							$inp[$v]="sw_word LIKE '".$v."%'";
							//$inp[$v]="sw_word = '".$v."'";
						}
					}
					//array_unshift($inp, "sw_word LIKE '%".implode(' ', $query)."%'");
					//echo '<pre class="debug">'.print_r ( $inp ,true).'</pre>';
					
					if(empty($inp)){
						$GLOBALS['result']['error']='Слова не разобраны';
						return false;
					}

					$inp='('.implode(' OR ',$inp).')';

					$lim=(empty($_REQUEST['limit']) || !is_numeric($_REQUEST['limit']))?5:$_REQUEST['limit'];
					
					$ucl='sql:search_words_index, point, region
								#p_id,p_url,p_fsid,p_name,p_img,p_dscr,p_key_reg,p_addr,p_lat,p_lng,p_createdate,
								 count( p_id ) words,
								 (select GROUP_CONCAT(t_name) FROM point2theme,theme WHERE p2t_key_p=p_id AND t_id=p2t_key_t GROUP BY p_id) p_themes
								?p_key_reg=r_id AND p_id=sw_key_obj AND sw_obj_type=\'pnt\' AND '.$inp.' AND r_url=\''. $_REQUEST['val']['reg'] .'\'
								$order=words,p_name direction=desc,asc group=p_id auto_query=no ';
					if(!$total=$GLOBALS[CM]->run($ucl,'count'))$total=0;
					$GLOBALS['result']['count']=($total>$lim)?$total-$lim:$total;

					$repl=array(
					  'count'=>$GLOBALS['result']['count'],
					  'total'=>$total,
					  'limit'=>$lim,
					  'val'=>$GLOBALS['result']['val'],
					  'reg'=>$GLOBALS['result']['reg'],
					);
					
					if($GLOBALS['result']['count']>0){
						$q=$GLOBALS[CM]->run($ucl.' limit=0,'.$lim);
						$lines=array();
						foreach($q as $v){
							$v['url']=$this->get_url( 'Jlib_target=point/'.$v['p_url'] );
							$lines[]=strjtr( $this->tpl['search_line'], $v );
						}
						
						$this->pg=str_replace('{body}',implode('',$lines) ,$this->tpl['search_body']);
						$this->pg=strjtr( $this->pg, $repl);
					}else
						$this->pg=$this->tpl['search_noresults'];
						
					unset($GLOBALS['result']['content']);
					break;
				}
				case 'show_interest':{
				  $data=$GLOBALS[CM]->run('sql:theme LEFT JOIN user2theme ON(u2t_key_t=t_id AND u2t_key_u='.$_SESSION['Jlib_auth']['u_id'].')');
				  $this->pg='';
				  foreach($data as $v){
				    $l=strjtr($this->tpl['interest_category'],$v);
				    if( $v['u2t_key_u'] ) $l=str_replace('{checked}','checked',$l);
				    $this->pg.=$l;
					}
				  break;
				}
				case 'send_interest':{
					if(empty($_REQUEST['themes'])){
						$GLOBALS['result']['error']='Data not send';
						return false;
					}

					$GLOBALS[CM]->run('sql:user2theme?u2t_key_u='.$_SESSION['Jlib_auth']['u_id'].' AND u2t_key_t NOT IN('.implode(',', $_REQUEST['themes'] ).')','delete');
					$sql="REPLACE into user2theme values "; $vals=array();
					foreach($_REQUEST['themes'] as $v){
					  $vals[]='('.$_SESSION['Jlib_auth']['u_id'].', '.$v.' )';
					}
					$sql.=implode(',', $vals);
					$db=init_db();
					$db->query($sql);

					if( mysql_error() ){
					  $GLOBALS['result']['error']='Данные не сохранены';
					}else
					  $this->pg=$this->tpl['send_interest_success'];
				  break;
				}
				case 'com_alarm':{
					if(empty($_REQUEST['com_id']) ){
						$GLOBALS['result']['error']='Data not send';
						return false;
					}
					//Смотрю, что за комент
					if(!$data=$GLOBALS[CM]->run('sql:comment,point,user o, user s
					                        #com_id,com_pid,com_type,com_key_obj,com_key_u,com_date,com_weight,com_text,com_short,com_cachelikes,com_cahecomms,
					                        p_id,p_url,p_name,p_img,
																	o.u_id o_id,o.u_url o_url,o.u_email o_email,o.u_name o_name,o.u_sname o_sname,o.u_img  o_img,
																	s.u_id s_id,s.u_url s_url,s.u_email s_email,s.u_name s_name,s.u_sname s_sname,s.u_img  s_img
																	?p_id=com_key_obj AND
																	 o.u_id=com_key_u AND
																	 s.u_id='. $_SESSION['Jlib_auth']['u_id'] .' AND
																	 com_id='.intval($_REQUEST['com_id'])
																	.'$limit=0,1 shrink=yes'
					)){
					  if( mysql_errno() )
					    $GLOBALS['result']['error']= mysql_error();
					    $this->pg=''; return false;
					}
          //echo 'data:<pre class="debug">'.print_r ( $data ,true).'</pre>'; exit();
					
					require_once 'lib/class.phpmailer.php';
					$tpl=load('mail/com_alarm.htm');

				  $data['proj_email_name']=$GLOBALS['Jlib_defaults']['proj_email_name'];
				  $data['proj_email']=$GLOBALS['Jlib_defaults']['proj_email'];
				  
				  $data['server']=$_SERVER['SERVER_NAME'];
				  $msg=strjtr($tpl, $data);

					$mail = new PHPMailer();
					$mail->From = $GLOBALS['Jlib_defaults']['proj_email'];
					$mail->FromName = $GLOBALS['Jlib_defaults']['proj_email_name'];
					$mail->IsHTML(true);
					$mail->AddAddress($GLOBALS['Jlib_defaults']['proj_email']);
					$mail->Subject = 'Жалоба на комментарий на Vidguk.pro';
					$mail->Body = $msg;
					$mail->Send();
				  break;
				}
				case 'com_del':{
					if(empty($_REQUEST['com_id'])){
						$GLOBALS['result']['error']='Data not send';
						return false;
					}

          $GLOBALS[CM]->run('sql:comment?com_id='.intval($_REQUEST['com_id']).' AND (com_key_u='.$_SESSION['Jlib_auth']['u_id'].' OR \''.$_SESSION['Jlib_auth']['u_grp'].'\'=\'adm\')$limit=0,1 debug=yes','delete');
          if( mysql_affected_rows()<1 ){
            if( mysql_errno() )
            	$GLOBALS['result']['error']= mysql_error();
            else
              $GLOBALS['result']['error']= 'Коментарий не удален.';
		        $this->pg='';
						return false;
					}
				  break;
				}
				case 'admin_cover':{
				  //Проверки
					if( $_SESSION['Jlib_auth']['u_grp']!='adm' ){
					  $GLOBALS['result']['error']='Access denied';
						return false;
					}
					if( empty($_REQUEST['p_id']) || empty($_FILES['cover']['name']) ){
						$GLOBALS['result']['error']='Data not send';
						return false;
					}
					if( !empty($_FILES['cover']['error'] ) ){
					  $GLOBALS['result']['error']='Upload file error: '+$_FILES['cover']['error'];
						return false;
					}
          //Работа
          $ext=pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);
          $pfn=intval($_REQUEST['p_id']);
          $fnm='img/point/'.$pfn.'_original.'.$ext;
          
          if(!$img_nm=j_make_image(
						$_FILES['cover']['tmp_name'],
						$pfn,
						array(
      				'tmb_x' => '-1',
							'pic_px' => '1024',
							'pic_py' => '1024',
							'pic_lx' => '1024',
							'pic_ly' => '1024',
							'path'=>'img/point/'
						),false)
					){
            $GLOBALS['result']['error']='Copy image error';
						return false;
					}
          if(!$tmb_nm=j_make_image(
						$_FILES['cover']['tmp_name'],
						$pfn,
						array(
      				'tmb_x' => '-1',
							'pic_px' => '150',
							'pic_py' => '150',
							'pic_lx' => '150',
							'pic_ly' => '150',
							'pic_fix' => 2,
							'pic_nm' => 'tmb_{name}',
							'path'=>'img/point/'
						),false)
					){
            $GLOBALS['result']['error']='Copy tmb error';
						return false;
					}

					$img_nm='img/point/'.$tmb_nm;
          $GLOBALS[CM]->run('sql:point#p_img?p_id='.intval($_REQUEST['p_id']),'update',array(
            'p_img'=>$img_nm,
					));
          if( mysql_affected_rows()<1 && mysql_errno()){
            $GLOBALS['result']['error']= mysql_error();
		        $this->pg='';
						return false;
					}
					$this->pg=$img_nm;
				  break;
				}
				case 'subscribe':{
					if( empty($_REQUEST['type']) || empty($_REQUEST['obj']) ){
						$GLOBALS['result']['error']='Data not send';
						return false;
					}
					$o_id=intval($_REQUEST['obj']);
					$tpl=load('point.htm');
					switch($_REQUEST['type']){
					  case 'point':
					    $GLOBALS[CM]->run('sql:user2point','replace',array(
		            'u2p_key_u'=>$_SESSION['Jlib_auth']['u_id'],
		            'u2p_key_p'=>$o_id
							));
							$tvar='subscribed';
					  	break;
					  case 'user':
					    $GLOBALS[CM]->run('sql:user2user','replace',array(
		            'u2u_sub'=>$_SESSION['Jlib_auth']['u_id'],
		            'u2u_sig'=>$o_id
							));
							$tvar='unsubscribe_user';
							break;
					}
					
          if( mysql_affected_rows()<1 && mysql_errno() ){
            $GLOBALS['result']['error']= mysql_error();
		        $this->pg='';
						return false;
					}

					$this->pg=str_replace('{p_id}',$o_id, $tpl[ $tvar ]);
					$this->pg=str_replace('{u_id}',$o_id, $this->pg);
				  break;
				}
				case 'unsubscribe':{
				  
					if( empty($_REQUEST['type']) || empty($_REQUEST['obj']) ){
						$GLOBALS['result']['error']='Data not send';
						return false;
					}
					$o_id=intval($_REQUEST['obj']);
					$tpl=load('point.htm');
					switch($_REQUEST['type']){
					  case 'point':
					    $GLOBALS[CM]->run(
								'sql:user2point?u2p_key_u='.$_SESSION['Jlib_auth']['u_id'].' AND u2p_key_p='.$o_id,
								'delete'
							);
							$tvar='not_subscribed';
					  	break;
					  case 'user':
					    $GLOBALS[CM]->run(
								'sql:user2user?u2u_sub='.$_SESSION['Jlib_auth']['u_id'].' AND u2u_sig='.$o_id.'$debug=yes',
								'delete'
							);
							$tvar='subscribe_user';
					  	break;
					}

          if( mysql_affected_rows()<1 && mysql_errno() ){
            $GLOBALS['result']['error']= mysql_error();
		        $this->pg='';
						return false;
					}

					$this->pg=str_replace('{p_id}',$o_id, $tpl[$tvar]);
					$this->pg=str_replace('{u_id}',$o_id, $this->pg);
				  break;
				}
			}
		}
		
	}
	function after_make(){
		if(!empty($_REQUEST['swf'])) exit($this->pg);
		if(empty($GLOBALS['result']['content'])) $GLOBALS['result']['content']=$this->pg;
		$this->pg='';
		return true;
	}
}
function figbr($v){
	return '{'.$v.'}';
}
function d2t($dday,$m) {
	$dday=(int) $dday;
    $dday=$dday-floor($dday/100)*100;
    if($dday>=15) $dday=$dday-floor($dday/10)*10;
    $tg='';
    if(($dday<15 && $dday>4) || $dday==0) $tg=$m[0];//msgs('goodsOV');
    elseif($dday>1 && $dday<5) $tg=$m[1];//msgs('goodsA');
    else $tg=$m[2];//msgs('goodsOne');
    return $tg;
}
?>