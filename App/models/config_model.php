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
     * @param int $background_id id
     * @param array $params 博客背景图信息
     * @return bool
     */
    public function update_category($background_id, $params)
    {
        $condition['background_id'] = $background_id;
        return $this->db->where($condition)->update(self::TBL_BACKGROUND, $params);
    }


}