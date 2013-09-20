<?
function &init_db($dbi) {// dbi=array( 'dbn'=>''  'usr'=>''  'pwd'=>''  'srv'=>'') 
	static $db=array();
	if(empty($dbi)) return; // некуда соединяться
	// а это потому что разный синтаксис использован :(
	if(empty($dbi['srv'])&&!empty($dbi['server']))$dbi['srv']=$dbi['server'];
	if(empty($dbi['usr'])&&!empty($dbi['usn']))   $dbi['usr']=$dbi['usn'];
	if(empty($dbi['dbn'])&&!empty($dbi['db']))    $dbi['dbn']=$dbi['db'];
	if(empty($dbi['pconnect']))$dbi['pconnect']=false;
	$dbn=$dbi['dbn'];

	if (!empty($db[$dbn])) return $db[$dbn]; //уже есть

	if(empty($dbi['class'])) $dbi['class']='mysql_db';
	$db[$dbn]=new $dbi['class']();
	
	if(!$dbi['pconnect'])$db[$dbn]->connect($dbi['srv'],$dbi['dbn'],$dbi['usr'],$dbi['pwd']);
	else $db[$dbn]->pconnect($dbi['srv'],$dbi['dbn'],$dbi['usr'],$dbi['pwd']);
	
	if(!empty($GLOBALS['Jlib_defaults']['set_names'])){$db[$dbn]->query("SET NAMES '".$GLOBALS['Jlib_defaults']['set_names']."'");}
	if(!empty($dbi['set_names'])){$db[$dbn]->query("SET NAMES '".$dbi['set_names']."'");}
	return $db[$dbn];
}

/*****************************************************************************
*                           db access class (dbc)                            *
******************************************************************************/
class mysql_db {
var $dbc;
var $db;
var $rs=false;

	function connect ($hnm=DB_HOST,$dbn=DB_NAM,$usn=DB_USN,$pwd=DB_PWD,$die_on_err=true) {
		if (!($this->dbc=@mysql_connect($hnm,$usn,$pwd))) {
			if ($die_on_err) die ("Database server '$hnm' not exists or access denied for user '$usn'!");
			return !set_error_ex("sys:db_con", SYS_ERR, $hnm, $usn, mysql_error());
		} elseif (!mysql_select_db( $dbn,$this->dbc)) {
			if ($die_on_err) die ("Database '$dbn' not exists on server '$hnm'  or access denied for user '$usn'!");
			return !set_error_ex("sys:db_use", SYS_ERR, $dbn, mysql_error($this->dbc));
		}
		$this->db=$dbn;
		return $this->dbc;
	}

	function pconnect ($hnm=DB_HOST,$dbn=DB_NAM,$usn=DB_USN,$pwd=DB_PWD,$die_on_err=true) {
		if(!isset($_SESSION)) {
			connect ($hnm,$dbn,$usn,$pwd,$die_on_err);
			return $this->dbc;
		}
		if (!($this->dbc=@mysql_pconnect($hnm,$usn,$pwd))) {
			if ($die_on_err) die ("Database server '$hnm' not exists or access denied for user '$usn'!");
			return !set_error_ex("sys:db_con", SYS_ERR, $hnm, $usn, mysql_error());
		} elseif (!mysql_select_db( $dbn,$this->dbc)) {
			if ($die_on_err) die ("Database '$dbn' not exists on server '$hnm'  or access denied for user '$usn'!");
			return !set_error_ex("sys:db_use", SYS_ERR, $dbn, mysql_error($this->dbc));
		}
		$this->db=$dbn;
		return $this->dbc;
	}

	function query($sql,$silence=false) {
	$this->rs=false; //$GLOBALS['Jlib_db_queries']++;
	if (!($this->rs=@mysql_query($sql,$this->dbc))) {
		if (!$silence) echo "sys:db_sql", SYS_ERR, mysql_error(),$sql;
		return false;
		}
	return $this->rs;
	}

	function &get_meta() {
		$meta=false;
		if (!$this->rs) return $meta;
		$meta=array();
		for ($i=0;$i<mysql_num_fields($this->rs);$i++) {
			$vl=get_object_vars(mysql_fetch_field($this->rs));
			$meta[$vl['name']]=$vl;
		}
		return $meta;
	}

	function num_fields() {
		if ($rs) return mysql_num_fields($rs);
		if ($this->rs) return mysql_num_fields($this->$rs);
		return false;
	}


	function num_rows($rs=false) {
		if ($rs) return mysql_num_rows($rs);
		if ($this->rs) return mysql_num_rows($this->rs);
		return false;
	}

	function last_id() {
		return mysql_insert_id($this->dbc);
	}

	function affected() {
		return mysql_affected_rows($this->dbc);
	}

	function &fetch_array($rs=false){
		$arr=false;
		if (!$rs) if (!$this->rs) return $arr; else $rs=$this->rs;
		if(!$arr=mysql_fetch_array($rs,MYSQL_ASSOC)){
		  $arr=false;
		}
		return $arr;
	}

	function &query_row($sql,$silence=false) {
		$sql.=' LIMIT 0,1';
		$rs=$this->query($sql,$silence);
		$res=$this->fetch_array($rs);
		return $res;
	}


	function update_array($tbl,$arr,$exept='id', $where='id') {
		// не обновляет поля, начинающиеся с '~'
		if (empty($exept)) $exp[]='id'; else $exp=explode(',',$exept); $s=''; // exeption list
		foreach ($arr as $key=>$val)
			if ($key[0]!='~' && !in_array($key,$exp))
				$s.= "$key='$val',";
		$s=substr($s,0,strlen($s)-1);
		if ($where=='id') $where="id=$arr[id]";
		$sql="UPDATE $tbl SET $s WHERE $where" ;
		$arr=$this->query($sql);
		return $arr;
	}

	function insert_array($tbl,$arr,$exept='id') {
		// не вставляет поля, начинающиеся с '~'
		$exp=explode(',',$exept); $v=$s=''; // exeption list
		foreach ($arr as $key=>$val)
			if ($key[0]!='~' && !in_array($key,$exp)) {
				$s.= $key . ',';
				$v.= "'$val',";
			}
		$s=substr($s,0,strlen($s)-1);
		$v=substr($v,0,strlen($v)-1);
		$sql="INSERT INTO $tbl ($s) VALUES ($v)";
		return $this->query($sql);
	}

	function close () {
		if (mysql_close($this->dbc)) {
			return !$set_error_ex("db_sql", SYS_ERR, mysql_error($this->dbc));
		}
	return true;
	}
}
?>