<?php
/**
 * ====================================================
 * Created by ZHI HUA WEI.
 * Author: ZhiHua_Wei <zhihua_wei@foxmail.com>
 * Date: 2017/6/19
 * Time: 15:05
 * Project: ZhiHuaWei-Blog 系统
 * Version: 1.0.0
 * Power: 博客设置模型
 * ====================================================
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Config_model extends CI_Model
{
    const TBL_CONFIG = 'blog_config';
    const TBL_BACKGROUND = 'blog_background';
    const TBL_CAROUSEL = 'blog_carousel';

    /**
     * 函数：更新博客设置信息
     * @param array $params 网站信息内容
     */
    public function update_blog_config($params)
    {
        foreach ($params as $key => $val) {
            $condition['key'] = $key;
            $data['value'] = $val;
            $this->db->where($condition)->update(self::TBL_CONFIG, $data);
        }
    }

    /**
     * 函数：获取博客背景图列表
     * @return array
     */
    public function get_blog_background_list()
    {
        return $this->db->order_by('background_id', 'DESC')->get(self::TBL_BACKGROUND)->result_array();
    }

    /**
     * 函数：获取博客背景图信息
     * @param int $background_id 博客背景图id
     * @return array 博客背景图信息
     */
    public function get_background_info($background_id)
    {
        $condition['background_id'] = $background_id;
        return $this->db->where($condition)->get(self::TBL_BACKGROUND)->row_array();
    }

    /**
     * 函数：新增博客背景图
     * @param array $params 本博客背景图信息
     * @return bool
     */
    public function insert_background($params)
    {
        return $this->db->insert(self::TBL_BACKGROUND, $params);
    }

    /**
     * 函数：修改博客背景图
     * @param int $background_id 博客背景图id
     * @param array $params 博客背景图信息
     * @return bool
     */
    public function update_background($background_id, $params)
    {
        $condition['background_id'] = $background_id;
        return $this->db->where($condition)->update(self::TBL_BACKGROUND, $params);
    }

    /**
     * 函数：删除博客背景图
     * @param int $background_id 博客背景图id
     * @return bool
     */
    public function del_background($background_id)
    {
        $condition['background_id'] = $background_id;
        return $this->db->where($condition)->delete(self::TBL_BACKGROUND);
    }


    /**
     * 函数：获取博客轮播图列表
     * @return array
     */
    public function get_blog_carousel_list()
    {
        return $this->db->order_by('carousel_id', 'DESC')->get(self::TBL_CAROUSEL)->result_array();
    }

    /**
     * 函数：获取博客轮播图信息
     * @param int $carousel_id 博客轮播图id
     * @return array 博客轮播图信息
     */
    public function get_carousel_info($carousel_id)
    {
        $condition['carousel_id'] = $carousel_id;
        return $this->db->where($condition)->get(self::TBL_CAROUSEL)->row_array();
    }

    /**
     * 函数：新增博客轮播图
     * @param array $params 本博客轮播图信息
     * @return bool
     */
    public function insert_carousel($params)
    {
        return $this->db->insert(self::TBL_CAROUSEL, $params);
    }

    /**
     * 函数：修改博客轮播图
     * @param int $carousel_id 博客轮播图id
     * @param array $params 博客轮播图信息
     * @return bool
     */
    public function update_carousel($carousel_id, $params)
    {
        $condition['carousel_id'] = $carousel_id;
        return $this->db->where($condition)->update(self::TBL_CAROUSEL, $params);
    }

    /**
     * 函数：删除博客轮播图
     * @param int $carousel_id 博客轮播图id
     * @return bool
     */
    public function del_carousel($carousel_id)
    {
        $condition['carousel_id'] = $carousel_id;
        return $this->db->where($condition)->delete(self::TBL_CAROUSEL);
    }


}