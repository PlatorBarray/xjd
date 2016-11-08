<?php

/**
 * ECSHOP 管理中心商店设置
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: shop_config.php 17217 2011-01-19 06:29:08Z liubo $
 */

define('IN_ECS', true);

/* 代码 */
require(dirname(__FILE__) . '/includes/init.php');
include_once(ROOT_PATH . '/includes/cls_image.php');
$image = new cls_image($_CFG['bgcolor']);

if($GLOBALS['_CFG']['certificate_id']  == '')
{
    $certi_id='error';
}
else
{
    $certi_id=$GLOBALS['_CFG']['certificate_id'];
}

$sess_id = $GLOBALS['sess']->get_session_id();

$auth = mktime();
$ac = md5($certi_id.'SHOPEX_SMS'.$auth);
$url = 'http://service.shopex.cn/sms/index.php?certificate_id='.$certi_id.'&sess_id='.$sess_id.'&auth='.$auth.'&ac='.$ac;

/*------------------------------------------------------ */
//-- 列表编辑 ?act=list_edit
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list_edit')
{
	//include_once(ROOT_PATH . 'includes/fckeditor/fckeditor.php'); // 包含 html editor 类文件
	
	admin_priv('shop_header');
	
	$group_list = get_shop_header();
	$row=$db->getRow("select * from" . $ecs->table('supplier_shop_config') . " WHERE code = 'shop_header_text' AND supplier_id=".$_SESSION['supplier_id']);
	$picture=trim($row['value']);
	//$picture=$_REQUEST['picture'];
	//echo "<pre>";
	//print_r($group_list);
    /* 创建 html editor */
	create_html_editor('shop_header_text', htmlspecialchars($group_list['shop_header_text']));  
    assign_query_info();
	$smarty->assign('picture',    $picture);
	$smarty->assign('color',    $group_list['shop_header_color']);
	$smarty->assign('ur_here','店铺头部自定义');
    $smarty->display('shop_header.htm');
}

/*------------------------------------------------------ */
//-- 提交   ?act=post
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'post')
{
	
 
    $sql = "UPDATE " . $ecs->table('supplier_shop_config') . " SET value = '$_POST[shop_header_color]' WHERE code = 'shop_header_color' AND supplier_id=".$_SESSION['supplier_id'];
    $db->query($sql);
	if($_FILES['goods_img']['size']!=0){
		$original_img   = $image->upload_image($_FILES['goods_img']); // 原始图片
		$sql = "UPDATE " . $ecs->table('supplier_shop_config') . " SET value = ' $original_img ' WHERE code = 'shop_header_text' AND supplier_id=".$_SESSION['supplier_id'];
		$db->query($sql);
    }
    $links[] = array('text' => '返回头部自定义', 'href' => 'shop_header.php?act=list_edit');
    sys_msg('设置成功！', 0, $links);


    /* 清除缓存 */
    clear_all_files();

 
}

/*------------------------------------------------------ */
//-- 发送测试邮件
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'send_test_email')
{
    /* 检查权限 */
    check_authz_json('shop_config');

    /* 取得参数 */
    $email          = trim($_POST['email']);

    /* 更新配置 */
    $_CFG['mail_service'] = intval($_POST['mail_service']);
    $_CFG['smtp_host']    = trim($_POST['smtp_host']);
    $_CFG['smtp_port']    = trim($_POST['smtp_port']);
    $_CFG['smtp_user']    = json_str_iconv(trim($_POST['smtp_user']));
    $_CFG['smtp_pass']    = trim($_POST['smtp_pass']);
    $_CFG['smtp_mail']    = trim($_POST['reply_email']);
    $_CFG['mail_charset'] = trim($_POST['mail_charset']);

    if (send_mail('', $email, $_LANG['test_mail_title'], $_LANG['cfg_name']['email_content'], 0))
    {
        make_json_result('', $_LANG['sendemail_success'] . $email);
    }
    else
    {
        make_json_error(join("\n", $err->_message));
    }
}

/*------------------------------------------------------ */
//-- 删除上传文件
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'del')
{
    /* 检查权限 */
    //check_authz_json('shop_config');

    /* 取得参数 */
    $code          = trim($_GET['code']);

    $filename = $_CFG[$code];

    //删除文件
    @unlink($filename);

    //更新设置
    update_configure($code, '');

    /* 记录日志 */
    //admin_log('', 'edit', 'shop_config');

    /* 清除缓存 */
    clear_all_files();

    sys_msg($_LANG['save_success'], 0);

}

/**
 * 设置系统设置
 *
 * @param   string  $key
 * @param   string  $val
 *
 * @return  boolean
 */
function update_configure($key, $val='')
{
    if (!empty($key))
    {
        $sql = "UPDATE " . $GLOBALS['ecs']->table('supplier_shop_config') . " SET value='$val' WHERE code='$key' AND supplier_id=".$_SESSION['supplier_id'];

        return $GLOBALS['db']->query($sql);
    }

    return true;
}



/**
 * 获得设置信息
 *
 * @param   array   $groups     需要获得的设置组
 * @param   array   $excludes   不需要获得的设置组
 *
 * @return  array
 */
function get_shop_header()
{
    global $db, $ecs, $_LANG;
    
    create_shop_settiongs();

    /* 取出全部数据：分组和变量 */
    $sql = "SELECT * FROM " . $ecs->table('supplier_shop_config') .
            " WHERE supplier_id=".$_SESSION['supplier_id']." AND code in('shop_header_color','shop_header_text')";
    $item_list = $db->getAll($sql);
    //return $item_list;
    $group_list = array();
    foreach ($item_list AS $key => $item)
    {
    	if(in_array($item['code'],array('shop_header_color','shop_header_text')))
    	{
    		$group_list[$item['code']] = $item['value'];
    	}
    }

    return $group_list;
}

?>