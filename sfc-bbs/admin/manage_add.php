<?php
	include_once '../inc/config.inc.php';
	include_once '../inc/mysql.inc.php';
	include_once '../inc/tool.inc.php';
	$link = connect();
	//验证管理员是否登录
	include_once 'inc/is_manage_login.inc.php';


	$template['keywords'] = '管理员添加界面';
	$template['title'] = '管理员添加页';
	$template['description'] = '添加管理员操作';
	$template['css'] = array('style/public.css');

	

	if(isset($_POST['submit'])) {
		include 'inc/check_manage.inc.php';
		$query = "INSERT INTO `sfc_manage`(name,create_time,pw,level) VALUES ('{$_POST['name']}', now(), md5({$_POST['pw']}), {$_POST['level']})";
		execute($link, $query);
		if(mysqli_affected_rows($link)==1) {
			skip('2', 'manage.php', 'ok', '恭喜你，添加成功！'); 
		}else{
			skip('3', 'manage_add.php', 'error', '对不起，您的操作有误，请重试！'); 
		}
	}


?>
<?php include_once 'inc/header.inc.php' ?>
<div id="main">
	<div class="title" style="margin-bottom: 20px;">添加管理员</div>

	<form method="post">
	<table class="au">
			<tr>
				<td>管理员名称</td>
				<td><input  name="name" type="text" /></td>
				<td>
					<font style="color: red;">*&nbsp;名称不得为空，最大超过32个字符</font>
				</td>
			</tr>
			<tr>
				<td>管理员密码</td>
				<td><input name="pw" type="text" /></td>
				<td>
					<font style="color: red;">*&nbsp;不得少于六位</font>
				</td>
			</tr>
			<tr>
				<td>管理员等级</td>
				<td>
					<select name="level">
						<option value="1">普通管理员</option>
						<option value="0">超级管理员</option>
					</select>
				</td>
				<td>
					<font style="color: red;">*&nbsp;请选择一个等级，默认为普通管理员</font>
				</td>
			</tr>
		</table>		
		<input class="btn" style="margin-top: 20px;cursor: pointer;" type="submit" name="submit" value="添加">
		</form>
</div>
<?php include_once 'inc/footer.inc.php' ?>