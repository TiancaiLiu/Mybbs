<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
$link=connect();

$charset = "SET NAMES 'utf8';";
execute($link, $charset);
//判断用户是否登录
$member_id=is_login($link);
//判断管理员是否登录
$is_manage_login = is_manage_login($link);
//判断id参数是否合法
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	skip(3, 'index.php', 'error', '父板块id参数不合法！'); 
}
//查询当前传递id是否存在
$query = "SELECT * FROM `sfc_father_module` WHERE id={$_GET['id']}";
$result_father = execute($link, $query);
if(mysqli_num_rows($result_father)==0) {
	skip(3, 'index.php', 'error', '该父板块不存在！'); 
}
$data_father = mysqli_fetch_assoc($result_father);

$query = "SELECT * FROM `sfc_son_module` WHERE father_module_id={$_GET['id']}";
$result_son = execute($link, $query);
$id_son = '';
$son_list = '';
while($data_son = mysqli_fetch_assoc($result_son)) {
	$id_son .= $data_son['id'].',';
	$son_list .= "<a href='list_son.php?id={$data_son['id']}'>{$data_son['module_name']}</a> ";
}
$id_son = trim($id_son, ',');   //该函数的作用是去掉两边的逗号
if($id_son == '') {
	$id_son='-1';
}

$query = "SELECT count(*) FROM `sfc_content` WHERE module_id IN ({$id_son})";
$count_all = num($link, $query);
$query = "SELECT count(*) FROM `sfc_content` WHERE module_id IN ({$id_son}) AND publish_time > CURDATE()";
$count_today = num($link, $query);
 


$template['title'] = '父板块列表页';
$template['description'] = '显示所有父板块内容';
$template['keywords'] = '父板块列表';
$template['css'] = array('style/public.css','style/list.css','style/member.css');
?>
<?php include_once 'inc/header.inc.php' ?>
<div id="position" class="auto">
	 <a href="index.php">首页</a> &gt; <a href="list_father.php?id=<?php echo $data_father['id'] ?>"><?php echo $data_father['module_name']?></a>
</div>
<div id="main" class="auto">
	<div id="left">
		<div class="box_wrap">
			<h3><?php echo $data_father['module_name']?></h3>
			<div class="num">
			    今日：<span><?php echo $count_today?></span>&nbsp;&nbsp;&nbsp;
			    总帖：<span><?php echo $count_all?></span>
			  <div class="moderator"> 子版块： <?php echo $son_list?></div>
			</div>
			<div class="pages_wrap">
				<a class="btn publish" href="publish.php?father_module_id=<?php echo $_GET['id']?>" target="_blank"></a>
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
			$query = "SELECT `sfc_content`.id, `sfc_content`.module_id, `sfc_content`.title, `sfc_content`.publish_time, `sfc_content`.click, `sfc_content`.member_id,`sfc_member`.name, `sfc_member`.photo, `sfc_son_module`.module_name FROM `sfc_content`, `sfc_member`, `sfc_son_module` WHERE `sfc_content`.module_id IN ({$id_son}) AND `sfc_content`.member_id=`sfc_member`.id AND `sfc_content`.module_id=`sfc_son_module`.id {$page['limit']}";
			$result_content = execute($link, $query);
			//var_dump(mysqli_fetch_all($result_content, MYSQLI_ASSOC));
			while ($data_content = mysqli_fetch_assoc($result_content)) {
			$data_content['title']=htmlspecialchars($data_content['title']);
			$query="SELECT reply_time FROM `sfc_reply` WHERE content_id={$data_content['id']} ORDER BY id DESC limit 1";
			$result_last_reply=execute($link, $query);
			if(mysqli_num_rows($result_last_reply)==0){
				$last_time='暂无';
			}else{
				$data_last_reply=mysqli_fetch_assoc($result_last_reply);
				$last_time=$data_last_reply['reply_time'];
			}
			$query="SELECT count(*) FROM `sfc_reply` WHERE content_id={$data_content['id']}";
		?>
			<li>
				<div class="smallPic">
					<a href="member.php?id=<?php echo $data_content['member_id']?>" target="_blank">
						<img width="45" height="45" src="<?php if($data_content['photo']!=''){echo SUB_URL.$data_content['photo'];}else{echo 'style/photo.jpg';} ?>">
					</a>
				</div>
				<div class="subject">
					<div class="titleWrap"><a href="list_son.php?id=<?php echo $data_content['module_id']?>">[<?php echo $data_content['module_name']?>]</a>&nbsp;&nbsp;<h2><a href="show.php?id=<?php echo $data_content['id']?>" target="_blank"><?php echo $data_content['title']?></a></h2></div>
					<p>
						楼主：<?php echo $data_content['name']?>&nbsp;<?php echo $data_content['publish_time']?>&nbsp;&nbsp;&nbsp;&nbsp;最后回复：<?php echo $last_time?>
					</p>
					<?php 
						if(check_user($member_id, $data_content['member_id'],$is_manage_login)){
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
			<?php
			}
			?>
		</ul>
		<div class="pages_wrap">
			<a class="btn publish" href="publish.php?father_module_id=<?php echo $_GET['id']?>" target="_blank"></a>
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
<?php include_once 'inc/footer.inc.php' ?>