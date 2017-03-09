<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
$link = connect();
$member_id = is_login($link);
$is_manage_login = is_manage_login($link);

if(!isset($_GET['keyword'])){
	$_GET['keyword'] = '';
}
$_GET['keyword']=trim($_GET['keyword']);
$_GET['keyword']=escape($link,$_GET['keyword']);

$query = "SELECT count(*) FROM `sfc_content` WHERE title LIKE '%{$_GET['keyword']}%'";
$count_all = num($link, $query);

$template['title'] = '帖子搜索';
$template['description'] = '搜索';
$template['keywords'] = '搜索';
$template['css'] = array('style/public.css','style/index.css', 'style/list.css');

 ?>
 <?php include_once 'inc/header.inc.php' ?>
<div id="position" class="auto">
	 <a href="index.php">首页</a> &gt; 搜索页
</div>
<div id="main" class="auto">
	<div id="left">
		<div class="box_wrap">
			<h3>共有<?php echo $count_all?>帖子匹配</h3>
			
			<div class="pages_wrap">
				<div class="pages">
					<?php
						$page = page($count_all, 10);
						echo $page['html'];
					?>
				</div>
				<div style="clear:both;"></div>
			</div>
		</div>
		<div style="clear:both;"></div>
		<ul class="postsList">
			<?php
				$query = "SELECT `sfc_content`.title, `sfc_content`.id, `sfc_content`.publish_time, `sfc_content`.click, `sfc_content`.member_id,`sfc_member`.name, `sfc_member`.photo FROM `sfc_content`,`sfc_member` WHERE `sfc_content`.title LIKE '%{$_GET['keyword']}%' AND `sfc_content`.member_id=`sfc_member`.id ORDER BY publish_time DESC {$page['limit']}";
				$result_content = execute($link, $query);
				while($data_content = mysqli_fetch_assoc($result_content)) {
				$data_content['title']=htmlspecialchars($data_content['title']);
				$data_content['title_color'] = str_replace($_GET['keyword'],"<span style='color:red;'>{$_GET['keyword']}</span>",$data_content['title']);
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
					<a href="member.php?id=<?php echo $data_content['member_id']?>" target="_blank">
						<img width="45" height="45" src="<?php if($data_content['photo']!=''){echo SUB_URL.$data_content['photo'];}else{echo 'style/photo.jpg';} ?>">
					</a>
				</div>
				<div class="subject">
					<div class="titleWrap"><a href="show.php?id=<?php echo $data_content['id']?>" target="_blank"><?php echo $data_content['title_color']?></a></h2></div>
					<p>
						楼主：<?php echo $data_content['name']?>&nbsp;<?php echo $data_content['publish_time']?>&nbsp;&nbsp;&nbsp;&nbsp;最后回复：<?php echo $last_time ?>
					</p>
					<?php 
						if(check_user($member_id, $data_content['member_id'], $is_manage_login)){
							$return_url=urlencode($_SERVER['REQUEST_URI']);
							$url=urlencode("content_delete.php?id={$data_content['id']}&return_url={$return_url}");
							$message="你真的要删除帖子 {$data_content['title']} 吗？";
							$delete_url="confirm.php?url={$url}&return_url={$return_url}&message={$message}";
							echo "<a class='update' href='content_update.php?id={$data_content['id']}&return_url={$return_url}'>编辑</a> <a class='update' href='{$delete_url}'>删除</a>";
					}
					?>
				</div>
				<div class="count">
					<p>
						回复<br /><span><?php echo num($link, $query)?></span>
					</p>
					<p>
						浏览<br /><span><?php echo $data_content['click']?></span>
					</p>
				</div>
				<div style="clear:both;"></div>
			</li>
			<?php }?>
		</ul>
		<div class="pages_wrap">
			<div class="pages">
				<?php
						$page = page($count_all, 10);
						echo $page['html'];
				?>	
			</div>
			<div style="clear:both;"></div>
		</div>
	</div>
	<div id="right">
		<div class="classList">
			<div class="title">版块列表</div>
			<ul class="listWrap">
				<?php
					$query = "SELECT * FROM `sfc_father_module`";
					$result_father = execute($link, $query);
					while ($data_father = mysqli_fetch_assoc($result_father)) {
				?>
				<li>
					<h2><a href="list_father.php?id=<?php echo $data_father['id']?>"><?php echo $data_father['module_name']?></a></h2>
					<ul>
						<?php
							$query = "SELECT * FROM `sfc_son_module` WHERE father_module_id = {$data_father['id']}";
							$result_son = execute($link,$query);
							while($data_son = mysqli_fetch_assoc($result_son)){
						?>
						<li><h3><a href="list_son.php?id=<?php echo $data_son['id']?>"><?php echo $data_son['module_name']?></a></h3></li>	
						<?php
						}
						?>
					</ul>
				</li>
				<?php
				}
				?>
			</ul>
		</div>
	</div>
	<div style="clear:both;"></div>
</div>