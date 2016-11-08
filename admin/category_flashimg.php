<?php

/**
 * ECSHOP 商品分类轮播图片管理程序
 * ============================================================================
 * 版权所有 2005-2010 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liuhui $
 * $Id: category.php 17063 2010-03-25 06:35:46Z liuhui $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
include_once(ROOT_PATH . 'includes/cls_image.php');
$image = new cls_image($_CFG['bgcolor']);

$exc = new exchange($ecs->table("category"), $db, 'cat_id', 'cat_name');

/* act操作项的初始化 */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

$cat_id=$_REQUEST['cat_id'] ? intval($_REQUEST['cat_id']) : 0;
$smarty->assign('cat_id',    $cat_id);
$cat_name=$db->getOne("select cat_name from " .$ecs->table("category"). " where cat_id=" . $cat_id);

/*------------------------------------------------------ */
//-- 商品分类轮播图片列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* 获取轮播图片列表 */
    $flashimg_list = cat_flashimg_list($cat_id);

    /* 模板赋值 */
    $smarty->assign('ur_here',      '【' . $cat_name.'】的轮播图片');
    $smarty->assign('action_link',  array('href' => 'category_flashimg.php?act=add&cat_id='.$cat_id, 'text' => '添加轮播图片'));
    $smarty->assign('full_page',    1);

    $smarty->assign('flashimg_list',     $flashimg_list);

    /* 列表页面 */
    $smarty->display('category_flashimg_list.htm');
}
if ($_REQUEST['act'] == 'adlist')
{
    include_once  'includes/upload.php';
    if(!empty($_POST))
    {
        $getid=$_GET['id'];
        $cat_id=$_POST['cat_id'];
        unset($_POST);
        $upload=new upload();
        $filepath=$upload->upload_file();
//        print_r($filepath);die;
        $serialize=array('img_url'=>$filepath['filepath'],'imgname'=>$filepath['file']);
        if(empty($getid))
        {
            $insql="insert into ".$ecs->table('category_img')."(`cat_id`,`img_url`) values('".$cat_id."','".$filepath['filepath']."')";
        }else
        {
            $insql="update ".$ecs->table('category_img')."set img_url='".$filepath['filepath']."' where id=$getid";
        }
        if($GLOBALS['db']->query($insql))
        {
            echo '<script>location.href="category_flashimg.php?act=adlist&cat_id='.$cat_id.'"</script>';
            exit();
        }else
        {
            echo '<script>alert("添加失败");location.href="history.go(-1)"</script>';
            exit();
        }
    }else
    {
        $cate_id=$_GET['cat_id'];
        $sql='select * from  '.$ecs->table('category_img') .' where cat_id='.$_GET['cat_id'];
        $catdata=$GLOBALS['db']->getAll($sql);
        /* 模板赋值 */
        $smarty->assign('ur_here',      '【' . $cat_name.'】的广告图片');
        $smarty->assign('action_link',  array('href' => 'category_flashimg.php?act=zadd&cat_id='.$cat_id, 'text' => '添加广告图片'));
        $smarty->assign('full_page',    1);

        $smarty->assign('flashimg_list',     $flashimg_list);
        $smarty->assign('ad_img',     $catdata);
        $smarty->assign('cate_id',     $cate_id);

        /* 列表页面 */
        $smarty->display('category_flashimg_ad_list.htm');
    }
}
if ($_REQUEST['act'] == 'adremove')
{
    $id=$_GET['id'];
    $cat_id=$_GET['cat_id'];
    if(!empty($cat_id))
    {
       $delsql='delete from '.$ecs->table('category_img').' where id='.$id;
        if($GLOBALS['db']->query($delsql))
        {
            echo '<script>location.href="category_flashimg.php?act=adlist&cat_id='.$cat_id.'"</script>';
            exit();
        }else
        {
            echo '<script>alert("删除失败");history.go(-1)</script>';
            exit();
        }
    }else
    {
        echo '<script>alert("删除失败");history.go(-1)</script>';
        exit();
    }
}
if ($_REQUEST['act'] == 'adedit')
{
    $id=$_GET['id'];
    if(empty($id)) $id=0;
    $cat_id=$_GET['cat_id'];
    if(!empty($_POST))
    {

    }else
    {
        $sql='select * from  '.$ecs->table('category_img') .' where id='.$id;
        $getcat=$GLOBALS['db']->getRow($sql);
        $smarty->assign('img_info',$getcat);
        $smarty->display('category_flashimg_edit_info.htm');
    }
}
/*------------------------------------------------------ */
//-- 添加商品分类轮播图片
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'add')
{
    /* 权限检查 */
    admin_priv('cat_manage');

    /* 模板赋值 */
    $smarty->assign('ur_here',      '给【'. $cat_name .'】添加轮播图片');
    $smarty->assign('action_link',  array('href' => 'category_flashimg.php?act=list&cat_id='.$cat_id, 'text' => '【'.$cat_name.'】轮播图片列表'));

    $smarty->assign('form_act',     'insert');
    $smarty->assign('cat_info',     array('is_show' => 1));

    /* 显示页面 */
    $smarty->display('category_flashimg_info.htm');
}
if ($_REQUEST['act'] == 'zadd')
{
    /* 权限检查 */
    admin_priv('cat_manage');

    /* 模板赋值 */
    $smarty->assign('ur_here',      '给【'. $cat_name .'】添加栏目图片');
    $smarty->assign('action_link',  array('href' => 'category_flashimg.php?act=adlist&cat_id='.$cat_id, 'text' => '【'.$cat_name.'】添加栏目图片'));

    $smarty->assign('form_act',     'insert');
    $smarty->assign('cat_info',     array('is_show' => 1));

    /* 显示页面 */
    $smarty->display('category_flashimg_ad_info.htm');
}
/*------------------------------------------------------ */
//-- 商品分类轮播图片添加时的处理
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'insert')
{
    /* 权限检查 */
    admin_priv('cat_manage');

    /* 初始化变量 */
    $flashimg['cat_id']       = !empty($_POST['cat_id']) ? intval($_POST['cat_id'])     : 0;
    $flashimg['sort_order']   = !empty($_POST['sort_order'])   ? intval($_POST['sort_order']) : 0;
    $flashimg['href_url'] = !empty($_POST['href_url']) ? trim($_POST['href_url']) : '';
	 /*处理图片*/
    $flashimg['img_url']  = basename($image->upload_image($_FILES['img_url'],'catflashimg'));
	 /*处理URL*/
    $flashimg['href_url']= sanitize_url( $flashimg['href_url'] );
	$flashimg['img_title'] = !empty($_POST['img_title']) ? trim($_POST['img_title']) : '';
	$flashimg['img_desc'] = !empty($_POST['img_desc']) ? trim($_POST['img_desc']) : '';

    /* 入库的操作 */
    if ($db->autoExecute($ecs->table('cat_flashimg'), $flashimg) !== false)
    {
        clear_cache_files();    // 清除缓存

        /*添加链接*/
        $link[0]['text'] = "继续添加";
        $link[0]['href'] = 'category_flashimg.php?act=add&cat_id='.$cat_id;

        $link[1]['text'] = "返回轮播图片列表";
        $link[1]['href'] = 'category_flashimg.php?act=list&cat_id='.$cat_id;

        sys_msg("添加成功", 0, $link);
    }
 }

/*------------------------------------------------------ */
//-- 编辑商品分类轮播图片
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'edit')
{
    admin_priv('cat_manage');   // 权限检查

	$img_id=!empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
    $img_info = get_flashimg_info($img_id);  // 查询该轮播图片

    /* 模板赋值 */

    $smarty->assign('ur_here',      '修改【'. $cat_name .'】的轮播图片');
    $smarty->assign('action_link',  array('href' => 'category_flashimg.php?act=list&cat_id='.$cat_id, 'text' => '【'.$cat_name.'】轮播图片列表'));

    $smarty->assign('img_info',    $img_info);
    $smarty->assign('form_act',    'update');

    /* 显示页面 */
    $smarty->display('category_flashimg_info.htm');
}



/*------------------------------------------------------ */
//-- 编辑商品分类轮播图片
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'update')
{
    /* 权限检查 */
    admin_priv('cat_manage');

    /* 初始化变量 */
    $img_id              = !empty($_POST['img_id'])       ? intval($_POST['img_id'])     : 0;
	$img_info = get_flashimg_info($img_id);
    $img['sort_order']   = !empty($_POST['sort_order'])   ? intval($_POST['sort_order']) : 0;
    $img['href_url'] = !empty($_POST['href_url']) ? trim($_POST['href_url']) : '';
	$img['img_title'] = !empty($_POST['img_title']) ? trim($_POST['img_title']) : '';
	$img['img_desc'] = !empty($_POST['img_desc']) ? trim($_POST['img_desc']) : '';

	if ($_FILES['img_url']['tmp_name'] != '' && $_FILES['img_url']['tmp_name'] != 'none')
	{
		$img['img_url'] = basename($image->upload_image($_FILES['img_url'],'catflashimg'));

		/* 删除旧图片 */
		if (!empty($img_info['img_url']))
		{
			@unlink(ROOT_PATH . DATA_DIR . '/catflashimg/' .$img_info['img_url']);
		}
	}

    if ($db->autoExecute($ecs->table('cat_flashimg'), $img, 'UPDATE', "img_id='$img_id'"))
    {
        /* 更新分类信息成功 */
        clear_cache_files(); // 清除缓存

        /* 提示信息 */
        $link[] = array('text' => '返回上一页', 'href' => 'category_flashimg.php?act=list&cat_id='.$img_info['cat_id']);
        sys_msg('轮播图片修改成功', 0, $link);
    }
}



/*------------------------------------------------------ */
//-- 删除商品分类轮播图片
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'remove')
{
   /* 权限检查 */
    admin_priv('cat_manage');

	$img_id=!empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
	$sql="select img_url from " .$ecs->table("cat_flashimg"). " where img_id='$img_id' ";
	$img_url=$db->getOne($sql);
	if (!empty($img_url))
    {
        @unlink(ROOT_PATH . DATA_DIR . '/catflashimg/' .$img_url);
    }

     /* 删除分类 */
     $sql = 'DELETE FROM ' .$ecs->table('cat_flashimg'). " WHERE img_id = '$img_id'";
     if ($db->query($sql))
     {
          clear_cache_files();
    }

    $url = 'category_flashimg.php?act=list&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);
    ecs_header("Location: $url\n");
    exit;
}

/*------------------------------------------------------ */
//-- PRIVATE FUNCTIONS
/*------------------------------------------------------ */


/**
 * 获得某个轮播图片的所有信息
 *
 * @param   integer     $img_id     指定的图片ID
 *
 * @return  array
 */
function get_flashimg_info($img_id)
{
    $sql = "SELECT * FROM " .$GLOBALS['ecs']->table('cat_flashimg'). " WHERE img_id='$img_id' LIMIT 1";
    return $GLOBALS['db']->getRow($sql);
}

/**
 * 添加商品分类
 *
 * @param   integer $cat_id
 * @param   array   $args
 *
 * @return  mix
 */
function cat_update($cat_id, $args)
{
    if (empty($args) || empty($cat_id))
    {
        return false;
    }

    return $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('category'), $args, 'update', "cat_id='$cat_id'");
}


/**
 * 获取轮播图片列表
 *
 * @access  public
 * @param
 *
 * @return void
 */
function cat_flashimg_list($cat_id)
{
    $sql = "SELECT * ".
           " FROM " . $GLOBALS['ecs']->table('cat_flashimg').
           " WHERE  cat_id = '$cat_id' ".
           " ORDER BY sort_order";

    $res= $GLOBALS['db']->query($sql);
	$arr=array();
	while($row=$GLOBALS['db']->fetchRow($res))
	{
		$arr[$row['img_id']]=$row;
		$arr[$row['img_id']]['img_url']='/'.DATA_DIR.'/catflashimg/'.$row['img_url'];
	}

    return $arr;
}


?>