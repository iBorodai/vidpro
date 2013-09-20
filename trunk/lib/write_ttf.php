<?
require('lib/ssess.php');
ini_set('default_charset','cp1251');
//ini_set( 'session.cookie_domain' , '.'.str_replace('beta.','',str_replace('alpha.','',$_SERVER["HTTP_HOST"])) );
if (isset($_POST["PHPSESSID"])) { session_id($_POST["PHPSESSID"]);}
session_start();
//echo '<pre>',print_r( $_SESSION, true),'</pre>'; exit();

header('Content-type: image/png');

// Create the image
$im = imagecreatetruecolor(200, 60);

// Create some colors
$white = imagecolorallocate($im, 255, 255, 255);
$grey  = imagecolorallocate($im, 91, 90, 99);
$black = imagecolorallocate($im,20, 19, 23);

imagefilledrectangle($im, 0, 0, 399, 69, $grey);
//imagecolortransparent  ( $im ,$grey );
// The text to draw

//$a='ÀÅ¨ÈÎÓÛİŞß';
//$b='ÁÂÃÄÆÇÊËÌÍÏĞÑÒÔÕÖ×ØÙ';

$a='àåèîóûışÿ';
$b='öêíãøçõôâïğëäæ÷ñòáõ';

$text = '';
for($i=0;$i<3;$i++){
	$text.=substr($a, rand(0, strlen($a)-1 ) , 1);
	$text.=substr($b, rand(0, strlen($b)-1 ), 1);
}
//echo $text; exit();
$_SESSION['caphaText']=$text;
$font = '../fonts/font3.ttf';

// Add the text

if(empty($_GET['egg'])) for($i=0,$pos=10; $i<strlen($text);$i++){
	$s=rand(18,24);
	//$r=rand(0,10)-5;
	imagettftext($im, $s, 0, $pos, $s*2, $white, $font, $text[$i]);
//	imagefontwidth(int font)
	$pos+=$s+$s*.4;
}else{
	imagefilledrectangle($im, 0, 0, 399, 69, $black);
	imagettftext($im, 38, 0, 30, 40, $white, $font, 'Xy*');
}

$msk=imagecreatefrompng('../img/mask.png');
$tst=getimagesize('../img/mask.png');
imagecopy  ( $im  , $msk , 0 , 0  , 0  , 0  , $tst[0], $tst[1] );

// Using imagepng() results in clearer text compared with imagejpeg()
imagegif($im);
imagedestroy($im);
?>
