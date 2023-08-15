<?php
namespace app\common\taglib;

use nfutil\template\TagLib;

/**
 * 标签库
 * 使用样例
 */
class nf extends TagLib
{
    // 兼容TP3版本TagLib
    protected $prefix = '_';

    /**
     * 定义标签列表
     * 
     */
    protected $tags = array(
        'sql_query'   => array('attr' => 'sql,result', 'close' => 0), //SQL查询
        'nav_list'    => array('attr' => 'name,pid,group', 'close' => 1), //导航列表
        'slider_list' => array('attr' => 'name,limit,page,order', 'close' => 1), //幻灯列表
        'post_list'   => array('attr' => 'name,limit,page,order,cid', 'close' => 1), //文章列表

        'breadcrumb'    => array('attr' => 'name,cid', 'close' => 1), //面包屑导航列表
        'category_list' => array('attr' => 'name,pid,limit,page,group', 'close' => 1), //栏目分类列表
        'article_list'  => array('attr' => 'name,cid,limit,page,order,child', 'close' => 1), //文章列表
        'new_list'      => array('attr' => 'name,doc_type,limit,order', 'close' => 1), //最新文章列表
        'comment_list'  => array('attr' => 'name,data_id,limit,page,order', 'close' => 1), //评论列表
        'similar_list'  => array('attr' => 'name,tags,limit,order', 'close' => 1),  //相关列表
    );

    /**
     * SQL查询
     */
    public function _sql_query($tag, $content)
    {
        $sql    = $tag['sql'];
        $result = !empty($tag['result']) ? $tag['result'] : 'result';
        $parse  = '<?php $' . $result . ' = M()->query("' . $sql . '");';
        $parse .= 'if($' . $result . '):?>' . $content;
        $parse .= "<?php endif;?>";
        return $parse;
    }

    /**
     * 导航列表
     * <nf:nav_list name="vo" pid="0" group="top">
     * </nf:nav_list>
     */
    public function _nav_list($tag, $content)
    {
        $name  = $tag['name'];
        $pid   = $tag['pid'] ?: 0;
        $group = $tag['group'] ?: 'main';
        $parse = '<?php ';
        $parse .= '$__NAV_LIST__ = D2(\'AdminNav\')->getNavTree(' . $pid . ', "' . $group . '");';
        $parse .= ' ?>';
        $parse .= '<volist name="__NAV_LIST__" id="' . $name . '">';
        $parse .= $content;
        $parse .= '</volist>';
        return $parse;
    }

    /**
     * 幻灯列表
     * 
     */
    public function _slider_list($tag, $content)
    {
        $name  = $tag['name'];
        $limit = isset($tag['limit']) ?: 10;
        $page  = isset($tag['page']) ?: 1;
        $order = isset($tag['order']) ?: 'sort desc,id desc';
        $parse = '<?php ';
        $parse .= '$map = array(); ';
        $parse .= '$map["status"] = array("eq", "1");';
        $parse .= '$__SLIDER_LIST__ = D2("AdminSlider")->getList(' . $limit . ', ' . $page . ', "' . $order . '", $map);';
        $parse .= ' ?>';
        $parse .= '<volist name="__SLIDER_LIST__" id="' . $name . '">';
        $parse .= $content;
        $parse .= '</volist>';
        return $parse;
    }

    /**
     * 文章列表
     * 
     */
    public function _post_list($tag, $content)
    {
        $name = $tag['name'];
        $cid  = $tag['cid'];
        if (!$cid) {
            return;
        }
        $limit = $tag['limit'] ?: 10;
        $page  = $tag['page'] ?: 1;
        $order = $tag['order'] ?: 'sort desc,id desc';
        $parse = '<?php ';
        $parse .= '$map = array(); ';
        $parse .= '$map["status"] = array("eq", "1");';
        $parse .= '$__POST_LIST__ = D2("AdminPost")->getList(' . $cid . ', ' . $limit . ', ' . $page . ', "' . $order . '", $map);';
        $parse .= ' ?>';
        $parse .= '<volist name="__POST_LIST__" id="' . $name . '">';
        $parse .= $content;
        $parse .= '</volist>';
        return $parse;
    }



    // +----------------------------------------------------------------------
    // | Cms模块
    // +----------------------------------------------------------------------

    /**
     * 面包屑导航列表
     * 
     */
    public function _breadcrumb($tag, $content) {
        $name   = $tag['name'];
        $cid    = $tag['cid'];
        $group  = $tag['group'] ? : 1;
        $parse  = '<?php ';
        $parse .= '$__PARENT_CATEGORY__ = D2("CmsCategory\')->getParentCategory('.$cid.', '.$group.');';
        $parse .= ' ?>';
        $parse .= '<volist name="__PARENT_CATEGORY__" id="'. $name .'">';
        $parse .= $content;
        $parse .= '</volist>';
        return $parse;
    }

    /**
     * 栏目分类列表
     * 
     */
    public function _category_list($tag, $content) {
        $name   = $tag['name'];
        $pid    = $tag['pid'] ? : 0;
        $limit  = $tag['limit'] ? :10;
        $page   = $tag['page'] ? : 1;
        $group  = $tag['group'] ? : 1;
        $parse  = '<?php ';
        $parse .= '$__CATEGORYLIST__ = D2("CmsCategory")->getCategoryTree('.$pid.', '.$limit.', '.$page.', '.$group.');';
        $parse .= ' ?>';
        $parse .= '<volist name="__CATEGORYLIST__" id="'. $name .'">';
        $parse .= $content;
        $parse .= '</volist>';
        return $parse;
    }

    /**
     * 文章列表
     * 
     */
    public function _article_list($tag, $content) {
        $name   = $tag['name'];
        $cid    = $tag['cid'] ? : 1;
        $limit  = $tag['limit'] ? : 10;
        $page   = $tag['page'] ? : 1;
        $order  = $tag['order'] ? : '';
        $child  = $tag['child'] ? : '';
        $parse  = '<?php ';
        $parse .= '$map = array("status" => "1");';
        $parse .= '$__ARTICLE_LIST__ = D2("CmsIndex")->getList('.$cid.', '.$limit.', '.$page.', "'.$order.'", "'.$child.'", $map);';
        $parse .= ' ?>';
        $parse .= '<volist name="__ARTICLE_LIST__" id="'. $name .'">';
        $parse .= $content;
        $parse .= '</volist>';
        return $parse;
    }

    /**
     * 最新文章列表
     * 
     */
    public function _new_list($tag, $content) {
        $name   = $tag['name'];
        $doc_type = $tag['doc_type'];
        $limit  = $tag['limit'] ? : 10;
        $page   = $tag['page'] ? : 1;
        $order  = $tag['order'] ? : '';
        $parse  = '<?php ';
        $parse .= '$map = array("status" => "1");';
        $parse .= '$__ARTICLE_LIST__ = D2("CmsIndex")->getNewList('.$doc_type.', '.$limit.', '.$page.', "'.$order.'", $map);';
        $parse .= ' ?>';
        $parse .= '<volist name="__ARTICLE_LIST__" id="'. $name .'">';
        $parse .= $content;
        $parse .= '</volist>';
        return $parse;
    }

    /**
     * 评论列表
     * 
     */
    public function _comment_list($tag, $content) {
        $name    = $tag['name'];
        $data_id = $tag['data_id'];
        $limit   = $tag['limit'] ? : 10;
        $page    = $tag['page'] ? :1 ;
        $order   = $tag['order'] ? : 'sort desc,id asc';
        $parse   = '<?php ';
        $parse  .= '$__COMMENT_LIST__ = D2("CmsComment")->getCommentList('.$data_id.', '.$limit.', '.$page.', "'.$order.'");';
        $parse  .= ' ?>';
        $parse  .= '<volist name="__COMMENT_LIST__" id="'. $name .'">';
        $parse  .= $content;
        $parse  .= '</volist>';
        return $parse;
    }

    /**
     * 相关列表
     * 
     */
    public function _similar_list($tag, $content) {
        $name   = $tag['name'];
        $tags   = $tag['tags'];
        $limit  = $tag['limit'] ? : 4;
        $parse  = '<?php ';
        $parse .= '$__SIMILARLIST__ = D2("CmsIndex")->getSimilar('.$tags.','.$limit.');';
        $parse .= ' ?>';
        $parse .= '<volist name="__SIMILARLIST__" id="'.$name.'">';
        $parse .= $content;
        $parse .= '</volist>';
        return $parse;
    }






}
