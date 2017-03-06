<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/upload.inc.php';
$link=connect();
if(!$member_id=is_login($link)){
	skip('3', 'login.php', 'error', '请登录之后再对自己的密码做设置!');
}
$query="SELECT * from `sfc_member` where id={$member_id}";
$result_memebr=execute($link,$query);
$data_member=mysqli_fetch_assoc($result_memebr);
if(isset($_POST['submit'])){
	$pw = md5($_POST['pw']);
	$newpw = md5($_POST['newpw']);
	if(mb_strlen($_POST['newpw']) < 6) {
		skip('3', 'member_pw_update.php', 'error', '新密码不得少于6位！'); 
	}
	if($newpw == $data_member['pw']){
		skip('3', 'member_pw_update.php', 'error', '新密码和原密码相同，请重新输入！'); 
	}
	if($pw == $data_member['pw']) {
		$query = "UPDATE `sfc_member` set pw=md5('{$_POST['newpw']}') where id={$member_id}";		
		execute($link, $query);
		if(mysqli_affected_rows($link)==1){
			skip('3','index.php','ok','更改密码成功,请重新登录！');
		}else{
			skip('3','member_pw_update.php','error','更改密码失败，请重试！');
		}
	}else{
		skip('3','member_pw_update.php','error','您输入的原密码错误！');
	}

}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title>修改密码</title>
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
		<h2>更改密码(用户名：<?php echo $data_member['name'] ?>)</h2>
		<div>
			<h3>请输入原密码：</h3>
			<input type="password" name="pw" />
			<h3>请输入新密码：</h3>
			<input type="password" name="newpw" />
			<input class="submit" type="submit" name="submit" value="保存" />
		</div>
	</form>		
</div>
</body>
</html>