<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$link=connect();
$member_id=is_login($link);

if(!$member_id) {
	skip(3,'index.php','error','您没有登录，不需要退出！');
}
setcookie('sfc[name]', '', time()-3600);
setcookie('sfc[pw]', '',  time()-3600);
skip(3,'index.php','ok','退出成功！');

?>
