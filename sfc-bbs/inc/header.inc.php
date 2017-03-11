<?php 
	$query="select * from `sfc_info` where id=1";
	$result_info=execute($link, $query);
	$data_info=mysqli_fetch_assoc($result_info);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title><?php echo $template['title'] ?> - <?php echo $data_info['title']?></title>
<meta name="keywords" content="<?php echo $template['keywords'] ?> - <?php echo $data_info['title']?>" />
<meta name="description" content="<?php echo $template['description'] ?> - <?php echo $data_info['description']?>" />
<?php
foreach ($template['css'] as $val) {
	echo "<link rel='stylesheet' type='text/css' href='{$val}' />"."\n";
}
?>
<script type="text/javascript">
	function newgdcode(obj,url) {
		obj.src = url + '?nowtime=' + new Date().getTime();
	}
</script>
</head>
<body>
	<div class="header_wrap">
		<div id="header" class="auto">
			<div class="logo">sifangcai</div>
			<div class="nav">
				<a <?php if(basename($_SERVER['SCRIPT_NAME'])=='index.php'){echo 'class="hover"';}?> href="index.php">首页</a>
				<a <?php if(basename($_SERVER['SCRIPT_NAME'])=='publish.php'){echo 'class="hover"';}?> href="publish.php">发帖</a>
			</div>
			<div class="serarch">
				<form action="search.php" method="get">
					<input class="keyword" type="text" name="keyword" value="<?php if(isset($_GET['keyword']))echo $_GET['keyword']?>" placeholder="搜索其实很简单" />
					<input class="submit" type="submit" value="" />
				</form>
			</div>
			<div class="login">
			<?php
			if(isset($member_id) && $member_id) {
				$html =<<<A
				<a href="member.php?id={$member_id}" target="_blank">您好！{$_COOKIE['sfc']['name']}</a> <span style="color:#fff">|</span> <a href='logout.php'>注销</a>
A;
				echo $html;
			}else{
				$html =<<<A
					<a href='login.php'>登录</a>&nbsp;
					<a href='register.php'>注册</a>
A;
				echo $html;
			}
?>
			</div>
		</div>
	</div>
	<div style="margin-top:55px;"></div>