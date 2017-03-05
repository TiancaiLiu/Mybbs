<?php
	//文件引入
	include_once '../inc/config.inc.php';
	include_once '../inc/mysql.inc.php';
	include_once '../inc/tool.inc.php';
	$link = connect();
	//验证管理员是否登录
	include_once 'inc/is_manage_login.inc.php';

	$template['keywords'] = '修改界面';
	$template['title'] = '子板块修改页';
	$template['description'] = '修改子板块操作';
	$template['css'] = array('style/public.css');

	
	//判断是否有id传递或者id是否是数字
	if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
		skip(3, 'father_module.php', 'error', 'id参数错误！');
	}
	//编码设置
	$charset = "SET NAMES 'utf8';";
	execute($link, $charset);
	//数据查询
	$query = "SELECT * FROM `sfc_son_module` WHERE id = {$_GET['id']}";
	$result = execute($link, $query);
	if(!mysqli_num_rows($result)) {
		skip(3, 'father_module.php', 'error', '这条子版块信息不存在！');
	}
	$data = mysqli_fetch_assoc($result);


	if(isset($_POST['submit'])){
		//验证用户填写的信息
		$check_flag = 'update';
		include 'inc/check_son_module.inc.php';

		$query = "UPDATE `sfc_son_module` SET 
					father_module_id={$_POST['father_module_id']},
					module_name='{$_POST['module_name']}', 
					info='{$_POST['info']}', 
					member_id={$_POST['member_id']}, 
					sort={$_POST['sort']} 
					WHERE id={$_GET['id']}";
		execute($link, $query);
		if(mysqli_affected_rows($link)==1) {
			skip(2, 'son_module.php', 'ok', '修改成功！');
		}else{
			skip(3, 'son_module.php', 'error', '修改失败，检查是否有修改！');
		}
	}
?>
<?php include 'inc/header.inc.php' ?>
<div id="main">
	<div class="title" style="margin-bottom: 20px;">修改子板块 - <?php echo $data['module_name']?></div>

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
								if($data['father_module_id']==$data_father['id']) {
									echo "<option selected='selected' value='{$data_father['id']}'>{$data_father['module_name']}</option>";
								}else{
									echo "<option value='{$data_father['id']}'>{$data_father['module_name']}</option>";
								}
								
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
				<td><input name="module_name" type="text" value="<?php echo $data['module_name']?>" /></td>
				<td>
					<font style="color: red;">*&nbsp;板块名称不得为空，最大超过66个字符</font>
				</td>
			</tr>
			<tr>	
				<td>版块简介</td>
				<td>
					<textarea name="info"><?php echo $data['info']?></textarea>
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
				<td><input name="sort" value="<?php echo $data['sort']?>" type="text" /></td>
				<td>
					<font style="color: red;">*&nbsp;填写一个数字即可</font>
				</td>
			</tr>
		</table>		
		<input class="btn" style="margin-top: 20px;cursor: pointer;" type="submit" name="submit" value="更新">
	</form>
</div>