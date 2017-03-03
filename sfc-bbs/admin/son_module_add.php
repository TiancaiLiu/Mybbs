<?php
	//文件引入
	include_once '../inc/config.inc.php';
	include_once '../inc/mysql.inc.php';
	include_once '../inc/tool.inc.php';

	$template['keywords'] = '添加界面';
	$template['title'] = '子板块添加页';
	$template['description'] = '添加子板块操作';
	$template['css'] = array('style/public.css');

	$link = connect();
	//编码设置
	$charset = "SET NAMES 'utf8';";
	execute($link, $charset);

	if(isset($_POST['submit'])){
		//验证用户填写的信息
		$check_flag = 'add';
		include 'inc/check_son_module.inc.php';
		//添加数据
		$query = "INSERT INTO `sfc_son_module`(father_module_id,module_name,info,member_id,sort) VALUES ({$_POST['father_module_id']}, '{$_POST['module_name']}', '{$_POST['info']}', {$_POST['member_id']}, {$_POST['sort']})";
		execute($link, $query);
		if(mysqli_affected_rows($link)==1) {
			skip(2, 'son_module.php', 'ok', '恭喜你，添加成功！'); 
		}else{
			skip(3, 'son_module_add.php', 'error', '对不起，请重试！'); 
		}
	}
?>
<?php include 'inc/header.inc.php' ?>
<div id="main">
	<div class="title" style="margin-bottom: 20px;">添加子板块</div>

	<form method="post">
		<table class="au">
			<tr>
				<td>所属父板块</td>
				<td>
					<select name="father_module_id">
						<option value="0">=======请选择一个父板块========</option>
						<?php
							$query = "SELECT * FROM `sfc_father_module`";
							$result_father = execute($link, $query);
							while($data_father = mysqli_fetch_assoc($result_father)) {
								echo "<option value='{$data_father['id']}'>{$data_father['module_name']}</option>";
							}
						?>
					</select>
				</td>
				<td>
					<font style="color: red;">*&nbsp;必须选择一个所属父板块</font>
				</td>
			</tr>
			<tr>	
				<td>版块名称</td>
				<td><input name="module_name" type="text" /></td>
				<td>
					<font style="color: red;">*&nbsp;板块名称不得为空，最大超过50个字符</font>
				</td>
			</tr>
			<tr>	
				<td>版块简介</td>
				<td>
					<textarea name="info"></textarea>
				</td>
				<td>
					<font style="color: red;">*&nbsp;板块简介不得多于225个字符</font>
				</td>
			</tr>
			<tr>	
				<td>版主</td>
				<td>
					<select name="member_id">
						<option value="0">==请选择一个会员作为版主==</option>
					</select>
				</td>
				<td>
					<font style="color: red;">*&nbsp;你可以在这边选择一个会员作为版主</font>
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