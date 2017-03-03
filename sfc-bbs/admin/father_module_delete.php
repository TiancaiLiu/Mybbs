<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	skip('3', 'father_module.php' ,'error','id参数错误！请重试！');
}
//判断父板块下是否有子板块，避免直接删除
$link = connect();
$query = "SELECT * FROM sfc_son_module WHERE father_module_id={$_GET['id']}";
$result = execute($link, $query);
if(mysqli_num_rows($result)){
	skip('5', 'son_module.php' ,'error','这个父板块下有子版块，请将该父板块下的子版块删除后再进行该板块的删除！');
}
$link = connect();
$query = "DELETE FROM `sfc_father_module` WHERE id={$_GET['id']}";
execute($link, $query);
//判断是否有影响，mysqli_affected_rows返回值为1
if(mysqli_affected_rows($link) == 1){ 
	skip('2', 'father_module.php' ,'ok','恭喜你，删除成功！');
}else{
	skip('3', 'father_module.php' ,'error','对不起，删除失败！请重试');
}
?>