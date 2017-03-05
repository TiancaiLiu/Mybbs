<?php
/**
 *	@name skip 跳转提示函数
 *	@author 刘敬雄  2016-11-30
 *	@abstract $time  跳转等待时间 
 			  $url  跳转路径
 *			  $pic  提示图标 example 'ok' 'error'
 *			  $message  提示信息
  *			  
 */	
function skip($time, $url, $pic, $message) {
$html =<<<A
	<!DOCTYPE html>
	<html lang="zh-CN">
		<head>
		<meta charset="utf-8" />
		<title>正在跳转中</title>
		<meta http-equiv="refresh" content="{$time};URL={$url}" />
		<link rel="stylesheet" type="text/css" href="style/remind.css" />
		</head>
		<body>
		<div class="notice"><span class="pic {$pic}"></span> {$message} {$time}秒后自动跳转！ 点击此处<a href="{$url}">跳转</a></div>
		</body>
	</html>
A;
echo $html;
exit();
}
//验证前台用户是否登录
function is_login($link) {
	if(isset($_COOKIE['sfc']['name']) && isset($_COOKIE['sfc']['pw'])) {
		$query = "SELECT * FROM `sfc_member` WHERE name='{$_COOKIE['sfc']['name']}' and sha1(pw)='{$_COOKIE['sfc']['pw']}'";
		$result = execute($link, $query);
		if(mysqli_num_rows($result)==1) {
			$data = mysqli_fetch_assoc($result);
			return $data['id'];
		}else{
			return false;
		}
	}else{
		return false;
	}
}

//判断当前登录用户是否有编辑或删除帖子的功能
function check_user($member_id, $content_member_id,$is_manage_login) {
	if($member_id == $content_member_id || $is_manage_login) {
		return true;
	}else{
		return false;
	}
}
//验证后台管理员登录
function is_manage_login($link) {
	if(isset($_SESSION['manage']['name']) && isset($_SESSION['manage']['pw'])) {
		$query = "SELECT * FROM `sfc_manage` WHERE name='{$_SESSION['manage']['name']}' and sha1(pw)='{$_SESSION['manage']['pw']}'";
		$result = execute($link, $query);
		if(mysqli_num_rows($result) == 1) {
			$data = mysqli_fetch_assoc($result);
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}
?>