<?php
if (empty($_POST['name'])) {
	skip(3, 'login.php', 'error', '用户名不得为空！'); 
}
if (empty($_POST['name'])) {
	skip(3, 'login.php', 'error', '密码不得为空！'); 
}
if(mb_strlen($_POST['name']) > 32){
	skip(3, 'login.php', 'error', '用户名长度不要多于32个字符！');
}
if(strtolower($_POST['vcode']) != strtolower($_SESSION['vcode'])) {
	skip(3, 'login.php', 'error', '验证码输入错误！'); 
}
if(empty($_POST['time']) || !is_numeric($_POST['time']) || $_POST['time']>2592000){
	$_POST['time'] = 2592000;
}

?>