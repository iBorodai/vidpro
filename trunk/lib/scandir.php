<?
function scandir( $dn ){	// служебная для функции editmsgs() - поиск файлов с данным расширением, рекурсивная, отфильтровывает 'svn/'
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
				$ra=array_merge($ra,scandir($fullname.'/'));
			}elseif(is_file( $fullname )){
				$ft=substr( $fn, strrpos($fn,'.')+1 );
				if(in_array( $ft, $ea	 )) $ra[ $fullname ]=array();
			}
		}
		closedir($dh);
	}
	return $ra;
}

?>
