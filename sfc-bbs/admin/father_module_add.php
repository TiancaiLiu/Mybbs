<?php
	//文件引入
	include_once '../inc/config.inc.php';
	include_once '../inc/mysql.inc.php';
	include_once '../inc/tool.inc.php';
	$link = connect();
	//验证管理员是否登录
	include_once 'inc/is_manage_login.inc.php';
	//表单提交验证
	if(isset($_POST['submit'])){
		
		//设置字符编码（不设置就是乱码，不知道为什么，哎！）
		$charset = "SET NAMES 'utf8';";
		execute($link, $charset);		
		//验证用户填写的信息
		$check_flag = 'add';
		include 'inc/check_father_module.inc.php';
		//添加数据
		$query = "INSERT INTO `sfc_father_module`(module_name,sort) VALUES ('{$_POST['module_name']}', '{$_POST['sort']}')";
		execute($link, $query);
		if(mysqli_affected_rows($link)==1) {
			skip('2', 'father_module.php', 'ok', '恭喜你，添加成功！'); 
		}else{
			skip('3', 'father_module_add.php', 'error', '对不起，您的操作有误，请重试！'); 
		}
	}
	//界面设置
	$template['keywords'] = '添加界面';
	$template['title'] = '父板块添加页';
	$template['description'] = '添加父板块操作';
	$template['css'] = array('style/public.css');
?>

<?php include 'inc/header.inc.php' ?>
<div id="main">
	<div class="title" style="margin-bottom: 20px;">添加父板块</div>

	<form method="post">
	<table class="au">
			<tr>
				<td>版块名称</td>
				<td><input  name="module_name" type="text" /></td>
				<td>
					<font style="color: red;">*&nbsp;板块名称不得为空，最大超过50个字符</font>
				</td>
			</tr>
			<tr>
				<td>排序</td>
				<td><input name="sort" value="0" type="text" /></td>
				<td>
					<font style="color: red;">*&nbsp;填写一个数字即可</font>
				</td>
			</tr>
		</table>		
		<input class="btn" style="margin-top: 20px;cursor: pointer;" type="submit" name="submit" value="添加">
		</form>
</div>

<?php include 'inc/footer.inc.php' ?>