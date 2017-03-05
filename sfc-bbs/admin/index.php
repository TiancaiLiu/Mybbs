<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
//验证管理员是否登录
include_once 'inc/is_manage_login.inc.php';

$query = "SELECT * from `sfc_manage` where id={$_SESSION['manage']['id']}";
$result_manage = execute($link, $query);
$data_manage = mysqli_fetch_assoc($result_manage);

$query="SELECT count(*) from `sfc_father_module`";
$count_father_module=num($link,$query);

$query="SELECT count(*) from `sfc_son_module`";
$count_son_module=num($link,$query);

$query="SELECT count(*) from `sfc_content`";
$count_content=num($link,$query);

$query="SELECT count(*) from `sfc_reply`";
$count_reply=num($link,$query);

$query="SELECT count(*) from `sfc_member`";
$count_member=num($link,$query);

$query="SELECT count(*) from `sfc_manage`";
$count_manage=num($link,$query);

if($data_manage['level'] == '0'){
	$data_manage['level'] = '超级管理员';
}else{
	$data_manage['level'] = '普通管理员';
}


$template['keywords'] = '后台系统信息';
$template['title'] = '系统信息';
$template['description'] = '系统信息';
$template['css'] = array('style/public.css');

?>
<?php include 'inc/header.inc.php' ?>
<div id="main">
	<div class="title">系统信息</div>
	<div class="explain">
		<ul>
			<li> 您好，<b style="font-size: 22px;"><?php echo $data_manage['name']?></b></li>
			<li> 所属角色：<b style="font-size: 15px;"><?php echo $data_manage['level']?></b></li>
			<li> 创建时间：<b style="font-size: 10px;"><?php echo $data_manage['create_time']?></b></li>
		</ul>
	</div>
	<div class="explain">
		<ul>
			<li>网站数据统计：</li>
			<li>父版块(<b style="font-size: 15px;color:#ff0000"><?php echo $count_father_module?></b>)</li>
	        <li>子版块(<b style="font-size: 15px;color:#ff0000"><?php echo $count_son_module?></b>)</li>
	        <li>帖子(<b style="font-size: 15px;color:#ff0000"><?php echo $count_content?></b>)</li>
	        <li>回复(<b style="font-size: 15px;color:#ff0000"><?php echo $count_reply?></b>)</li>
	        <li>会员(<b style="font-size: 15px;color:#ff0000"><?php echo $count_member?></b>)</li>
	        <li>管理员(<b style="font-size: 15px;color:#ff0000"><?php echo $count_manage?></b>)</li>
		</ul>
	</div>
	<div class="explain">
		<ul>
			<li>-> 服务器操作系统：<b style="font-size: 15px;"><?php echo PHP_OS?> </b></li>
			<li>-> 服务器软件：<b style="font-size: 15px;"><?php echo $_SERVER['SERVER_SOFTWARE']?> </b></li>
			<li>-> MySQL 版本：<b style="font-size: 15px;"><?php echo  mysqli_get_server_info($link)?></b></li>
			<li>-> 最大上传文件：<b style="font-size: 15px;"><?php echo ini_get('upload_max_filesize')?></b></li>
			<li>-> 内存限制：<b style="font-size: 15px;"><?php echo ini_get('memory_limit')?></b></li>
		</ul>
	</div>
	
	<div class="explain">
		<ul>
			<li>-> 程序安装位置(绝对路径)：<b style="font-size: 15px;"><?php echo SA_PATH?></b></li>
			<li>-> 程序在web根目录下的位置(首页的url地址)：<b style="font-size: 15px;"><?php echo SUB_URL?></b></li>
			<li>-> 程序版本：<b style="font-size: 15px;">sfkbbs V1.0</b></li>
		</ul>
	</div>
</div>
<?php include 'inc/footer.inc.php' ?>