<?php
/**
 * ====================================================
 * Created by ZHI HUA WEI.
 * Author: ZhiHua_Wei <zhihua_wei@foxmail.com>
 * Date: 2017/6/16
 * Time: 17:08
 * Project: ZhiHuaWei-Blog 系统
 * Version: 1.0.0
 * Power:  系统设置控制器
 * ====================================================
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends Wei_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('setting_model', 'setting');
        $this->load->model('login_model', 'admin');
        $this->load->library('pagination');
    }

    /**
     * 网站设置首页
     */
    public function setting()
    {
        $data = $this->weiData;
        if ($_POST) {
            $params['title'] = $this->input->post('title');
            $params['sitename'] = $this->input->post('sitename');
            $params['keywords'] = $this->input->post('keywords');
            $params['footer'] = $this->input->post('footer');
            $params['description'] = $this->input->post('description');
            $this->setting->update_site_setting($params);
            $this->wei->add_log('修改网站配置信息！', $this->ADMINISTRSTORS['admin_id'], $this->ADMINISTRSTORS['username']);
            $success['msg'] = "网站信息设置成功！";
            $success['url'] = site_url("Weiadmin/Setting/setting");
            $success['wait'] = 3;
            $data['success'] = $success;
            $this->load->view('success.html', $data);
        } else {
            $this->load->view('setting.html', $data);
        }
    }

    /**
     * 开发日志功能模块
     */
    public function devlog()
    {
        $data = $this->weiData;
        $data['devlog'] = $this->setting->get_devlog();
        $this->load->view('devlog.html', $data);
    }

    /**
     * 操作日志
     */
    public function operatelog($offset = '')
    {
        $data = $this->weiData;
        //配置分页信息
        $config['base_url'] = site_url('Weiadmin/Setting/index/');
        $config['total_rows'] = $this->admin->get_log_count($this->ADMINISTRSTORS['admin_id']);
        $config['per_page'] = 6;
        //初始化分类页
        $this->pagination->initialize($config);
        //生成分页信息
        $data['pageinfo'] = $this->pagination->create_links();
        $data['admin_log'] = $this->admin->get_admin_log_list($this->ADMINISTRSTORS['admin_id'], $config['per_page'], $offset);
        $this->load->view('operatelog.html', $data);
    }

}
