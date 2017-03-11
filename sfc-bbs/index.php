<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$link=connect();
$charset = "SET NAMES 'utf8';";
execute($link, $charset);

$member_id=is_login($link);
//var_dump($_COOKIE);die();

$template['title'] = '首页';
$template['description'] = '私房菜首页';
$template['keywords'] = '首页';
$template['css'] = array('style/public.css','style/index.css');
?>

<?php include_once 'inc/header.inc.php' ?>
<!-- <div id="hot" class="auto">
	<div class="title">热门动态</div>
	<ul class="newlist">
		<li><a href="#">[菜鸟]</a> <a href="#">我是你爸爸...</a></li>	
	</ul>
	<div style="clear:both;"></div>
</div> -->
<?php 
$query="SELECT * FROM `sfc_father_module` ORDER BY sort DESC";
$result_father=execute($link, $query);
while($data_father=mysqli_fetch_assoc($result_father)){
?>
<div class="box auto">
	<div class="title">
		<a href="list_father.php?id=<?php echo $data_father['id']?>" style="color:#105cb6;"><?php echo $data_father['module_name']?></a>
	</div>
	<div class="classList">
		<?php 
		$query="SELECT * FROM `sfC_son_module` WHERE father_module_id={$data_father['id']}";
		$result_son=execute($link, $query);
		if(mysqli_num_rows($result_son)){
			while ($data_son=mysqli_fetch_assoc($result_son)){
				$query="SELECT count(*) FROM `sfc_content` WHERE module_id={$data_son['id']} and publish_time > CURDATE()";//判断是不是今天发的帖子
				$count_today=num($link,$query);
				$query="SELECT count(*) FROM `sfc_content` WHERE module_id={$data_son['id']}";
				$count_all=num($link,$query);
				$html=<<<A
					<div class="childBox new">
						<h2><a href="list_son.php?id={$data_son['id']}">{$data_son['module_name']}</a> <span>(今日{$count_today}条)</span></h2>
						帖子：{$count_all}<br />
					</div>
A;
				echo $html;
			}
		}else{
			echo '<div style="padding:10px 0;">暂无子版块...</div>';
		}
		?>
		<div style="clear:both;"></div>
	</div>
</div>
<?php }?>
<?php include_once 'inc/footer.inc.php' ?>