<?php
/**
 *	@name vcode 生成验证码
 *	@author 刘敬雄	2016-12-2
 *	@abstract $width $height $fontSize $countElement $countPixe $countLine
 *	@$width  		验证码的宽度
 *	@$height  		验证码的高度
 *	@$fontSize 	 	字体大小
 *	@$countElement	字符个数
 *	@$countPixel  	点的个数
 *	@$countLine		线的个数
 *	@return  $string
 */
function vcode($width=120,$height=40,$fontSize=30,$countElement=5,$countPixel=100,$countLine=4){
	header('Content-type:image/jpeg');
	$element=array('a','b','c','d','e','f','g','h','i','j','k','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
	$string='';
	for ($i=0;$i<$countElement;$i++){
		$string.=$element[rand(0,count($element)-1)];
	}
	$img=imagecreatetruecolor($width, $height);
	$colorBg=imagecolorallocate($img,rand(200,255),rand(200,255),rand(200,255));
	$colorBorder=imagecolorallocate($img,rand(200,255),rand(200,255),rand(200,255));
	$colorString=imagecolorallocate($img,rand(10,100),rand(10,100),rand(10,100));
	imagefill($img,0,0,$colorBg);
	for($i=0;$i<$countPixel;$i++){
		imagesetpixel($img,rand(0,$width-1),rand(0,$height-1),imagecolorallocate($img,rand(100,200),rand(100,200),rand(100,200)));
	}
	for($i=0;$i<$countLine;$i++){
		imageline($img,rand(0,$width/2),rand(0,$height),rand($width/2,$width),rand(0,$height),imagecolorallocate($img,rand(100,200),rand(100,200),rand(100,200)));
	}
	//imagestring($img,5,0,0,'abcd',$colorString);
	imagettftext($img,$fontSize,rand(-5,5),rand(5,15),rand(30,35),$colorString,'font/ManyGifts.ttf',$string);
	imagejpeg($img);
	imagedestroy($img);
	return $string;
}
?>