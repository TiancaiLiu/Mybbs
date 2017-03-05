<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$template['title'] = '帖子修改页';
$template['description'] = '帖子修改页';
$template['keywords'] = '修改';
$template['css'] = array('style/public.css','style/publish.css');
$link=connect();
//判断管理员是否登录
$is_manage_login = is_manage_login($link);
//前台用户登录
$member_id=is_login($link);
if(!$member_id && !$is_manage_login){
	skip('3', 'login.php', 'error', '您没有登录!');
}
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('3', 'index.php', 'error', '帖子id参数不合法!');
}
$query = "SELECT * FROM `sfc_content` WHERE id={$_GET['id']}";
$result_content = execute($link, $query);
if(mysqli_num_rows($result_content)==1) {
	$data_content = mysqli_fetch_assoc($result_content);
	$data_content['title']=htmlspecialchars($data_content['title']);
	if (check_user($member_id, $data_content['member_id'], $is_manage_login)) {
		if(isset($_POST['submit'])) {
			include 'inc/check_publish.inc.php';
			$_POST=escape($link, $_POST);
			$query="UPDATE `sfc_content` SET module_id={$_POST['module_id']},title='{$_POST['title']}',content='{$_POST['content']}' WHERE id={$_GET['id']}";
			execute($link, $query);
			if(isset($_GET['return_url'])) {
				$return_url = $_GET['return_url'];
			}else{
				$return_url = "member.php?id={$member_id}";
			}
			if(mysqli_affected_rows($link)==1) {
				skip('2',$return_url, 'ok', '修改成功！');
			}else{
				skip('3',$return_url, 'error', '对不起，修改失败！');
			}
		}
	}else{
		skip('3','index.php', 'error', '这篇帖子不属于您，您没有权限！');
	}

}else{
	skip('3','index.php', 'error', '帖子不存在！');
}
?>
<?php include_once 'inc/header.inc.php' ?>
<div id="position" class="auto">
	 <a href="index.php">首页</a> &gt; 发布帖子
</div>
<div id="publish">
	<form method="post">
		<select name="module_id">
			<option value='-1'>请选择一个子版块</option>
			<?php 
			$query="SELECT * FROM `sfc_father_module` order by sort desc";
			$result_father=execute($link, $query);
			while ($data_father=mysqli_fetch_assoc($result_father)){
				echo "<optgroup label='{$data_father['module_name']}'>";
				$query="SELECT * from `sfc_son_module` where father_module_id={$data_father['id']} order by sort desc";
				$result_son=execute($link, $query);
				while ($data_son=mysqli_fetch_assoc($result_son)){
					if($data_son['id']==$data_content['module_id']){
						echo "<option selected='selected' value='{$data_son['id']}'>{$data_son['module_name']}</option>";
					}else{
						echo "<option value='{$data_son['id']}'>{$data_son['module_name']}</option>";
					}
				}
				echo "</optgroup>";
			}
			?>
		</select>
		<input class="title" placeholder="请输入标题" value="<?php echo $data_content['title']?>" name="title" type="text" />
		<textarea name="content" class="content"><?php echo $data_content['content']?></textarea>
		<input class="publish" type="submit" name="submit" value="" />
		<div style="clear:both;"></div>
	</form>
</div>

<?php include_once 'inc/footer.inc.php' ?>