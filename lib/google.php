<?php
function &init_ga(){
  static $ga=false;
  if (!empty($ga)) return $ga; //уже есть
  $ga=new google_addr();
  return $ga;
}


class google_addr{
	var $key='AIzaSyAH7PC7sxCeHfuq_D6J234qQxZjse7I9jo';

	/**************************
	 *	Произвольный запрос к API
	***************************/
	function request($query, $cache_time=false){
    $query_id=substr(md5($query), 0, 32);
//echo '<br />'.$query_id.'<br />';
		if( $tst=$GLOBALS[CACHE]->get($query_id) ){
	     $dt= unserialize($tst);
//echo '<pre class="debug">'.print_r ( $dt ,true).'</pre>';
		}
		if(empty($dt)){
		  //Запрашиваю
			//echo 'https://maps.googleapis.com'.$query;
//echo 'https://maps.googleapis.com'.$query.'<br />';
		  $json=file_get_contents('https://maps.googleapis.com'.$query);
		  //$json=get_page('maps.googleapis.com', $query,'https' );
//echo $json;

		  if(empty($json)){
		    $this->errors[]=array('err','пустой ответ');
		    return false;
			}
		  $dt=json_decode($json);
		  
		  $this->cur_json=$json;
			//кеширую
		  if( !$GLOBALS[CACHE]->prepare( $query_id, $dt, $cache_time ) ){
		    $this->errors[]=array('wrn','ошибка кеширования - не удалось сохранить данные');
			}
//echo '<br />'.$GLOBALS[CACHE]->temp;
		}
		return $dt;
	}


	//https://maps.googleapis.com/maps/api/place/search/json?location=50.381515041500000,30.481621027000000&radius=500&types=food&name=Прага&sensor=false&key=AIzaSyAH7PC7sxCeHfuq_D6J234qQxZjse7I9jo
	function find($req){
	  if(empty($req['query']) || empty($req['lat']) ||  empty($req['lng']) ){
	    $this->errors[]=array('err','Не переданы параметры поиска в Google адресах');
			return false;
		}

		if(strpos($req['query'], '/')!==false){
		  $req['query']=substr($req['query'], 0, strpos($req['query'], '/'));
		}
		$req['query']=trim($req['query']);
		$req['query']=urlencode($req['query']);
		
	  //make seach requert
	  $query='/maps/api/place/search/json?location='.$req['lat'].','.$req['lng'].'&radius=500&types=food&name='.$req['query'].'&sensor=false&key='.$this->key;
	  $dt=$this->request($query, 0); //Передаю кешировать на сутки в секундах
	  
		//Validate response
	  if( empty($dt->results) ){
	    $this->errors[]=array('err','в ответе не обнаружено заведений');
     	$GLOBALS[CACHE]->prepare('clear');
	    return false;
		}
		$GLOBALS[CACHE]->set();
		//Запоминаю, чтобы сделать сквозное кеширование
		//$cache_temp=$GLOBALS[CACHE]->temp;
		$ref_id=$dt->results[0]->reference;

		//make item requert
		//https://maps.googleapis.com/maps/api/place/details/json?reference=CoQBfwAAACHkEH2vtbH5dIHeG5q5wnhzWCwQXcOIlzQS1gwV0Cy95GGvO7mbfExGdz9Eqlzsi8N7jfi4lZOjJGno6-2_ELTVcieexrNmpJheII4c0R7O3Fo7nms81ueA346iLsdZ0sMACA5bSxMR8y_-mweXQRRCbLUZ7f_PV6f6caiSszwDEhAlkSQBdahl0tmKxaqGc_VbGhT6-z6DaraT-paCJWIFMxbukLo12A&sensor=true&key=AIzaSyAH7PC7sxCeHfuq_D6J234qQxZjse7I9jo
//echo '<br />'.$ref_id.'<br />';
		$query='/maps/api/place/details/json?reference='.$ref_id.'&sensor=false&key='.$this->key;
	  $item=$this->request($query, 86400); //Передаю кешировать на сутки в секундах
	  
//echo '<pre class="debug">'.print_r ( $item->result->reviews ,true).'</pre>';
		if(empty( $item->result->reviews )){
	    $this->errors[]=array('err','в ответе не обнаружено заведений');
	    $GLOBALS[CACHE]->prepare('clear');
	    return false;
		}

		//Подставляю данные второго запроса в первую компиляцию кеша
		//$serr=mysql_real_escape_string(serialize($item));
//echo $cache_temp.' <br /><br />'.substr($cache_temp, strpos($cache_temp, "', fq_create=")); exit();
		//$GLOBALS[CACHE]->temp=substr($cache_temp, 0,  strpos($cache_temp, "fq_content='")+12 ). $serr . substr($cache_temp, strpos($cache_temp, "', fq_create=") );
//echo '<br />'.$GLOBALS[CACHE]->temp;
		$GLOBALS[CACHE]->set();
		
		
		for($i=0, $cnt=count($item->result->reviews); $i<$cnt; $i++){
		  if(empty( $item->result->reviews[$i]->author_url )){
		    $item->result->reviews[$i]->author_photo='/img/def_usr.jpg';
		    continue;
			}
			
		  $ph_tst='https://www.googleapis.com/plus/v1/people/'.
							substr($item->result->reviews[$i]->author_url, strrpos($item->result->reviews[$i]->author_url, '/')+1 ) .
							'?fields=image&key='.$this->key;
	    $query_id=substr(md5($ph_tst), 0, 32);
			if( $json=$GLOBALS[CACHE]->get($query_id) ){
		     //echo '<pre class="debug">'.print_r ( $json ,true).'</pre>';exit();
			}else{
			  $json=false;
			  try{
			    $json=file_get_contents($ph_tst);
			    $GLOBALS[CACHE]->set($query_id,$json,2592000); //30 дней в секундах
				}catch(Exception $e){
				}
			}
		  if($json)	$dt=json_decode($json);

		  if(!empty($dt) && !empty($dt->image))$item->result->reviews[$i]->author_photo=$dt->image->url;
			else  $photo='/img/def_usr.jpg';
		}
		//echo '<pre class="debug">'.print_r ( $item ,true).'</pre>';exit();
	  return $item;
	}
}

function parse_google_data($data){
  if(empty($data->result->reviews) || !is_array($data->result->reviews)){
    return array();
	}
	$data=$data->result->reviews;
	//echo '<pre class="debug">'.print_r ( $data ,true).'</pre>'; exit();
	$ret=array('comms'=>array());
	for($i=0,$cnt=count($data);$i<$cnt;$i++){
		/*
		$ph_tst='http://profiles.google.com/s2/u/0/photos/profile/' . substr($data[$i]->author_url, strrpos($data[$i]->author_url, '/')+1 ) . '?sz=120';
	  $headers = get_headers($ph_tst, 1);
		if(!empty( $headers['Location'] ))	$photo=$headers['Location'];
		else $photo='/img/def_usr.jpg';
		*/

	  $ret['comms'][date('YmdHis',$data[$i]->time)]=array(
	    'vendor'=>'google',
	    'text'=>$data[$i]->text,
      'create' => date('d.m.Y H:i:s',$data[$i]->time),
      'user_name' => $data[$i]->author_name,
      'user_photo' => $data[$i]->author_photo,
      'user_url'=>$data[$i]->author_url,
      'time' => $data[$i]->time
		);
	}
	//http://profiles.google.com/s2/u/0/photos/profile/106754536592514321880
	return $ret;
}
?>