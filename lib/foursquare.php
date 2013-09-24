<?
class foursquare{
	//Ключ и параметры по умолчанию для запросов без пользовательской авторизации
	var $api_key='client_id=ZM3ON3ZHY3TWMU4XYSCVDWYCYGMZVZQ23IBL5BSBN0J10VWS&client_secret=CJHGV2KMFICEJ5DMCLWIQG5UZ51ZFC0QH1KZ4L1EMQ1KTT1J&v=20130901&locale=ru';
	var $api_top_cats='4d4b7105d754a06374d81259,4d4b7105d754a06376d81259';
	//Хранилище ошибок выполнения
	var $errors=array();
	
	/**************************
	 *	Произвольный запрос к API
	***************************/
	function request($fs_query, $cache_time=false){
		if( $tst=$GLOBALS[CACHE]->get(md5($fs_query)) ){
	     $dt= unserialize($tst);
		}else{
		  //Запрашиваю
		  $json=get_page('api.foursquare.com', $fs_query );
		  if(empty($json)){
		    $this->errors[]=array('err','пустой ответ');
		    return false;
			}
		  $dt=json_decode($json);
			//кеширую
		  if( !$GLOBALS[CACHE]->prepare( md5($fs_query), $dt, $cache_time ) ){
		    $this->errors[]=array('wrn','ошибка кеширования - не удалось сохранить данные');
			}
		}
		return $dt;
	}
	
	/**************************
	 *	Получение данных о заведении по fs_ID
	 *  https://api.foursquare.com/v2/venues/513262d5e4b0e80cdba8eb71?client_id=ZM3ON3ZHY3TWMU4XYSCVDWYCYGMZVZQ23IBL5BSBN0J10VWS&client_secret=CJHGV2KMFICEJ5DMCLWIQG5UZ51ZFC0QH1KZ4L1EMQ1KTT1J&v=20130901
	***************************/
	function venue($fsid){
	  //validation request
	  if( empty($fsid) ){
	    $this->errors[]=array('err','в запросе не передан идентификатор заведения');
			return false;
		}

    //make request
	  $fs_query='/v2/venues/'.$fsid.'?'.$this->api_key;
		$dt=$this->request($fs_query);
		
		//validation response
	  if( empty($dt->response->venue) ){
	    $this->errors[]=array('err','в ответе не обнаружено заведение');
	    $GLOBALS[CACHE]->prepare('clear');
	    $GLOBALS[CACHE]->remove($fsid);
	    return false;
		}
		//CGCHE
		$GLOBALS[CACHE]->set();
		return $dt;
	}
	
	/**************************
	 *	поиск заведений
	 *  https://api.foursquare.com/v2/venues/search?near=kiev&intent=browse&query=%D0%BF%D0%BE%D1%80%D1%82%D0%B5%D1%80&client_id=ZM3ON3ZHY3TWMU4XYSCVDWYCYGMZVZQ23IBL5BSBN0J10VWS&client_secret=CJHGV2KMFICEJ5DMCLWIQG5UZ51ZFC0QH1KZ4L1EMQ1KTT1J&v=20130901
	***************************/
	function search($req){
	  //validation request
	  if( empty($req['query']) ){
	    $this->errors[]=array('err','в запросе не передана строка поиска');
			return false;
		}

		if( preg_match('~[а-яА-Я]~', $req['query']) )		{$req['query']=urlencode($req['query']);}
		if( preg_match('~[а-яА-Я]~', $req['location']) ){$req['query']=urlencode($req['location']);}
	  //make requert
	  $fs_query='/v2/venues/search/?near='.$req['location'].'&intent=browse&query='. $req['query'] .'&limit=50&categoryId='.$this->api_top_cats.'&'.$this->api_key;
//echo '<br />'.$fs_query;
	  $dt=$this->request($fs_query, 86400); //Передаю кешировать на сутки в секундах
		//Validate response
	  if( empty($dt->response->venues) ){
	    $this->errors[]=array('err','в ответе не обнаружено заведений');
	    $GLOBALS[CACHE]->prepare('clear');
	    return false;
		}
		$GLOBALS[CACHE]->set();
	  return $dt;

	}
}

function &init_fs(){
  static $fs=false;
  if (!empty($fs)) return $fs; //уже есть
  $fs=new foursquare();
  return $fs;
}
?>
