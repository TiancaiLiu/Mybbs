<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
$link = connect();
//判断管理员是否登录
$is_manage_login = is_manage_login($link);
//前台用户登录
$member_id=is_login($link);
if(!$member_id && !$is_manage_login){
	skip('3', 'login.php', 'error', '您没有登录!');
}
//判断帖子id合法性
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	skip('3', 'index.php', 'error', '帖子id参数不合法！');
}
$query = "SELECT member_id FROM `sfc_content` WHERE id={$_GET['id']}";
$result_content = execute($link, $query);
if(mysqli_num_rows($result_content)==1) {
	$data_content = mysqli_fetch_assoc($result_content);
	if(check_user($member_id, $data_content['member_id'], $is_manage_login)) {
		$query = "delete from `sfc_content` where id={$_GET['id']}";
		execute($link, $query);
		if(isset($_GET['return_url'])) {
				$return_url = $_GET['return_url'];
			}else{
				$return_url = "member.php?id={$member_id}";
			}
		if(mysqli_affected_rows($link) == 1){
			skip('3', $return_url, 'ok', '删除成功！');
		}else{
			skip('3', $return_url, 'error', '对不起，删除失败！');
		}
	}else{
		skip('3', 'index.php', 'error', '这篇帖子不属于您，您没有权限！');
	}
}else{
	skip('3', 'index.php', 'error', '帖子不存在！');
}

?>