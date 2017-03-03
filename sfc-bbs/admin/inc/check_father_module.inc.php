<?php
	/**对提交的数据进行验证
	 *	@function is_numeric 判断是否是数字
	 *	@function mb_strlen（str,encoding）  获取字符串的长度 
	 * 			str 要检查长度的字符串
	 * 			encoding 参数的字符编码,如果省略，则使用内部字符编码
	 */
	if(empty($_POST['module_name'])) {
		skip(3, 'father_module_add.php', 'error', '板块名称不得为空！'); 
	}
	if(mb_strlen($_POST['module_name']) > 66){
		skip(3, 'father_module_add.php', 'error', '板块名称不得大于66个字符！');
	}
	if(!is_numeric($_POST['sort'])) {
		skip(3, 'father_module_add.php', 'error', '只能填写数字！'); 
	}
	//这里调用escape方法目的是为了对输入的内容进行转义，因为内容中可能带有单引号或者双引号
	$_POST = escape($link, $_POST);
	//判断提交的数据是否重复，若重复则跳转 
	switch ($check_flag) {
		case 'add':
			$query = "SELECT * FROM `sfc_father_module` WHERE module_name='{$_POST['module_name']}'";
			break;
		case 'update':
			$query = "SELECT * FROM `sfc_father_module` WHERE module_name='{$_POST['module_name']}' AND id!={$_GET['id']}";
			break;
		default:
			skip(3, 'father_module.php', 'error', '$check_flag参数错误！'); 			
	}	
	$result = execute($link, $query);
	if(mysqli_num_rows($result)) {
		skip(3, 'father_module_add.php', 'error', '这个版块名称已经有了，请重新填写！'); 
	}

?>