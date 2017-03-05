<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
if(!is_manage_login($link)) {
	header('Location:login.php');
}
session_unset();
session_destroy();
setcookie(session_name(), '', time()-3600, '/');
skip('3', 'login.php', 'ok', '注销成功！');
 ?>