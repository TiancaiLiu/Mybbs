<?php
if(empty($_POST['name'])) {
	skip('3', 'register.php', 'error', '用户名不得为空！'); 
}
if(mb_strlen($_POST['name']) > 32){
	skip('3', 'register.php', 'error', '用户名不得多于32个字符！');
}
if(mb_strlen($_POST['pw'])<6) {
	skip('3', 'register.php', 'error', '密码不得少于6位！'); 
}
if($_POST['pw']!=$_POST['confirm_pw']) {
	skip('3', 'register.php', 'error', '两次输入密码不一致'); 
}
if(strtolower($_POST['vcode']) != strtolower($_SESSION['vcode'])) {
	skip(5, 'register.php', 'error', '验证码输入错误！'); 
}
$_POST = escape($link, $_POST);
$query = "SELECT * FROM `sfc_member` WHERE name='{$_POST['name']}'";
$result = execute($link, $query);
if(mysqli_num_rows($result)) {
	skip('3', 'register.php', 'error', '该用户名已被注册！'); 
}
?>