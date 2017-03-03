<?php
header("Content-type:text/html;charset=utf-8");
function page(&$a) {
	$a = '你好！';
}
$i = '刘敬雄';
page($i);
echo $i;
?>