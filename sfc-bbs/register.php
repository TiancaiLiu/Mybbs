<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$template['title'] = '会员注册页';
$template['description'] = '用户注册页面';
$template['keywords'] = '注册';
$template['css'] = array('style/public.css','style/register.css');

$link = connect();
$charset = "SET NAMES 'utf8';";
execute($link, $charset);
if($member_id = is_login($link)) {
	skip(3, 'index.php', 'error', '您已经登录，请不要重复注册！'); 
}

if (isset($_POST['submit'])) {
	include_once 'inc/check_register.inc.php';
	$query = "INSERT INTO `sfc_member`(name, pw, register_time) VALUES ('{$_POST['name']}', md5('{$_POST['pw']}'), now())";
	execute($link, $query);
	if (mysqli_affected_rows($link)==1) {
		setcookie('sfc[name]', $_POST['name']);
		setcookie('sfc[pw]', sha1(md5($_POST['pw'])));
		skip(2, 'register.php', 'ok', '注册成功！'); 
	}else{
		skip(3, 'register.php', 'error', '注册失败，请重试！'); 
	}
}
 ?>
<?php include_once 'inc/header.inc.php' ?>
	<div id="register" class="auto">
		<h2>欢迎注册成为 私房菜会员</h2>
		<form method="post">
			<label>用户名：<input type="text"  name="name" /><span><font color="red">*&nbsp;用户名不得为空，并且长度不得超过32个字符</font></span></label>
			<label>密码：<input type="password"  name="pw" /><span><font color="red">*&nbsp;密码不得少于6位</font></span></label>
			<label>确认密码：<input type="password"  name="confirm_pw" /><span><font color="red">*&nbsp;请保持与上面的输入一致</font></span></label>
			<label>验证码：<input name="vcode" type="text"  name="vocode" /><span><font color="red">*&nbsp;请输入下方验证码</font></span></label>
			<img class="vcode" src="show_code.php" alt="看不清楚，换一张" align="absmiddle" style="cursor: pointer;" onclick="javascript:newgdcode(this,this.src);" />
			<div style="clear:both;"></div>
			<input class="btn" type="submit" name="submit" value="确定注册" />
		</form>
	</div>
<?php include_once 'inc/footer.inc.php' ?>