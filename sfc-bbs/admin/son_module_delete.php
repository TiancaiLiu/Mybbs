<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	skip('3', 'son_module.php' ,'error','id参数错误！请重试！');
}
$link = connect();
$query = "DELETE FROM `sfc_son_module` WHERE id={$_GET['id']}";
execute($link, $query);
//判断是否有影响，mysqli_affected_rows返回值为1
if(mysqli_affected_rows($link) == 1){ 
	skip('2', 'son_module.php' ,'ok','恭喜你，删除成功！');
}else{
	skip('3', 'son_module.php' ,'error','对不起，删除失败！请重试');
}
?>