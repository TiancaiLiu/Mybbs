<?php
	//文件引入
	include_once '../inc/config.inc.php';
	include_once '../inc/mysql.inc.php';
	include_once '../inc/tool.inc.php';

	$link = connect();
	//验证管理员是否登录
	include_once 'inc/is_manage_login.inc.php'
	//判断是否有id传递或者id是否是数字
	if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
		skip(3, 'father_module.php', 'error', 'id参数错误！');
	}
	//设置字符编码（不设置就是乱码，不知道为什么，哎！）
	$charset = "SET NAMES 'utf8';";
	execute($link, $charset);

	$query = "SELECT * FROM `sfc_father_module` WHERE id = {$_GET['id']}";
	$result = execute($link, $query);
	if(!mysqli_num_rows($result)) {
		skip(3, 'father_module.php', 'error', '这条版块信息不存在！');
	}
	if(isset($_POST['submit'])) {
		//验证用户填写的信息
		$check_flag = 'update';
		include 'inc/check_father_module.inc.php';
		
		$query = "UPDATE `sfc_father_module` SET module_name='{$_POST['module_name']}',sort={$_POST['sort']} WHERE id={$_GET['id']}";
		execute($link, $query);
		if(mysqli_affected_rows($link)==1) {
			skip(2, 'father_module.php', 'ok', '修改成功！');
		}else{
			skip(3, 'father_module.php', 'error', '修改失败，检查是否有修改！');
		}
	}

	$data = mysqli_fetch_assoc($result);


	$template['keywords'] = '修改界面';
	$template['title'] = '父板块修改页';
	$template['description'] = '修改父板块操作';
	$template['css'] = array('style/public.css');
?>
<?php include 'inc/header.inc.php' ?>
<div id="main">
	<div class="title" style="margin-bottom: 20px;">编辑父板块 - <?php echo $data['module_name']?></div>

	<form method="post">
	<table class="au">
			<tr>
				<td>版块名称</td>
				<td><input  name="module_name" type="text" value="<?php echo $data['module_name']?>"/></td>
				<td>
					<font style="color: red;">*&nbsp;板块名称不得为空，最大超过50个字符</font>
				</td>
			</tr>
			<tr>
				<td>排序</td>
				<td><input name="sort" type="text" value="<?php echo $data['sort']?>" /></td>
				<td>
					<font style="color: red;">*&nbsp;填写一个数字即可</font>
				</td>
			</tr>
		</table>		
		<input class="btn" style="margin-top: 20px;cursor: pointer;" type="submit" name="submit" value="更新">
		</form>
</div>

<?php include 'inc/footer.inc.php' ?>