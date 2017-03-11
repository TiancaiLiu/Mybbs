<?php 
echo PHP_VERSION;
if(version_compare(PHP_VERSION, '5.3.10') < 0) {
	exit('您的PHP版本为' . PHP_VERSION . '！我们的程序要求PHP版本不低于5.3.10');
}

 ?>