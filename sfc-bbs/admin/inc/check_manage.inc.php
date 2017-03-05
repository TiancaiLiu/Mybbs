<?php
if(empty($_POST['name'])) {
		skip('3', 'manage_add.php', 'error', '管理员名称不得为空！'); 
}
if(mb_strlen($_POST['name']) > 32){
	skip('3', 'manage_add.php', 'error', '管理员名称名称不得大于32个字符！');
}
if(mb_strlen($_POST['pw']) < 6){
	skip('3', 'manage_add.php', 'error', '管理员名称密码不得小于6位！');
}
//这里调用escape方法目的是为了对输入的内容进行转义，因为内容中可能带有单引号或者双引号
$_POST = escape($link, $_POST);
//判断提交的数据是否重复，若重复则跳转 
$query = "SELECT * from `sfc_manage` where name='{$_POST['name']}'";
$result = execute($link, $query);
if(mysqli_num_rows($result)) {
	skip('3', 'manage_add.php', 'error', '该名称已被使用，请重新填写！'); 
}
// if(!isset($_POST['level'])) {
// 	$_POST['level'] = 1;
// }elseif($_POST['level'] == '0'){
// 	$_POST['level'] = 0;
// }elseif($_POST['level'] == '1'){
// 	$_POST['level'] = 1;
// }else{
// 	$_POST['level'] = 1;
// }
if(!isset($_POST['level'])) {
	switch ($_POST['level']) {
		case '0':
			$_POST['level'] = 0;
			break;
		case '1':
			$_POST['level'] = 1;
			break;
		default:
			$_POST['level'] = 1;
			break;
	}
}
?>