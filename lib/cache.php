<?
//Класс поставщик для работы с кешем
class cache {
	var $db=false;
	var $temp=false;
	var $last_id=false;
	function cache(){
	}

	function get($id){
	  $this->db=init_db();
	  $s="SELECT fq_content FROM z_fs_queries WHERE fq_id='$id' AND fq_dead>".mktime();
	  $t=$this->db->query_row($s);
	  $this->last_id=$id;
	  if(empty($t)) return false;
	  return $t['fq_content'];
	}
	
	function prepare($id,$data=false,$period_sec=false){
	  //Если задана очистка подготовленного сохранения
	  if( $id=='clear' ){	$this->temp=false; return true; }
	  //Если не передано что готовить
	  if( !$data)return false;

	  $t=mktime();
	  if(!$period_sec) $period_sec=86400; //+20дней=86400

	  if( !is_string($data) ) $serr=serialize($data);
	  else $serr=$data;
	  $serr=mysql_real_escape_string($serr);
	  /*
	  if(1==3 && unserialize($serr) != $data ){
			$this->temp=false;
			return false;
		}
		*/
		
	  $this->temp="REPLACE INTO z_fs_queries SET fq_id='$id', fq_content='$serr', fq_create=". $t .", fq_dead=".($t+$period_sec);

	  $this->last_id=$id;
	  return true;
	}
	
	function set($id=false,$data=false,$period_sec=false){
//echo "CACHE SET ".$this->temp;
	  //Если что сохранять не передано и сохранение не подготовлено заранее - ошибка
	  if(!$id && !$data && !$this->temp) return false;
		
	  $this->db=init_db();
	  //Если передано что сохранять
		if($id && $data)	$this->prepare($id,$data,$period_sec);
		//echo $this->temp;
	  $this->db->query($this->temp);
	  if(mysql_errno()){
			return false;
		}
	  $this->last_id=$id;
	  return true;
	}
	
	function remove($id){
	  $this->db=init_db();
	  $this->db->query( "DELETE FROM z_fs_queries WHERE fq_id='$id'" );
	}//fae9c5800a68db0c2abb920dc6a9219c
}
?>