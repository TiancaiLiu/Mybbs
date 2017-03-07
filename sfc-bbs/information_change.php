<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/upload.inc.php';
$link=connect();
if(!$member_id=is_login($link)){
	skip('3', 'login.php', 'error', '请登录之后再对自己的资料进行完善!');
}
$query = "SELECT * from `sfc_member` where id={$member_id}";
$result_member = execute($link ,$query);
$data_member = mysqli_fetch_assoc($result_member); 
if(isset($_POST['submit'])) {
	if(empty($_POST['constellation'])) {
		skip('3', 'information_change.php', 'error', '星座不得为空!'); 
	}
	if(empty($_POST['words'])) {
		skip('3', 'information_change.php', 'error', '个性签名不得为空！'); 
	}
	$_POST = escape($link, $_POST);
	$query = "UPDATE `sfc_member` set constellation='{$_POST['constellation']}', words='{$_POST['words']}' where id={$member_id}";
	execute($link, $query);
	if(mysqli_affected_rows($link) == 1){
		skip('3', 'member.php?id={$member_id}', 'ok', '修改成功！'); 
	}else{
		skip('3', 'information_change.php', 'error', '修改失败，请重试！'); 
	}
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title>资料编辑</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<style type="text/css">

body {
	font-size:12px;
	font-family:微软雅黑;
}
h2 {
	padding:0 0 10px 0;
	border-bottom: 1px solid #e3e3e3;
	color:#444;
}
.submit {
	background-color: #3b7dc3;
	color:#fff;
	padding:5px 22px;
	border-radius:2px;
	border:0px;
	cursor:pointer;
	font-size:14px;
}
#main {
	width:80%;
	margin:0 auto;
}
</style>
</head>
<body>
<div id="main">
	<form method="post">
		<h2>资料编辑(用户：<?php echo $data_member['name'] ?>)</h2>
		<div>
			<h3>请输入您的星座：</h3>
			<input type="text" name="constellation" value="<?php echo $data_member['constellation']?>"/>
			<h3>请编辑您的个性签名：</h3>
			<input type="text" name="words" value="<?php echo $data_member['words']?>" />
			<input class="submit" type="submit" name="submit" value="保存" />
		</div>
	</form>		
</div>
</body>
</html>