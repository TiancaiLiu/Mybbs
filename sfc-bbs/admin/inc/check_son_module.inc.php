<?php
if(!is_numeric($_POST['father_module_id'])) {
	skip('3', 'son_module_add.php', 'error', '所属父板块不得为空！'); 
}
$query = "SELECT * FROM `sfc_father_module` WHERE id={$_POST['father_module_id']}";
$result = execute($link, $query);
if(mysqli_num_rows($result)==0) {
	skip('3', 'son_module_add.php', 'error', '所属父板块不存在！'); 
}
if(empty($_POST['module_name'])) {
		skip('3', 'son_module_add.php', 'error', '子板块名称不得为空！'); 
}
if(mb_strlen($_POST['module_name']) > 66){
	skip('3', 'son_module_add.php', 'error', '子板块名称不得大于66个字符！');
}
//这里调用escape方法目的是为了对输入的内容进行转义，因为内容中可能带有单引号或者双引号
$_POST = escape($link, $_POST);
//判断提交的数据是否重复，若重复则跳转 
switch ($check_flag) {
	case 'add':
		$query = "SELECT * FROM `sfc_son_module` WHERE module_name='{$_POST['module_name']}'";
		break;
	case 'update':
		$query = "SELECT * FROM `sfc_son_module` WHERE module_name='{$_POST['module_name']}' AND id!={$_GET['id']}";
		break;
	default:
		skip('3', 'son_module.php', 'error', '$check_flag参数错误！'); 			
}
$result = execute($link, $query);
if(mysqli_num_rows($result)) {
	skip('3', 'son_module_add.php', 'error', '这个子版块名称已经有了，请重新填写！'); 
}
if(mb_strlen($_POST['info']) > 225){
		skip('3', 'son_module_add.php', 'error', '子板块简介不得多于66个字符！');
}
if(!is_numeric($_POST['sort'])) {
		skip('3', 'son_module_add.php', 'error', '排序只能填写数字！'); 
}
?>