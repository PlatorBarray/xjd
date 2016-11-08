<?php

/**
 * ECSHOP 管理中心文章处理程序文件
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: article.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);
require (dirname(__FILE__) . '/includes/init.php');

$goods_id = intval($_REQUEST['goods_id']);
$goods = $db->GetRow("SELECT *  FROM " .$ecs->table('goods'). " WHERE goods_id='$goods_id'");
$smarty->assign('goods_id',       $goods_id);
$smarty->assign('goods',          $goods);

if ($_REQUEST['act'] == 'list')
{
    $smarty->assign('ur_here',     '商品标签');
	$smarty->assign('action_link',  array('text' => '添加标签', 'href' => "goods_tag.php?act=add&goods_id=$goods_id"));
    $smarty->assign('full_page',    1);
	
	
    $item_list = $db->getAll("SELECT * FROM ".$ecs->table('goods_tag')." WHERE goods_id = '$goods_id'");
    $smarty->assign('item_list',    $item_list);
	
    assign_query_info();
    $smarty->display('goods_tag_list.htm');
}

/*------------------------------------------------------ */
//-- 排序、分页、查询
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $item_list = $db->getAll("SELECT * FROM ".$ecs->table('goods_tag')." WHERE goods_id = '$goods_id'");
    $smarty->assign('item_list',    $item_list);

    make_json_result($smarty->fetch('goods_tag_list.htm'));
}


/*------------------------------------------------------ */
//-- 添加关键词
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'add')
{
    $smarty->assign('ur_here',     '添加标签');
    $smarty->assign('action_link',  array('text' => '返回', 'href' => 'goods_tag.php?act=list&goods_id='.$goods_id));
	$smarty->assign('form_action', 'insert');

    assign_query_info();
    $smarty->display('goods_tag_info.htm');
}
elseif ($_REQUEST['act'] == 'insert')
{
	$tag_name = trim($_POST['tag_name']);
	
	$is = $db->GetOne("SELECT tag_id FROM " .$ecs->table('goods_tag'). " WHERE goods_id = '$goods_id' AND tag_name='$tag_name'");
	if ($is > 0)
	{
		sys_msg("标签名称已经存在，请修改！", 1, array(), false);	
	}
	
	$db->query("INSERT INTO ".$ecs->table('goods_tag')." (tag_name, goods_id, state) VALUES ('$tag_name', '$goods_id', 1)");
	
    $link[0]['text'] = '返回列表';
    $link[0]['href'] = "goods_tag.php?act=list&goods_id=$goods_id";
    sys_msg('操作成功',0, $link);
}

/*------------------------------------------------------ */
//-- 编辑关键词
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit')
{
    $info = $db->GetRow("SELECT *  FROM " .$ecs->table('goods_tag'). " WHERE tag_id='$_REQUEST[id]'");

    $smarty->assign('ur_here',     '编辑标签');
    $smarty->assign('action_link',  array('text' => '返回', 'href' => 'goods_tag.php?act=list&goods_id='.$goods_id));
    $smarty->assign('info',       $info);
    $smarty->assign('form_action', 'updata');

    assign_query_info();
    $smarty->display('goods_tag_info.htm');
}
elseif ($_REQUEST['act'] == 'updata')
{
	$tag_name = trim($_POST['tag_name']);
	
	$is = $db->GetOne("SELECT tag_id FROM " .$ecs->table('goods_tag'). " WHERE goods_id = '$goods_id' AND tag_name='$tag_name' AND tag_id != '$_POST[id]'");
	if ($is > 0)
	{
		sys_msg("标签名称已经存在，请修改！", 1, array(), false);	
	}
	
	$db->query("UPDATE ".$ecs->table('goods_tag')." SET tag_name = '$tag_name' WHERE tag_id = '$_POST[id]'");
	
    $link[0]['text'] = '返回列表';
    $link[0]['href'] = "goods_tag.php?act=list&goods_id=$goods_id";
    sys_msg('操作成功',0, $link);
}

/*------------------------------------------------------ */
//-- 删除关键词
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    $id = intval($_GET['id']);
	if($goods_id == 0){
		$goods_id = $db->GetOne("SELECT goods_id  FROM " .$ecs->table('goods_tag'). " WHERE tag_id='$id'");
	}
	$db->query("delete from " .$ecs->table('goods_tag'). " where tag_id = '$id'");
	$url = 'goods_tag.php?act=query&goods_id='.$goods_id;
    ecs_header("Location: $url\n");
    exit;
}

/*------------------------------------------------------ */
//-- 编辑排序序号
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_displayorder')
{
    $id   = intval($_POST['id']);
    $val  = intval($_POST['val']);
	data_update("goods_tag", array('displayorder'=>$val), $id, 'tag_id');
    make_json_result($val);
}
?>