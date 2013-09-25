<?php
class ajax extends icontrol{
	function before_parse(){
		if(!empty($_REQUEST['mode'])) {
			switch($_REQUEST['mode']) {
			  case 'points_comm_last':{
					$this->pg=show_geo();
					
					//Вывожу
			    $t=new list_viewer(array('dir_name'=>'comms_list_last'));
			    if( !empty($_SESSION['geolocation']['city']) ){
			      $repl=array(
			        'city_place'=>$this->params['ucl_city'],
				      'city'=>"'".$_SESSION['geolocation']['city']."','".$_SESSION['geolocation']['reg']."'",
						);
					}else{
					  $repl=array(
					    'city_place'=>'',
					  );
					}
					if( !empty($_SESSION['Jlib_auth']['u_themes']) ){
					  $repl['themes_place']=$t->params['ucl_themes'];
					  $repl['themes']=$_SESSION['Jlib_auth']['u_themes'];
					} else $repl['themes_place']='';
			    $t->params['ucl'] = strjtr($t->params['ucl'], $repl);
			    $t->params['page_ctrl']='t_pg';
			    $t->params['vars'].='&t_pg='. intval($_REQUEST['page']);
			    $t->init();
			    $t->get_maked();
			    
			    if(empty($t->ctrl['theme']))
        		$title=$t->tpl['title_def'];
			    else
			      $title=$GLOBALS[CM]->run('sql:theme#t_name?t_url=\''. mysql_real_escape_string($t->ctrl['theme']) .'\'$shrink=yes');
			    $this->pg= str_replace('{title}',$title,$t->pg) ;
			    unset($t);

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
					
					$com_id=$GLOBALS[CM]->run('sql:comment$','insert',array(
					  'com_type'=>'pnt',
						'com_key_obj'=> intval($_REQUEST['point']),
						'com_key_u'=>$_SESSION['Jlib_auth']['u_id'],
						'com_date'=>date('Y-m-d H:i:s'),
						'com_text'=>$text,
						'com_short'=>$short
					));
					
					if(!empty($_REQUEST['recomend'])){
					  //l_id 	l_weight 	l_type 	l_key_obj 	l_key_u 	l_date
						$l_id=$GLOBALS[CM]->run('sql:likes$debug=yes','replace',array(
						  'l_type'=>'pnt',
							'l_key_obj'=> intval($_REQUEST['point']),
							'l_key_u'=>$_SESSION['Jlib_auth']['u_id'],
							'l_date'=>date('Y-m-d H:i:s'),
							'l_weight'=>( ($_REQUEST['recomend']>0)?1:-1 )
						));
					}
					
					if(!empty($com_id)){
					  $this->pg=$this->tpl['send_review_success'];
					}else{
					  $GLOBALS['result']['error']='Отзыв не добавлен';
					}
				  break;
				}
				case 'search_points':{
				  //echo '<pre class="debug">'.print_r ( $_REQUEST ,true).'</pre>';
					if(empty($_REQUEST['val'])){
						$GLOBALS['result']['error']='не передан запрос для поиска';
						return false;
					}
					if(empty($_REQUEST['query']['reg'])){
						$GLOBALS['result']['error']='не передан регион поиска';
						return false;
					}
					

					$GLOBALS['result']['val']=$_REQUEST['val'];
					$GLOBALS['result']['reg']=$_REQUEST['query']['reg'];

					$query=preg_replace('/[\-+\/\\_&^%$#*!`\'"]/',' ',$_REQUEST['val']);
					$query=explode(' ',$query);

					$inp=array();
					foreach($query as $v){
						if(!empty($v) && empty($inp[$v])) {
							$inp[$v]="sw_word LIKE '%".$v."%'";
						}
					}
					
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
								?p_key_reg=r_id AND p_id=sw_key_obj AND sw_obj_type=\'pnt\' AND '.$inp.' AND r_url=\''. $_REQUEST['query']['reg'] .'\'
								$order=words,p_name direction=asc group=p_id auto_query=no ';
					if(!$total=$GLOBALS[CM]->run($ucl,'count'))$total=0;
					$GLOBALS['result']['count']=($total>$lim)?$total-$lim:$total;

					$repl=array(
					  'count'=>$GLOBALS['result']['count'],
					  'total'=>$total,
					  'limit'=>$lim,
					  'val'=>$GLOBALS['result']['val']
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