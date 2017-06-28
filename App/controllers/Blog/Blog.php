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
        $this->load->library('blogpage');
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
        $config['total_rows'] = $this->blog->get_blog_count();
        $config['per_page'] = 2;

        //初始化分类页
        $this->blogpage->initialize($config);
        //生成分页信息
        $data['pageinfo'] = $this->blogpage->create_links();

        $data['bloglist'] = $this->blog->get_blog_list($id, $config['per_page'], $offset);
        $this->load->view('bloglist.html', $data);
    }
}