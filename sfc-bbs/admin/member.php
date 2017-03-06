<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link = connect();
//验证管理员是否登录
include_once 'inc/is_manage_login.inc.php';

$template['keywords'] = '会员界面';
$template['title'] = '用户列表';
$template['description'] = '会员';
$template['css'] = array('style/public.css');
?>
<?php include_once 'inc/header.inc.php' ?>
<div id="main" style="height:1000px;">

	<div class="title" style="margin-bottom: 20px;">会员列表</div>
	<form method="post">
	<table class="list">
		<tr>
			<th>ID</th>
			<th>用户名</th>	 	 	
			<th>用户头像</th>
			<th>注册时间</th>
		</tr>
		<?php 
			$query = 'SELECT  * FROM `sfc_member`';
			$charset = 'set names "utf8";';
			execute($link, $charset);
			$result = execute($link, $query);
			while($data = mysqli_fetch_assoc($result)) {				
		?>
				<tr>
					<td><?php echo $data['id']?></td>
					<td><?php echo $data['name']?></td>
					<td>
						<img width="45" height="45" src="<?php if($data['photo']!=''){echo SUB_URL.$data['photo'];}else{echo '../style/photo.jpg';} ?>" />
					</td>
					<td><?php echo $data['register_time']?></td>
				</tr>
			<?php } ?>
	</table>
	</form>
</div>

<?php include_once 'inc/footer.inc.php' ?>
?>