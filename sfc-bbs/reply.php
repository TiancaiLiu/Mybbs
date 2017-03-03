<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$template['title'] = '帖子回复页';
$template['description'] = '帖子回复页';
$template['keywords'] = '回复';
$template['css'] = array('style/public.css','style/publish.css');

$link = connect();
$charset = "SET NAMES 'utf8';";
execute($link, $charset);
//判断是否登录
if(!$member_id=is_login($link)) {
	skip(3, 'login.php', 'error', '您还未登录，请登录后再回复！');
}
//判断id参数合法
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	skip('3', 'index.php', 'error', '您要回复的帖子id参数不合法!');
}
$query="SELECT sc.id,sc.title,sm.name FROM `sfC_content` sc,`sfC_member` sm WHERE sc.id={$_GET['id']} AND sc.member_id=sm.id";
$result_content = execute($link, $query);
if(mysqli_num_rows($result_content) != 1){
	skip('3', 'index.php', 'error', '您要回复的帖子不存在!');
}

if(isset($_POST['submit'])) {
	include_once 'inc/check_reply.inc.php';
	$_POST = escape($link, $_POST);
	$query = "INSERT INTO `sfc_reply`(content_id, content, reply_time, member_id) VALUES ({$_GET['id']},'{$_POST['content']}',now(),{$member_id})";
	execute($link, $query);
	if(mysqli_affected_rows($link)==1){
		skip('3', "show.php?id={$_GET['id']}", 'ok', '回复成功!');
	}else{
		skip('3', $_SERVER['REQUEST_URI'], 'error', '回复失败,请重试!');
	}
}

$data_content=mysqli_fetch_assoc($result_content);
$data_content['title']=htmlspecialchars($data_content['title']);
?>

<?php include_once 'inc/header.inc.php' ?>

<div id="position" class="auto">
	 <a>首页</a> &gt; 回复帖子
</div>
<div id="publish">
	<div>回复：由 <?php echo $data_content['name']?> 发布的： <?php echo $data_content['title']?></div>
	<form method="post">
		<textarea name="content" class="content"></textarea>
		<input class="reply" type="submit" name="submit" value="" />
		<div style="clear:both;"></div>
	</form>
</div>

<?php include_once 'inc/footer.inc.php' ?>