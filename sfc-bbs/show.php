<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
$link=connect();
$member_id = is_login($link);

if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	skip('3', 'index.php', 'error', '帖子id参数不合法！');
}
//判断帖子是否存在
$query = "SELECT sc.id cid,sc.module_id, sc.title,sc.content,sc.publish_time,sc.member_id,sc.click,sm.name,sm.photo FROM `sfc_content`sc,`sfc_member` sm WHERE sc.id={$_GET['id']} AND sc.member_id=sm.id";
$result_content = execute($link, $query);
if(mysqli_num_rows($result_content) != 1) {
	skip('3', 'index.php', 'error', '本帖子不存在!');
}
//实时显示阅读量
$query = "UPDATE `sfc_content` set click=click+1 WHERE id={$_GET['id']}";
execute($link, $query);
$data_content = mysqli_fetch_assoc($result_content);
$data_content['click'] = $data_content['click']+1;

//下面两个函数的作用是防止用户输入特殊代码例如html代码改变了页面布局，nl2br是代码换行转换为真正的文字换行而不是空格
$data_content['title']=htmlspecialchars($data_content['title']);
$data_content['content']=nl2br(htmlspecialchars($data_content['content']));


$query = "SELECT * FROM `sfc_son_module` WHERE id={$data_content['module_id']}";
$result_son = execute($link, $query);
$data_son = mysqli_fetch_assoc($result_son);

$query = "SELECT * FROM `sfc_father_module` WHERE id={$data_son['father_module_id']}";
$result_father = execute($link, $query);
$data_father = mysqli_fetch_assoc($result_father);

//查询帖子回复总数
$query = "SELECT COUNT(*) FROM `sfc_reply` WHERE content_id={$_GET['id']}";
$count_reply = execute($link, $query);

$template['title'] = $data_content['title'];
$template['description'] = '显示所有帖子详细';
$template['keywords'] = '帖子详细页';
$template['css'] = array('style/public.css','style/show.css');
?>

<?php include_once 'inc/header.inc.php' ?>
<div id="position" class="auto">
	 <a href="index.php">首页</a> &gt; <a href="list_father.php?id=<?php echo $data_father['id']?>"><?php echo $data_father['module_name']?></a> &gt; <a href="list_son.php?id=<?php echo $data_son['id']?>"><?php echo $data_son['module_name']?></a> &gt;<?php echo $data_content['title']?>
</div>
<div id="main" class="auto">
	<div class="wrap1">
		<div class="pages">
			<?php 
			$query="SELECT count(*) FROM `sfc_reply` WHERE content_id={$_GET['id']}";
			$count_reply = num($link, $query);
			$page_size=10;
			$page = page($count_reply,10);
			echo $page['html'];
			?>
		</div>
		<a class="btn reply" href="reply.php?id=<?php echo $_GET['id']?>"></a>
		<div style="clear:both;"></div>
	</div>
	<?php 
	if($_GET['page']==1){
	?>
	<div class="wrapContent">
		<div class="left">
			<div class="face">
				<a target="_blank" href="">
					<img width=120 height=120 src="<?php if($data_content['photo']!=''){echo $data_content['photo'];}else{echo 'style/photo.jpg';}?>" />
				</a>
			</div>
			<div class="name">
				<a href=""><?php echo $data_content['name']?></a>
			</div>
		</div>
		<div class="right">
			<div class="title">
				<h2><?php echo $data_content['title']?></h2>
				<span>阅读：<?php echo $data_content['click']?>&nbsp;|&nbsp;回复：<?php echo $count_reply ?></span>
				<div style="clear:both;"></div>
			</div>
			<div class="pubdate">
				<span class="date">发布于：<?php echo $data_content['publish_time']?> </span>
				<span class="floor" style="color:red;font-size:14px;font-weight:bold;">楼主</span>
			</div>
			<div class="content">
				<?php echo $data_content['content']?>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
	<?php } ?>
	<?php 
	$query="SELECT sm.name,sr.member_id,sr.quote_id,sm.photo,sr.reply_time,sr.id,sr.content FROM sfc_reply sr,sfc_member sm WHERE sr.member_id=sm.id AND sr.content_id={$_GET['id']} ORDER BY id ASC {$page['limit']}";
	$result_reply = execute($link, $query);
	//楼层变量$i
	$i = ($_GET['page']-1) * $page_size+1;
	while($data_reply = mysqli_fetch_assoc($result_reply)) {
	$data_reply['content']=nl2br(htmlspecialchars($data_reply['content']));
	?>
	<div class="wrapContent">
		<div class="left">
			<div class="face">
				<a target="_blank" data-uid="2374101" href="">
					<img width=120 height=120 src="<?php if($data_reply['photo']!=''){echo $data_reply['photo'];}else{echo 'style/photo.jpg';}?>" />
				</a>
			</div>
			<div class="name">
				<a href=""><?php echo $data_reply['name']?></a>
			</div>
		</div>
		<div class="right">
			
			<div class="pubdate">
				<span class="date">回复时间：<?php echo $data_reply['reply_time']?></span>
				<span class="floor"><?php echo $i++?>楼&nbsp;|&nbsp;<a href="quote.php?id=<?php echo $_GET['id']?>&reply_id=<?php echo $data_reply['id']?>" target="_blank">引用</a></span>
			</div>
			<div class="content">
				<?php
				if($data_reply['quote_id']){
				$query="SELECT count(*) FROM `sfc_reply` WHERE content_id={$_GET['id']} and id<={$data_reply['quote_id']}";
				$floor=num($link,$query);
				$query="SELECT sfc_reply.content,sfc_member.name FROM `sfc_reply`,`sfc_member` WHERE sfc_reply.id={$data_reply['quote_id']} AND sfc_reply.content_id={$_GET['id']} AND sfc_reply.member_id=sfc_member.id";
				$result_quote=execute($link,$query);
				$data_quote=mysqli_fetch_assoc($result_quote);
				?>
				<div class="quote">
				<h2>引用 <?php echo $floor?>楼 <?php echo $data_quote['name']?> 发表的: </h2>
				<?php echo nl2br(htmlspecialchars($data_quote['content']))?>
				</div>
				<?php }?>
				<?php 
					echo $data_reply['content'];
				?>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
	<?php 
	}
	?>

	<div class="wrap1">
		<div class="pages">
			<?php
				echo $page['html'];
			?>
		</div>
		<a class="btn reply" href="reply.php?id=<?php echo $_GET['id']?>"></a>
		<div style="clear:both;"></div>
	</div>
</div>
<?php include_once 'inc/footer.inc.php' ?>