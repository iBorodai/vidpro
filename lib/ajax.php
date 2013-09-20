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
			    $t->init();
			    $t->get_maked();
			    $this->pg=$t->pg;
			    unset($t);

			    break;
				}
				case 'search':{
					if(empty($_REQUEST['query']) || !is_string($_REQUEST['query'])) {
						$GLOBALS['result']['error']='не передан запрос для поиска';
						exit;
					}
					$GLOBALS['result']['query']=$_REQUEST['query'];
					$_REQUEST['query']=preg_replace('/[\-+\/\\_&^%$#*!`\'"]/',' ',$_REQUEST['query']);
					$_REQUEST['query']=explode(' ',$_REQUEST['query']);
					$inp=array();
					foreach($_REQUEST['query'] as $v){
						if(!empty($v) && empty($inp[$v])) {
							$inp[$v]="sw_word = '".$v."'";
						}
					}
					if(empty($inp)){
						$GLOBALS['result']['error']='Слова не разобраны';
						exit;
					}
					$inp=implode(' AND ',$inp);
					
					$lim=(empty($_REQUEST['limit']) || !is_numeric($_REQUEST['limit']))?5:$_REQUEST['limit'];
					
					$ucl='sql:search_words_index, point
								#p_id,p_url,p_fsid,p_name,p_img,p_dscr,p_key_reg,p_addr,p_lat,p_lng,p_createdate,
								 count( p_id ) words
								?p_id=sw_key_obj AND sw_obj_type=\'pnt\' AND '.$inp.'
								$order=words,p_name direction=asc group=p_id auto_query=no';

					$total=$GLOBALS[CM]->run($ucl,'count');
					$GLOBALS['result']['count']=$total-$lim;

					$repl=array(
					  'count'=>$total-$lim,
					  'total'=>$total,
					  'limit'=>$lim,
					);

					if($GLOBALS['result']['count']+$lim>0){
						$q=$GLOBALS[CM]->run($ucl.' limit=0,'.$lim);
						$lines=array();
						foreach($q as $v){
							if( $_REQUEST['mode']== 'search'){
								$v['url']=$this->get_url( 'Jlib_target=point/'.$v['p_url'] );
								$lines[]=strjtr( $this->tpl['search_line'], $v );
							}
						}
						$repl['body']=implode('',$lines);
						unset($lines);
						
						$this->pg=strjtr( $this->tpl['goods_search'], $repl);

					}else
						$this->pg=$this->tpl['search_noresults'];
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