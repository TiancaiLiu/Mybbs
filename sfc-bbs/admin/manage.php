<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link = connect();
//验证管理员是否登录
include_once 'inc/is_manage_login.inc.php';
$template['keywords'] = '管理员界面';
$template['title'] = '管理员';
$template['description'] = '管理员';
$template['css'] = array('style/public.css');
?>
<?php include_once 'inc/header.inc.php' ?>
<div id="main" style="height:1000px;">

	<div class="title" style="margin-bottom: 20px;">父板块列表</div>
	<form method="post">
	<table class="list">
		<tr>
			<th>ID</th>
			<th>名称</th>	 	 	
			<th>等级</th>
			<th>创建日期</th>
			<th>操作</th>
		</tr>
		<?php 
			$query = 'SELECT  * FROM `sfc_manage`';
			$charset = 'set names "utf8";';
			execute($link, $charset);
			$result = execute($link, $query);
			while($data = mysqli_fetch_assoc($result)) {
				if($data['level'] == 0) {
					$data['level'] = '超级管理员';
				}else{
					$data['level'] = '普通管理员';
				}
				$url = urlencode("manage_delete.php?id={$data['id']}");
				$return_url = urlencode($_SERVER['REQUEST_URI']);  //返回页面
				$message = "你真的要删除管理员{$data['name']}吗？";
				$delete_url = "confirm.php?url={$url}&return_url={$return_url}&message={$message}";
				
$html =<<<A
				<tr>
					<td>{$data['id']}</td>
					<td>{$data['name']}</td>
					<td>{$data['level']}</td>
					<td>{$data['create_time']}</td>
					<td>
						<a href="$delete_url">[删除]</a>
					</td>
				</tr>
A;
			echo $html;
			}
		?>
		
	</table>
	</form>
</div>

<?php include_once 'inc/footer.inc.php' ?>