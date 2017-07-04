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
        $this->load->library('pagination');
    }

    public function index($id, $offset = '')
    {
        var_dump($id);
        var_dump($offset);

        //exit;
        $data = $this->homeData;
        //配置分页信息
        $config['base_url'] = site_url('Blog/Blog/index/') . $id . "/";
        $config['total_rows'] = $this->blog->get_blog_count($id);
        $config['per_page'] = 3;
        //var_dump($config);
        //exit;

        //初始化分类页
        $this->blogpage->initialize($config);
        //生成分页信息
        $data['pageinfo'] = $this->blogpage->create_links();



        var_dump($data['pageinfo']);





        exit;

        $data['category'] = $this->blog->get_category_info($id);
        $data['bloglist'] = $this->blog->get_blog_list(0, $config['per_page'], $offset);
        $this->load->view('bloglist.html', $data);
    }

    /**
     * 详情
     */
    public function blogdetail($id)
    {
        //获取详情信息

        //获取评论信息
    }

    /**
     * 评论提交
     * 使用ajax提交尝试
     */
    public function comment()
    {
        //进行评论提交
    }

    /**
     *
     */
}