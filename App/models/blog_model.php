<?php

/**
 * ====================================================
 * Created by ZHI HUA WEI.
 * Author: ZhiHua_Wei <zhihua_wei@foxmail.com>
 * Date: 2017/6/22
 * Time: 11:50
 * Project: ZhiHuaWei-Blog 系统
 * Version: 1.0.0
 * Power: 博客前台模型
 * ====================================================
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_model extends CI_Model
{
    const TBL_ARTICLE = 'blog_article';

    /**
     * 函数：获取文章分类下文章数
     * @param int $category_id 分类id
     * @return int
     */
    public function get_blog_count($category_id)
    {
        var_dump($category_id);
        exit;

        if ($category_id) {
            $condition['category_id'] = $category_id;
            return $this->db->where($condition)->count_all(self::TBL_ARTICLE);
        } else {
            return $this->db->count_all(self::TBL_ARTICLE);
        }
    }


}