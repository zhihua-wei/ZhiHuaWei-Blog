<?php
/**
 * ====================================================
 * Created by ZHI HUA WEI.
 * Author: ZhiHua_Wei <zhihua_wei@foxmail.com>
 * Date: 2017/6/24
 * Time: 16:16
 * Project: ZhiHuaWei-Blog 系统
 * Version: 1.0.0
 * Power:  前台博客控制器
 * ====================================================
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends Home_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('blog_model', 'blog');
        $this->load->library('blogpage', 'page');
    }

    public function test()
    {
        echo 1111;
        exit;
    }

    public function index($id, $offset = '')
    {
        $data = $this->homeData;
        //配置分页信息
        $config['base_url'] = site_url('Blog/Blog/index/') . $id . "/";
        $config['total_rows'] = $this->blog->get_blog_count($id);
        $config['per_page'] = 10;

        //初始化分类页
        $this->page->initialize($config);
        //生成分页信息
        $data['pageinfo'] = $this->page->create_links();
        $data['admin_log'] = $this->blog->get_blog_list($this->ADMINISTRSTORS['admin_id'], $config['per_page'], $offset);
        $this->load->view('admin.html', $data);
    }
}