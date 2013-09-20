<?
if(!isset($GLOBALS['Jlib_page'])){
	include('JsHttpRequest.php');
	$JsHttpRequest = new JsHttpRequest("windows-1251");
	if( empty($_REQUEST['uip']) ){
	  $_REQUEST['uip']=!empty($_SERVER['HTTP_CLIENT_IP']) ?
	          $_SERVER['HTTP_CLIENT_IP'] : (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) ?
	                  $_SERVER['HTTP_X_FORWARDED_FOR'] : (!empty($_SERVER['REMOTE_ADDR']) ?
	                          $_SERVER['REMOTE_ADDR'] : null));
	}
	$uip=$_REQUEST['uip'];
}else{
  $uip=show_ip();
}
	
  $source_domain='freegeoip.net';
  $link='/xml/'.$_REQUEST['uip'];
  $fp = fsockopen($source_domain, 80, $errno, $errstr, 30);
		if (!$fp) {
		    echo "$errstr ($errno)<br />\n";
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
	        	if( strpos($dn, '404')!==false ){ fclose($fp); return ''; }
		        if($dn=="\r\n") $start=true;
						continue;
					}
	        $content.=$dn;
	        $i++; $sqlcnt--;
	    }
	    fclose($fp);
		}
		//return $content;
//echo $content;
  $rega='~<Latitude>([^<]+)</Latitude>\s+<Longitude>([^<]+)</Longitude>~';
  preg_match_all($rega, $content, $m);
	//echo '<pre class="debug">'.print_r ( $m ,true).'</pre>'.$content;
	if( !empty($m) && !empty($m[1][0]) && !empty($m[1][0])){
		if(!isset($GLOBALS['Jlib_page'])){
			  $_RESULT['latitude']	=$m[1][0];
			  $_RESULT['longitude']	=$m[2][0];
		}else{
			//Работаем в либе
			$latitude	=$m[1][0];
			$longitude=$m[2][0];
		}
	}else{$_RESULT['error']	='ничего не найдено';}
?>
