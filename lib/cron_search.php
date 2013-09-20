<?php

echo "<h1>Изменение индекса поиска...</h1>\n\n\n";
require('db_conf.php');

$log=array();

$db=mysql_connect( $db_prm['server'], $db_prm['usn'], $db_prm['pwd'] ); if(!$db) die($db_prm['server'].' - БД не коннектится! :(');
mysql_select_db($db_prm['db'],$db); $sql="SET NAMES 'cp1251'"; mysql_query($sql);

$sql='DELETE FROM search_index WHERE si_key_o=(SELECT o_id FROM object WHERE o_id=si_key_o AND (o_update>si_update OR o_pub=0))';
$res=mysql_query($sql);
$aff=mysql_affected_rows();
echo "\n<br />Удалено устаревших записей: ",$aff,"\n<br>\n";
$log[]=$aff.' удалено';
 

$sql="INSERT INTO search_index(
				SELECT
					o_id,
					object_content.ln,
					CONCAT( oc_title, oc_lead) ,
					CONCAT_WS(' ',
						oc_title, oc_lead, oc_text
					),
					NOW()
				FROM
					object,object_content
				WHERE
					oc_key_o=o_id AND oc_title!='' AND o_id NOT IN(SELECT si_key_o FROM search_index)
)
";

$res=mysql_query($sql);
$aff=mysql_affected_rows();
echo 'Добавлено новых и обновленных записей: ',$aff,"\n<br>\n";
$log[]=$aff.' индексов';


//Сохраняю записи в лог
$sql="INSERT INTO `cron_log` ( `cl_name`,`cl_val` ) VALUES ('search','". implode("'),('search','", $log)."')";
mysql_query($sql);
?>