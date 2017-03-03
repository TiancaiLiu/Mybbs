<?php
if(empty($_POST['module_id']) || !is_numeric($_POST['module_id'])){
	skip('publish.php', 'error', '所属版块id不合法！');
}
$query="SELECT * from `sfc_son_module` WHERE id={$_POST['module_id']}";
$result=execute($link, $query);
if(mysqli_num_rows($result)!=1){
	skip( '3','publish.php', 'error', '请选择一个板块！');
}
if(empty($_POST['title'])){
	skip('3','publish.php', 'error', '标题不得为空！');
}
if(mb_strlen($_POST['title'])>255){
	skip('3','publish.php', 'error', '标题不得超过255个字符！');
}
?>