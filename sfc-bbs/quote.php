<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$template['title'] = '帖子引用回复页';
$template['description'] = '帖子引用回复页';
$template['keywords'] = '引用回复';
$template['css'] = array('style/public.css','style/publish.css');
$link = connect();
//判断是否登录
if(!$member_id=is_login($link)){
	skip('3','login.php', 'error', '请登录之后再做回复!');
}
//判断帖子id合法性
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('3', 'index.php', 'error', '您要回复的帖子id参数不合法!');
}

//查询并判断帖子是否存在
$query="SELECT sc.id,sc.title,sm.name FROM `sfc_content` sc,`sfc_member` sm WHERE sc.id={$_GET['id']} AND sc.member_id=sm.id";
$result_content=execute($link, $query);
if(mysqli_num_rows($result_content)!=1){
	skip('3', 'index.php', 'error', '您要回复的帖子不存在!');
}
$data_content=mysqli_fetch_assoc($result_content);
$data_content['title']=htmlspecialchars($data_content['title']);
//判断引用的回复id的合法性
if(!isset($_GET['reply_id']) || !is_numeric($_GET['reply_id'])){
	skip('3', 'index.php', 'error', '您要引用的回复id参数不合法!');
}
//查询并判断引用的回复是否存在
$query="SELECT sfc_reply.content,sfc_member.name FROM `sfc_reply`,`sfc_member` WHERE sfc_reply.id={$_GET['reply_id']} AND sfc_reply.content_id={$_GET['id']} AND sfc_reply.member_id=sfc_member.id";
$result_reply=execute($link, $query);
if(mysqli_num_rows($result_reply)!=1){
	skip('3', 'index.php', 'error', '您要引用的回复不存在!');
}
//数据库插入数据
if(isset($_POST['submit'])){
	include 'inc/check_reply.inc.php';
	$_POST=escape($link,$_POST);
	$query="INSERT INTO `sfc_reply`(content_id,quote_id,content,reply_time,member_id) 
			values(
				{$_GET['id']},{$_GET['reply_id']},'{$_POST['content']}',now(),{$member_id}
			)";
	execute($link, $query);
	if(mysqli_affected_rows($link)==1){
		skip('3', "show.php?id={$_GET['id']}", 'ok', '回复成功!');
	}else{
		skip('3',$_SERVER['REQUEST_URI'], 'error', '回复失败,请重试!');
	}
}
//遍历所需数据
$data_reply=mysqli_fetch_assoc($result_reply);
$data_reply['content']=nl2br(htmlspecialchars($data_reply['content']));
//使用计算在这一条回复之前（包括这一条记录在内）的所有记录的数量就能得到这条记录是在第几楼
$query="SELECT count(*) FROM `sfc_reply` WHERE content_id={$_GET['id']} AND id<={$_GET['reply_id']}";
$floor=num($link,$query);
?>
<?php include 'inc/header.inc.php' ?>
<div id="publish">
	<div><?php echo $data_content['name']?>: <?php echo $data_content['title']?></div>
	<div class="quote">
		<p class="title">引用<?php echo $floor?>楼 <?php echo $data_reply['name']?> 发表的: </p>
		<?php echo $data_reply['content']?>
	</div>
	<form method="post">
		<textarea name="content" class="content"></textarea>
		<input class="reply" type="submit" name="submit" value="" />
		<div style="clear:both;"></div>
	</form>
</div>
<?php include 'inc/footer.inc.php' ?>