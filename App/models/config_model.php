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


}