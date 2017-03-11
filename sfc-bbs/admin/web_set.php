<?php 
	include_once '../inc/config.inc.php';
	include_once '../inc/mysql.inc.php';
	include_once '../inc/tool.inc.php';
	$link = connect();
	//验证管理员是否登录
	include_once 'inc/is_manage_login.inc.php';
	$query="SELECT * from `sfc_info` where id=1";
	$result_info = execute($link, $query);
	$data_info = mysqli_fetch_assoc($result_info);
	if(isset($_POST['submit'])) {
		$_POST=escape($link,$_POST);
		$query = "UPDATE `sfc_info` set title='{$_POST['title']}',keywords='{$_POST['keywords']}',description='{$_POST['description']}' where id=1";
		execute($link, $query);
		if(mysqli_affected_rows($link)==1){
			skip('3','web_set.php','ok','修改成功！');
		}else{
			skip('3','web_set.php','error','修改失败！');
		}
	}

	$template['keywords'] = '站点设置';
	$template['title'] = '站点设置';
	$template['description'] = '站点设置';
	$template['css'] = array('style/public.css');

 ?>
 <?php include 'inc/header.inc.php' ?>
 <div id="main">
	<div class="title" style="margin-bottom: 20px;">网站设置</div>

	<form method="post">
	<table class="au">
			<tr>
				<td>网站标题</td>
				<td><input  name="title" type="text" value="<?php echo $data_info['title']?>" /></td>
				<td>
					<font style="color: red;">*&nbsp;即是前台页面的表题</font>
				</td>
			</tr>
			<tr>
				<td>关键字</td>
				<td><input name="keywords" type="text" value="<?php echo $data_info['keywords']?>" /></td>
				<td>
					<font style="color: red;">*&nbsp;关键字</font>
				</td>
			</tr>
			<tr>
				<td>描述</td>
				<td>
					<textarea name="description" ><?php echo $data_info['description']?></textarea>
				</td>
				<td>
					<font style="color: red;">*&nbsp;描述</font>
				</td>
			</tr>
		</table>		
		<input class="btn" style="margin-top: 20px;cursor: pointer;" type="submit" name="submit" value="更新">
		</form>
</div>
<?php include 'inc/footer.inc.php' ?>