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
    const TBL_CATEGORY = 'category';

    /**
     * 函数：获取文章分类下文章数
     * @param int $category_id 分类id
     * @return int
     */
    public function get_blog_count($category_id = null)
    {
        if ($category_id) {
            $condition['category_id'] = $category_id;
            return $this->db->where($condition)->count_all_results(self::TBL_ARTICLE);
        } else {
            return $this->db->count_all(self::TBL_ARTICLE);
        }
    }

    /**
     * 函数：获取文章分类信息
     * @param int $category_id 分类id
     * @return array 分类信息
     */
    public function get_category_info($category_id)
    {
        $condition['category_id'] = $category_id;
        return $this->db->where($condition)->get(self::TBL_CATEGORY)->row_array();
    }

    /**
     * 函数：获取博客列表
     * @param int $category_id 分类id
     * @param int $limit 每页显示数
     * @param int $offset 偏移量
     * @return array 博客列表列表
     */
    public function get_blog_list($category_id = null, $limit, $offset)
    {
        if ($category_id) {
            $condition['category_id'] = $category_id;
            return $this->db->where($condition)->order_by('article_id', 'DESC')->limit($limit, $offset)->get(self::TBL_ARTICLE)->result_array();
        } else {
            return $this->db->order_by('article_id', 'DESC')->limit($limit, $offset)->get(self::TBL_ARTICLE)->result_array();
        }
    }



}