<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$template['title'] = '欢迎登录';
$template['description'] = '用户登录页面';
$template['keywords'] = '登录';
$template['css'] = array('style/public.css','style/register.css');

$link=connect();
if($member_id=is_login($link)) {
	skip(3, 'index.php', 'error', '您已经登录，请不要重复登录！'); 
}

$charset = "SET NAMES 'utf8';";
execute($link, $charset);

if (isset($_POST['submit'])) {
	include_once 'inc/check_login.inc.php';
	escape($link, $_POST);
	$query = "SELECT * FROM `sfc_member` WHERE name='{$_POST['name']}' AND pw=md5('{$_POST['pw']}')";
	$result = execute($link, $query);
	if(mysqli_num_rows($result)==1) {
		setcookie('sfc[name]', $_POST['name'], time()+$_POST['time']);
		setcookie('sfc[pw]', sha1(md5($_POST['pw'])),  time()+$_POST['time']);
		//更新登录时间
		$query = "UPDATE `sfc_member` set last_time=now()";
		execute($link, $query);
		skip(3, 'index.php', 'ok', '登录成功！'); 
	}else{
		skip(3, 'register.php', 'error', '用户名或者密码错误！');
	}
}
?>
<?php include_once 'inc/header.inc.php' ?>
	<div id="register" class="auto">
		<h2>欢迎您登录 - 私房菜</h2>
		<form method="post">
			<label>用户名：<input type="text" name="name" /><span></span></label>
			<label>密码：<input type="password"  name="pw" /><span></span></label>
			<label>验证码：<input name="vcode" type="text"  /><span><font color="red">*&nbsp;请输入下方验证码</font></span></label>
			<img class="vcode" src="show_code.php" alt="看不清楚，换一张" align="absmiddle" style="cursor: pointer;" onclick="javascript:newgdcode(this,this.src);" />
			<label>自动登录：
				<select style="width:236px;height:25px;" name="time">
					<option value="3600">1小时内</option>
					<option value="86400">1天内</option>
					<option value="259200">3天内</option>
					<option value="864000">10天内</option>
					<option value="2592000">30天内</option>
				</select>
				<span><font color="red">*&nbsp;公共电脑上请勿长期登录</font></span>
			</label>
			<div style="clear:both;"></div>
			<input class="btn" type="submit" name="submit" value="登录" />
		</form>
	</div>
<?php include_once 'inc/footer.inc.php' ?>