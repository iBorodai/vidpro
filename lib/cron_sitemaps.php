<?
require('mysql_db.php');
require('config.php');
if(!mysql_connect($db_prm['server'],$db_prm['usn'],$db_prm['pwd'])) die('connection_error');
if(!mysql_select_db( $db_prm['db'] )  ) die('select_db_error');


/*************************************
 *  Файл товаров sitemap_goods.xml
 ************************************/
$sql="SELECT
        g_id,g_syncdate,g_pricedate,c1.c_id cat
			FROM
				goods,goods2cat,catigories c1, catigories c2
			WHERE
				g_pub=1 AND g_del=0 AND g_1c!='' AND g_price>1 AND (g_amount>g_sill OR g_custom=1) AND
				g2c_key_g=g_id AND g2c_key_cat=c1.c_id AND
				c1.c_pid=c2.c_id AND c2.c_pid!=0";
$res=mysql_query($sql);
$items='';
$max_date='0000-00-00';
$catigories=array();

while($row=mysql_fetch_assoc($res)){
	$p=(!empty($row['g_action']) || !empty($row['g_hot']))? 0.9 : 0.8 ;
	$d=( $row['g_pricedate']>$row['g_syncdate'] )? $row['g_pricedate'] : $row['g_syncdate'];
	
	if( $d>$max_date ) $max_date=$d;
	if( empty($catigories[$row['cat']]) || $catigories[$row['cat']]<$d ) $catigories[$row['cat']]=$d;
	
	$items.="\n".'<url><loc>http://technicity.com.ua/goods/view/'.$row['g_id'].'</loc><priority>'.$p.'</priority><lastmod>'.$d.'T07:00:12+02:00</lastmod></url>';
}
mysql_free_result($res);
//создаю файл категорий
$fh=fopen('../sitemap_goods.xml', 'w');
fwrite($fh, '<'.'?xml version="1.0" encoding="UTF-8"?'.'><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$items.'</urlset>');
fclose($fh);

/*************************************
 *  Категории sitemap_catigories.xml
 ************************************/
//Категории
$sql="SELECT
				p.c_pid c1, p.c_id c2, c.c_id c3,
				IF(msg IS NULL, c.c_url, msg) name
			FROM
				catigories c LEFT JOIN
				sys_msg ON(msg_id=c.c_url) LEFT JOIN
				catigories p ON(p.c_id=c.c_pid)
			WHERE
				c.c_typ='cls'
			ORDER BY p.c_pid, c.c_pid, msg";
$items='';
$res=mysql_query($sql);
while( $row=mysql_fetch_assoc($res) ){
	$lnk=''; $w=0;
	for($i=1; $i<4; $i++)
	if( !empty($row['c'.$i]) ){
		$lnk.=$row['c'.$i].'/';
		$w+=0.2;
	}
	$d=(!empty( $catigories[$row['c3']] ))? $catigories[$row['c3']] :$max_date;
	$items.="\n".'<url><loc>http://technicity.com.ua/goods/'.$lnk.'</loc><priority>'.$w.'</priority><lastmod>'.$d.'T07:00:12+02:00</lastmod></url>';
}
mysql_free_result($res);

//создаю файл категорий
$fh=fopen('../sitemap_catigories.xml', 'w');
fwrite($fh, '<'.'?xml version="1.0" encoding="UTF-8"?'.'><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$items.'</urlset>');
fclose($fh);

/*************************************
 *  Бренды sitemap_brands.xml
 ************************************/
//Категории
$sql="SELECT
				b_url, c3.c_id lnk
			FROM
				goods, brands, goods2cat, catigories c2, catigories c3
			WHERE
				g_key_b = b_id AND
				c3.c_id = g2c_key_cat AND
				c3.c_typ = 'cls' AND
				g2c_key_g = g_id AND
				c2.c_id = c3.c_pid AND
				c2.c_pid !=0
			GROUP BY b_url,c3.c_id";
$items='';
$res=mysql_query($sql);
while( $row=mysql_fetch_assoc($res) ){
	$d=(!empty( $catigories[$row['lnk']] ))? $catigories[$row['lnk']] :$max_date;
	$items.="\n".'<url><loc>http://technicity.com.ua/goods/'.$lnk.'</loc><lastmod>'.$d.'T07:00:12+02:00</lastmod></url>';
}
mysql_free_result($res);

//создаю файл категорий
$fh=fopen('../sitemap_brands.xml', 'w');
fwrite($fh, '<'.'?xml version="1.0" encoding="UTF-8"?'.'><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$items.'</urlset>');
fclose($fh);


/*************************************
 *  Пересоздаю sitemap.xml
 ************************************/

$xml='<'.'?xml version="1.0" encoding="UTF-8"?'.'>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<sitemap>
		<loc>http://technicity.com.ua/sitemap_base.xml</loc>
		<lastmod>'.$max_date.'T20:00:17+02:00</lastmod>
	</sitemap>
	<sitemap>
		<loc>http://technicity.com.ua/sitemap_goods.xml</loc>
		<lastmod>'.$max_date.'T20:00:17+02:00</lastmod>
	</sitemap>
	<sitemap>
		<loc>http://technicity.com.ua/sitemap_brands.xml</loc>
		<lastmod>'.$max_date.'T20:00:17+02:00</lastmod>
	</sitemap>
	<sitemap>
		<loc>http://technicity.com.ua/sitemap_catigories.xml</loc>
		<lastmod>'.$max_date.'T20:00:17+02:00</lastmod>
	</sitemap>
</sitemapindex>';

$fh=fopen('../sitemap.xml', 'w');
fwrite($fh, $xml);
fclose($fh);

 
?>
