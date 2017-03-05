<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';

$template['title'] = '会员中心';
$template['description'] = '会员个人中心';
$template['keywords'] = '会员中心';
$template['css'] = array('style/public.css', 'style/list.css', 'style/member.css');
$link = connect();
$member_id = is_login($link);
//判断管理员是否登录
$is_manage_login = is_manage_login($link);
//判断会员id合法性
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	skip('3', 'index.php', 'error', '会员id参数不合法！');
}
//判断访问会员是否存在
$query = "SELECT * FROM `sfc_member` WHERE id={$_GET['id']}";
$result_member = execute($link, $query);
if(mysqli_num_rows($result_member) !=1 ){
	skip('3', 'index.php', 'error', '您所访问的会员不存在！');
}
$data_member = mysqli_fetch_assoc($result_member);
$query = "SELECT count(*) FROM `sfc_content` WHERE member_id = {$_GET['id']}";
$count_all = num($link, $query);
?>

<?php include_once 'inc/header.inc.php' ?>
<div id="position" class="auto">
	<a href="index.php">首页</a> &gt; <b style="color:red"><?php echo $data_member['name'] ?></b>
</div>
<div id="main" class="auto">
<div id="left">
	<ul class="postsList">
		<?php 
			$page = page($count_all, 10);
			$query="SELECT
			`sfc_content`.title,`sfc_content`.id,`sfc_content`.publish_time,`sfc_content`.click,`sfc_content`.member_id, `sfc_member`.name,`sfc_member`.photo FROM `sfc_content`,`sfc_member` WHERE
			`sfc_content`.member_id={$_GET['id']} AND
			`sfc_content`.member_id=`sfc_member`.id ORDER BY id DESC {$page['limit']}";
			$result_content = execute($link, $query);
			while ($data_content=mysqli_fetch_assoc($result_content)) {
				//查询回复总数、最后回复时间
				$query = "SELECT reply_time FROM `sfc_reply` WHERE content_id={$data_content['id']} ORDER BY id DESC limit 1";
				$result_last_reply = execute($link, $query);
				if(mysqli_num_rows($result_last_reply)==0){
					$last_time = "暂无回复";
				}else{
					$data_last_reply = mysqli_fetch_assoc($result_last_reply);
					$last_time = $data_last_reply['reply_time'];
				}
				$query = "SELECT COUNT(*) FROM `sfc_reply` WHERE content_id={$data_content['id']}";
		 ?>
		<li>
			<div class="smallPic">
					<img width="45" height="45" src="<?php if($data_content['photo']!=''){echo SUB_URL.$data_content['photo'];}else{echo 'style/photo.jpg';}?>" />
			</div>
			<div class="subject">
				<div class="titleWrap"><h2><a target="_blank" href="show.php?id=<?php echo $data_content['id']?>"><?php echo $data_content['title'] ?></a></h2></div>
				<p>
					发帖日期：<?php echo $data_content['publish_time']?>&nbsp;&nbsp;&nbsp;&nbsp;最后回复：<?php echo $last_time?>
				</p>
				<?php 
						if(check_user($member_id,$data_content['member_id'], $is_manage_login)){
							$return_url=urlencode($_SERVER['REQUEST_URI']);
							$url=urlencode("content_delete.php?id={$data_content['id']}&retun_url={$return_url}");		
							$message="你真的要删除帖子 {$data_content['title']} 吗？";
							$delete_url="confirm.php?url={$url}&return_url={$return_url}&message={$message}";
							echo "<a class='update' href='content_update.php?id={$data_content['id']}'>编辑</a> <a class='update' href='{$delete_url}'>删除</a>";
						}
				?>
			</div>
			<div class="count">
				<p>
					回复<br /><span><?php echo num($link, $query) ?></span>
				</p>
				<p>
					浏览<br /><span><?php echo $data_content['click'] ?></span>
				</p>
			</div>
			<div style="clear:both;"></div>
		</li>
		<?php } ?>
	</ul>
	<div class="pages">
		<?php 
		//$page = page($count_all, 10);这句话不能放在这，查询的时候要用到limit
		echo $page['html'];
		 ?>
	</div>
</div>
<div id="right">
	<div class="member_big">
		<dl>
			<dt>
				<img width="180" height="180" src="<?php if($data_member['photo']!=''){echo SUB_URL.$data_member['photo'];}else{echo 'style/photo.jpg';}?>" />
			</dt>
			<dd class="name"><?php echo $data_member['name'] ?></dd>
			<dd>帖子总计：<?php echo $count_all?></dd>
			<?php 
				if($member_id==$data_member['id']){
				?>
				<dd>操作：<a target="_blank" href="member_photo_update.php">修改头像</a>  | <a target="_blank" href="">修改密码</a></dd> 
				<?php }?>
		</dl>
		<div style="clear:both;"></div>
	</div>
</div>
<div style="clear:both;"></div>
</div>


<?php include_once 'inc/footer.inc.php' ?>