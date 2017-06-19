<?php
/**
 * ====================================================
 * Created by ZHI HUA WEI.
 * Author: ZhiHua_Wei <zhihua_wei@foxmail.com>
 * Date: 2017/6/17
 * Time: 17:06
 * Project: ZhiHuaWei-Blog 系统
 * Version: 1.0.0
 * Power:  后台文章分类管理控制器
 * ====================================================
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Wei_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('article_model', 'article');
    }

    /**
     * 文章分类首页-列表
     */
    public function index()
    {
        $data = $this->weiData;
        $data['category_list'] = $this->article->get_category_list();
        $this->load->view('category.html', $data);
    }

    /**
     * 添加文章分类
     */
    public function add()
    {
        $data = $this->weiData;
        $this->load->view('category_add.html', $data);
    }

    /**
     * 删除文章分类
     */
    public function del($id)
    {
        $data = $this->weiData;
        //分类下存在文章，不允许删除
        if ($this->article->get_article_of_category($id)) {
            $error['msg'] = "此分类下存在文章，不允许删除！";
            $error['url'] = site_url("Weiadmin/Category/index");
            $error['wait'] = 3;
            $data['error'] = $error;
            $this->load->view('error.html', $data);
            return;
        }
        if ($this->article->del_category($id)) {
            $this->wei->add_log('删除文章分类，ID：' . $id, $this->ADMINISTRSTORS['admin_id'], $this->ADMINISTRSTORS['username']);
            $success['msg'] = "删除文章分类操作成功！";
            $success['url'] = site_url("Weiadmin/Category/index");
            $success['wait'] = 3;
            $data['success'] = $success;
            $this->load->view('success.html', $data);
        } else {
            $error['msg'] = "删除文章分类操作失败！";
            $error['url'] = site_url("Weiadmin/Category/index");
            $error['wait'] = 3;
            $data['error'] = $error;
            $this->load->view('error.html', $data);
        }
    }

    /**
     * 修改文章分类
     */
    public function edit($id)
    {
        $data = $this->weiData;
        $data['category'] = $this->article->get_category_info($id);
        $this->load->view('category_edit.html', $data);
    }

    /**
     * 新增或修改文章分类信息
     */
    public function update()
    {
        $data = $this->weiData;
        $id = $this->input->post('id');
        $params['category_name'] = $this->input->post('category_name');
        $params['keywords'] = $this->input->post('keywords');
        $params['sort'] = $this->input->post('sort');
        $params['category_desc'] = $this->input->post('category_desc');
        $is_show = $this->input->post('is_show');
        if (empty($is_show)) {
            $params['is_show'] = 0;
        } else {
            $params['is_show'] = 1;
        }

        if ($id) {
            //修改修改分类
            if ($this->article->update_category($id, $params)) {
                $this->wei->add_log('修改文章分类：' . $params['category_name'], $this->ADMINISTRSTORS['admin_id'], $this->ADMINISTRSTORS['username']);
                $success['msg'] = "修改文章分类成功！";
                $success['url'] = site_url("Weiadmin/Category/index");
                $success['wait'] = 3;
                $data['success'] = $success;
                $this->load->view('success.html', $data);
            } else {
                $error['msg'] = "修改文章分类失败！";
                $error['url'] = site_url("Weiadmin/Category/index");
                $error['wait'] = 3;
                $data['error'] = $error;
                $this->load->view('error.html', $data);
            }

        } else {
            //新增文章分类
            if ($this->article->insert_category($params)) {
                $this->wei->add_log('新增文章分类：' . $params['category_name'], $this->ADMINISTRSTORS['admin_id'], $this->ADMINISTRSTORS['username']);
                $success['msg'] = "新增文章分类成功！";
                $success['url'] = site_url("Weiadmin/Category/index");
                $success['wait'] = 3;
                $data['success'] = $success;
                $this->load->view('success.html', $data);
            } else {
                $error['msg'] = "新增文章分类失败！";
                $error['url'] = site_url("Weiadmin/Category/index");
                $error['wait'] = 3;
                $data['error'] = $error;
                $this->load->view('error.html', $data);
            }
        }
    }

}
