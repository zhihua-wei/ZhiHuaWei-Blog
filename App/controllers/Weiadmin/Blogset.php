<?php
/**
 * ====================================================
 * Created by ZHI HUA WEI.
 * Author: ZhiHua_Wei <zhihua_wei@foxmail.com>
 * Date: 2017/6/19
 * Time: 11:32
 * Project: ZhiHuaWei-Blog 系统
 * Version: 1.0.0
 * Power:  后台博客设置控制器
 * ====================================================
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Blogset extends Wei_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('config_model', 'con');
        $this->load->library('pagination');
    }

    /**
     * 博客设置
     */
    public function config()
    {
        $data = $this->weiData;
        $data['config'] = $this->wei->get_config();
        if ($_POST) {
            $params['webname'] = $this->input->post('webname');
            $params['title'] = $this->input->post('title');
            $params['sitename'] = $this->input->post('sitename');
            $params['keywords'] = $this->input->post('keywords');
            $params['footer'] = $this->input->post('footer');
            $params['description'] = $this->input->post('description');
            $params['title'] = $this->input->post('title');
            $params['title'] = $this->input->post('title');


            $this->con->update_site_setting($params);
            $this->wei->add_log('修改网站配置信息！', $this->ADMINISTRSTORS['admin_id'], $this->ADMINISTRSTORS['username']);
            $success['msg'] = "网站信息设置成功！";
            $success['url'] = site_url("Weiadmin/Blogset/config");
            $success['wait'] = 3;
            $data['success'] = $success;
            $this->load->view('success.html', $data);
        } else {
            $this->load->view('config.html', $data);
        }
        //$this->load->view('config.html', $data);
    }

    /**
     * 轮播图设置
     */
    public function carousel()
    {
        var_dump(111);
        exit;

    }


    public function index($offset = '')
    {
        $data = $this->weiData;
        //删除三十天前的日志记录
        $t = time() - 3600 * 24 * 30;
        $this->admin->del_month_ago_log($t);
        //配置分页信息
        $config['base_url'] = site_url('Weiadmin/Admin/index/');
        $config['total_rows'] = $this->admin->get_log_count($this->ADMINISTRSTORS['admin_id']);
        $config['per_page'] = 10;
        //初始化分类页
        $this->pagination->initialize($config);
        //生成分页信息
        $data['pageinfo'] = $this->pagination->create_links();
        $data['admin_log'] = $this->admin->get_admin_log_list($this->ADMINISTRSTORS['admin_id'], $config['per_page'], $offset);
        $this->load->view('admin.html', $data);
    }

    /**
     * 背景图设置
     */
    public function background()
    {
    }
}