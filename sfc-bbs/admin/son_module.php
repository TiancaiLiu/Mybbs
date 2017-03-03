<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link = connect();

if(isset($_POST['submit'])){
	foreach ($_POST['sort'] as $key => $val) {
		if(!is_numeric($val) || !is_numeric($key)){
			skip(3, 'son_module.php', 'error', '排序参数错误！'); 
		}
		$query[] = "UPDATE sfc_son_module SET sort={$val} WHERE id={$key}";
	}
	//调用一次性执行多条sql语句方法
	if(execute_multi($link, $query, $error)){
		skip(3, 'son_module.php', 'ok', '排序成功！'); 
	}else{
		skip(3, 'son_module.php', 'error', $error); 
	}
}

$template['title'] = '子父板块列表页';
$template['description'] = '显示所有数据库中的数据';
$template['keywords'] = '子列表';
$template['css'] = array('style/public.css');
?>

<?php include 'inc/header.inc.php' ?>
<div id="main" style="height:1000px;">
	<div class="title" style="margin-bottom: 20px;">子板块列表</div>
	<form method="post">
	<table class="list">
		<tr>
			<th>排序</th>
			<th>ID</th>	 	 	
			<th>版块名称</th>
			<th>所属父板块</th>
			<th>版主</th>
			<th>操作</th>
		</tr>
		<?php 
			$query = "SELECT ssm.id, ssm.module_name,ssm.sort, sfm.module_name father_module_name, ssm.member_id FROM `sfc_son_module` ssm,`sfc_father_module` sfm WHERE ssm.father_module_id=sfm.id ORDER BY sfm.id";
			$charset = 'set names "utf8";';
			execute($link, $charset);
			$result = execute($link, $query);
			while($data = mysqli_fetch_assoc($result)) {
				 $url = urlencode("son_module_delete.php?id={$data['id']}");
				 $return_url = urlencode($_SERVER['REQUEST_URI']);  //返回页面
				 $message = "你真的要删除子板块{$data['module_name']}吗？";
				 $delete_url = "confirm.php?url={$url}&return_url={$return_url}&message={$message}";
$html =<<<A
				<tr>
					<td><input class="sort" type="text" name="sort[{$data['id']}]" value="{$data['sort']}" /></td>
					<td>{$data['id']}</td>
					<td>{$data['module_name']}</td>
					<td>{$data['father_module_name']}</td>
					<td>{$data['member_id']}</td>
					<td><a href="#">[访问]</a>&nbsp;&nbsp;
						<a href="son_module_update.php?id={$data['id']}">[编辑]</a>&nbsp;&nbsp;
						<a href="$delete_url">[删除]</a></td>
				</tr>
A;
			echo $html;
			}
		?>		
	</table>
	<input class="btn" style="margin-top: 20px;cursor: pointer;" type="submit" name="submit" value="排序">
	</form>
</div>
<?php include 'inc/footer.inc.php' ?>