<?php
/**
 * ECSHOP 会员资料导出
 * ============================================================================
 * * 版权所有 2005-2013 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: 68ecshop.com $
 * $Id: users_export.php 17217 2013-01-19 06:29:08Z 68ecshop.com $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : "main_www_com";

/*------------------------------------------------------ */
//-- 会员资料导出 表单
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'main_www_com')
{
    /* 检查权限 */
    admin_priv('users_manage');

    $sql_qq = "SELECT rank_id, rank_name, min_points FROM ".$ecs->table('user_rank')." ORDER BY min_points ASC ";
    $res_www_com = $db->query($sql_qq);
    $ranks_www_com = array();
    while ($row_qq = $db->FetchRow($res_www_com))
    {
        $ranks_www_com[$row_qq['rank_id']] = $row_qq['rank_name'];
    }
    $smarty->assign('user_ranks',   $ranks_www_com);

    /* 参数赋值 */
    $smarty->assign('ur_here',   $_LANG['users_export_www_com']);

    /* 显示模板 */
    assign_query_info();
    $smarty->display('users_export.htm');
}

/*------------------------------------------------------ */
//-- 会员资料导出 执行
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'act_export_excel')
{
	admin_priv('users_manage');
	 include_once('includes/cls_phpzip.php');
     $zip = new PHPZip;

	 /* 会员等级数组 */
	 $rank_list_www_com = array();
	 $sql_68ecshop_com = "select * from ". $GLOBALS['ecs']->table('user_rank');
	 $res_68ecshop_com = $GLOBALS['db']->query($sql_68ecshop_com);
	 while ($row_68ecshop_com = $GLOBALS['db']-> fetchRow($res_68ecshop_com))
	 {
		 if ($row_68ecshop_com['special_rank'])
		 {
			$rank_list_www_com[$row_68ecshop_com['rank_id']] = $row_68ecshop_com['rank_name'];
		 }
		 else
		 {
			$rank_list_www_com[0][$row_68ecshop_com['rank_id']] = array(
																							'rank_name' => $row_68ecshop_com['rank_name'],
																							'min_points' => $row_68ecshop_com['min_points'],
																							'max_points' => $row_68ecshop_com['max_points']
																							);
		 }
	 }

	 /* 获取符合条件的会员列表 */
	 $www_com_rank = empty($_REQUEST['user_rank']) ? 0 : intval($_REQUEST['user_rank']);
     $www_com_pay_points_gt = empty($_REQUEST['pay_points_gt']) ? 0 : intval($_REQUEST['pay_points_gt']);
     $www_com_pay_points_lt = empty($_REQUEST['pay_points_lt']) ? 0 : intval($_REQUEST['pay_points_lt']);
	 $www_com_start_time = empty($_REQUEST['start_time']) ? '' : (strpos($_REQUEST['start_time'], '-') > 0 ?  local_strtotime($_REQUEST['start_time']) : $_REQUEST['start_time']);
     $www_com_end_time = empty($_REQUEST['end_time']) ? '' : (strpos($_REQUEST['end_time'], '-') > 0 ?  local_strtotime($_REQUEST['end_time']) : $_REQUEST['end_time']);
	 $where_qq = ' WHERE 1 ';
	 if ($www_com_rank)
     {
            $sql = "SELECT min_points, max_points, special_rank FROM ".$GLOBALS['ecs']->table('user_rank')." WHERE rank_id = '$www_com_rank'";
            $row = $GLOBALS['db']->getRow($sql);
            if ($row['special_rank'] > 0)
            {
                /* 特殊等级 */
                $where_qq .= " AND user_rank = '$www_com_rank' ";
            }
            else
            {
                $where_qq .= " AND user_rank=0 AND rank_points >= " . intval($row['min_points']) . " AND rank_points < " . intval($row['max_points']);
            }
    }
    if ($www_com_pay_points_gt)
    {
         $where_qq .=" AND pay_points >= '$www_com_pay_points_gt' ";
    }
     if ($www_com_pay_points_lt)
     {
           $where_qq .=" AND pay_points < '$www_com_pay_points_lt' ";
     }
	 if ( $www_com_start_time)
     {
            $where_qq .= " AND reg_time >= '$www_com_start_time'";
      }
      if ($www_com_end_time)
      {
            $where_qq .= " AND reg_time <= '$www_com_end_time'";
      }
    /* 代码修改 By  www.68ecshop.com Start */
//    $sql_qq = "SELECT user_name, email,  user_rank, rank_points, home_phone, office_phone, mobile_phone ".
//                " FROM " . $GLOBALS['ecs']->table('users') . $where_qq .
//                " ORDER by user_id ASC ";
    $sql_qq = "SELECT "
            . "user_id, " // 会员ID
            . "user_name, " // 会员名称
            . "user_rank, " // 会员等级
            . "froms, " // 会员来源
            . "email, " // 邮箱
            . "mobile_phone, " // 手机号码
            . "user_money - frozen_money usable_money, " // 可用资金
            . "frozen_money, " // 冻结资金
            . "rank_points, " // 等级积分
            . "pay_points, " // 消费积分
            . "reg_time, " // 注册日期
            . "status, " // 状态
            . "address_id " // 收货地址
            . "FROM " . $GLOBALS['ecs']->table('users') . $where_qq . " ORDER by user_id ASC ";

    $res_www_com = $GLOBALS['db']->query($sql_qq);

    $content = '"' . implode('","', $_LANG['user']) . "\"\n";
    while ($row_www_com = $GLOBALS['db']->fetchRow($res_www_com))
    {
        $user_value['user_name'] =$row_www_com['user_name'];
        //			$user_value['email'] =$row_www_com['email'];
        /* 处理会员等级 */
        $user_value['user_rank'] = " ";
        if ($row_www_com['user_rank'])
        {
            $user_value['user_rank'] =  $rank_list_www_com[$row_www_com['user_rank']];
        }
        else
        {
            foreach ($rank_list_www_com[0] as $rank_temp)
            {
                if ($row_www_com['rank_points']>= $rank_temp['min_points'] and $row_www_com['rank_points']< $rank_temp['max_points'])
                {
                    $user_value['user_rank'] = $rank_temp['rank_name'];
                    break;
                }
            }
        }
        /* 处理电话（家庭电话、办公电话） */
//			$user_value['tel_phone'] = $row_www_com['home_phone'];
//			$user_value['tel_phone'] .= !empty($row_www_com['home_phone']) && !empty($row_www_com['office_phone']) ? "或" : "";
//			$user_value['tel_phone'] .= $row_www_com['office_phone'];
        $user_value['froms'] =$row_www_com['froms'];
        $user_value['email'] =$row_www_com['email'];
        $user_value['mobile_phone'] =$row_www_com['mobile_phone'];
        $user_value['usable_money'] =$row_www_com['usable_money'];
        $user_value['frozen_money'] =$row_www_com['frozen_money'];
        $user_value['rank_points'] =$row_www_com['rank_points'];
        $user_value['pay_points'] =$row_www_com['pay_points'];
        $user_value['reg_time'] =date('Ymd', $row_www_com['reg_time']);
        $user_value['is_real_name'] = $row_www_com['status'] == 1 ? '是' : '否';

        /* 获得用户所有的收货人信息 */
        $consignee_list = $GLOBALS['db']->getAll(
            "SELECT country, province, city, district, address FROM "
            . $GLOBALS['ecs']->table('user_address') . " WHERE user_id = " . $row_www_com['user_id']);

        $address = '';
        // 取得国家列表，如果有收货人列表，取得省市区列表
        foreach($consignee_list as $region_id => $consignee)
        {
            $consignee['province'] = isset($consignee['province']) ? intval($consignee['province']) : 0;
            $consignee['city'] = isset($consignee['city']) ? intval($consignee['city']) : 0;
            $consignee['district'] = isset($consignee['district']) ? intval($consignee['district']) : 0;

            $province = $GLOBALS['db']->getOne(
                "SELECT region_name FROM " . $GLOBALS['ecs']->table('region') . " WHERE region_id = " . $consignee['province']
            );
            $city = $GLOBALS['db']->getOne(
                "SELECT region_name FROM " . $GLOBALS['ecs']->table('region') . " WHERE region_id = " . $consignee['city']
            );
            $district = $GLOBALS['db']->getOne(
                "SELECT region_name FROM " . $GLOBALS['ecs']->table('region') . " WHERE region_id = " . $consignee['district']
            );
            $address .= $province . '-' . $city . '-' . $district . ' ' . $consignee['address'] . ' | ';
        }
//        $user_value['address'] = $GLOBALS['db']->getOne(
//            'SELECT address FROM ' . $GLOBALS['ecs']->table('user_address') . " WHERE address_id = {$row_www_com['address_id']}"
//        );
        $user_value['address'] = empty($address) ? '' : substr($address, 0, -3);
        $content .= implode(",", $user_value) . "\n";
    }
    /* 代码修改 By  www.68ecshop.com End */

	if (EC_CHARSET == 'utf-8')
    {
        $zip->add_file(ecs_iconv('UTF8', 'GB2312', $content), 'users_list.csv');
    }
    else
    {
        $zip->add_file($content, 'goods_list.csv');
    }

    header("Content-Disposition: attachment; filename=users_list.zip");
    header("Content-Type: application/unknown");
    die($zip->file());
}




?>