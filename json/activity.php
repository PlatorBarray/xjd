<?php


define('IN_ECS', true);

require('../includes/init.php');
require('../includes/lib_order.php');
include('../includes/cls_json.php');
$json   = new JSON;
/* 载入语言文件 */
require_once('../languages/zh_cn/shopping_flow.php');
require_once('../languages/zh_cn/user.php');

$smarty->template_dir = ROOT_PATH . 'json/tpl';//app部分模板所在位置

/*------------------------------------------------------ */
//-- PROCESSOR
/*------------------------------------------------------ */

$result = array('error'=>0,'result'=>'');

$page = (isset($_REQUEST['page'])) ? intval($_REQUEST['page']) : 0;
$num = 1;

assign_template();
assign_dynamic('activity');

// 数据准备

    /* 取得用户等级 */
    $user_rank_list = array();
    $user_rank_list[0] = $_LANG['not_user'];
    $sql = "SELECT rank_id, rank_name FROM " . $ecs->table('user_rank');
    $res = $db->query($sql);
    while ($row = $db->fetchRow($res))
    {
        $user_rank_list[$row['rank_id']] = $row['rank_name'];
    }

// 开始工作

//$sql = "SELECT * FROM " . $ecs->table('favourable_activity'). " ORDER BY `sort_order` ASC,`end_time` DESC";
$nowtime = time();
$sql = "SELECT fa.* FROM " . $ecs->table('favourable_activity'). " AS fa ".
		"WHERE  fa.start_time<=".$nowtime." AND fa.end_time>=".$nowtime.
		" ORDER BY fa.`sort_order` ASC,fa.`end_time` DESC LIMIT ".$page*$num.",".$num;
$res = $db->query($sql);

$list = array();
while ($row = $db->fetchRow($res))
{
    $row['start_time']  = local_date('Y-m-d H:i', $row['start_time']);
    $row['end_time']    = local_date('Y-m-d H:i', $row['end_time']);

    //享受优惠会员等级
    $user_rank = explode(',', $row['user_rank']);
    $row['user_rank'] = array();
    foreach($user_rank as $val)
    {
        if (isset($user_rank_list[$val]))
        {
            $row['user_rank'][] = $user_rank_list[$val];
        }
    }

    //优惠范围类型、内容
    if ($row['act_range'] != FAR_ALL && !empty($row['act_range_ext']))
    {
        if ($row['act_range'] == FAR_CATEGORY)
        {
            $row['act_range'] = $_LANG['far_category'];
            $row['program'] = 'category.php?id=';
            $sql = "SELECT cat_id AS id, cat_name AS name FROM " . $ecs->table('category') .
                " WHERE cat_id " . db_create_in($row['act_range_ext']);
        }
        elseif ($row['act_range'] == FAR_BRAND)
        {
            $row['act_range'] = $_LANG['far_brand'];
            $row['program'] = 'brand.php?id=';
            $sql = "SELECT brand_id AS id, brand_name AS name FROM " . $ecs->table('brand') .
                " WHERE brand_id " . db_create_in($row['act_range_ext']);
        }
        else
        {
            $row['act_range'] = $_LANG['far_goods'];
            $row['program'] = 'goods.php?id=';
            $sql = "SELECT goods_id AS id, goods_name AS name FROM " . $ecs->table('goods') .
                " WHERE goods_id " . db_create_in($row['act_range_ext']);
        }
        $act_range_ext = $db->getAll($sql);
        $row['act_range_ext'] = $act_range_ext;
    }
    else
    {
        $row['act_range'] = $_LANG['far_all'];
    }

    //优惠方式
    $row['act_type_num'] = $row['act_type'];
    switch($row['act_type'])
    {
        case 0:
            $row['act_type'] = $_LANG['fat_goods'];
            $row['gift'] = unserialize($row['gift']);
            if(is_array($row['gift']))
            {
                foreach($row['gift'] as $k=>$v)
                {
                    $row['gift'][$k]['thumb'] = get_image_path($v['id'], $db->getOne("SELECT goods_thumb FROM " . $ecs->table('goods') . " WHERE goods_id = '" . $v['id'] . "'"), true);
                }
            }
            break;
        case 1:
            $row['act_type'] = $_LANG['fat_price'];
            $row['act_type_ext'] .= $_LANG['unit_yuan'];
            $row['gift'] = array();
            break;
        case 2:
            $row['act_type'] = $_LANG['fat_discount'];
            $row['act_type_ext'] .= "%";
            $row['gift'] = array();
            break;
    }
    
    if($row['supplier_id'] > 0){
	    $sql = "select code,value from " . $ecs->table('supplier_shop_config'). 
	    		" where supplier_id=".$row['supplier_id'].
	    		" AND code in('shop_name','shop_logo')";
	    $r = $db->getAll($sql);
	    foreach($r as $k=>$v){
	    	$row[$v['code']] = $v['value'];
	    }
    }else{
    	$row['shop_logo'] = './images/ziying.jpg';
    }
    

    $list[] = $row;
}

$smarty->assign('list',             $list);

$smarty->assign('lang',             $_LANG);

$result['result'] =  $smarty->fetch('activity_app.lbi');

die($json->encode($result));

