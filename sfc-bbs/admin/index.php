<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
//验证管理员是否登录
include_once 'inc/is_manage_login.inc.php';
var_dump($_SESSION);


?>