<?php
/**
 * ====================================================
 * Created by ZHI HUA WEI.
 * Author: ZhiHua_Wei <zhihua_wei@foxmail.com>
 * Date: 2017/6/17
 * Time: 16:58
 * Project: ZhiHuaWei-Blog 系统
 * Version: 1.0.0
 * Power:  后台文章管理控制器
 * ====================================================
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends Wei_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('article_model', 'article');
    }

    /**
     * 文章管理首页
     */
    public function index($offset = '')
    {
        $data = $this->weiData;
        //配置分页信息
        $config['base_url'] = site_url('Weiadmin/Article/index/');
        $config['total_rows'] = $this->article->get_article_count();
        $config['per_page'] = 10;
        //初始化分类页
        $this->pagination->initialize($config);
        //生成分页信息
        $data['pageinfo'] = $this->pagination->create_links();
        $article_list = $this->article->get_article_list($config['per_page'], $offset);
        foreach ($article_list as $k => $v) {
            $catrgory = $this->article->get_category_info($v['category_id']);
            $article_list[$k]['category_name'] = $catrgory['category_name'];
        }
        $data['article_list'] = $article_list;
        $this->load->view('article.html', $data);
    }

    /**
     * 新增文章
     */
    public function add()
    {
        $data = $this->weiData;
        $data['category_list'] = $this->article->get_category_list();
        $this->load->view('article_add.html', $data);
    }

    /**
     * 修改文章
     */
    public function edit($id)
    {
        $data = $this->weiData;
        $data['category_list'] = $this->article->get_category_list();
        $data['article'] = $this->article->get_article_info($id);
        $this->load->view('article_edit.html', $data);
    }

    /**
     * 删除文章
     */
    public function del($id)
    {
        $data = $this->weiData;
        if ($this->article->del_article($id)) {
            $this->wei->add_log('删除文章，ID：' . $id, $this->ADMINISTRSTORS['admin_id'], $this->ADMINISTRSTORS['username']);
            $success['msg'] = "删除文章操作成功！";
            $success['url'] = site_url("Weiadmin/Article/index");
            $success['wait'] = 3;
            $data['success'] = $success;
            $this->load->view('success.html', $data);
        } else {
            $error['msg'] = "删除文章操作失败！";
            $error['url'] = site_url("Weiadmin/Article/index");
            $error['wait'] = 3;
            $data['error'] = $error;
            $this->load->view('error.html', $data);
        }
    }

    /**
     * 新增修改文章内容
     */
    public function update()
    {
        $data = $this->weiData;
        $id = $this->input->post('id');
        $params['category_id'] = $this->input->post('category_id');
        $params['article_title'] = $this->input->post('article_title');
        $params['keywords'] = $this->input->post('keywords');
        $params['article_desc'] = $this->input->post('article_desc');
        $params['content'] = $this->input->post('content');
        $params['edit_time'] = time();

        //文章插图上传
        if (!empty($_FILES['article_pic']['tmp_name'])) {
            //配置上传参数
            $config['upload_path'] = './Data/upload/article_pic/' . date("Ym");
            //原图路径
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['file_name'] = 'Weiadmin_' . date("YmdHis") . random();
            $config['max_size'] = 2048;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('article_pic')) {
                $article_pic_info = $this->upload->data();
                $path_info = "Data/upload/article_pic/" . date("Ym") . "/";
                $params['article_pic'] = $path_info . $article_pic_info['file_name'];
            } else {
                $error['msg'] = $this->upload->display_errors();
                $error['url'] = site_url("Weiadmin/Article/index");
                $error['wait'] = 3;
                $data['error'] = $error;
                $this->load->view('error.html', $data);
                return;
            }
        }
        if ($id) {
            //修改文章
            if ($this->article->update_article($id, $params)) {
                $this->wei->add_log('修改文章：' . $params['article_title'], $this->ADMINISTRSTORS['admin_id'], $this->ADMINISTRSTORS['username']);
                $success['msg'] = "修改文章成功！";
                $success['url'] = site_url("Weiadmin/Article/index");
                $success['wait'] = 3;
                $data['success'] = $success;
                $this->load->view('success.html', $data);
            } else {
                $error['msg'] = "修改文章失败！";
                $error['url'] = site_url("Weiadmin/Article/index");
                $error['wait'] = 3;
                $data['error'] = $error;
                $this->load->view('error.html', $data);
            }
        } else {
            //插入文章
            $params['issue_time'] = time();
            if ($this->article->insert_article($params)) {
                $this->wei->add_log('新增文章：' . $params['article_title'], $this->ADMINISTRSTORS['admin_id'], $this->ADMINISTRSTORS['username']);
                $success['msg'] = "新增文章成功！";
                $success['url'] = site_url("Weiadmin/Article/index");
                $success['wait'] = 3;
                $data['success'] = $success;
                $this->load->view('success.html', $data);
            } else {
                $error['msg'] = "新增文章失败！";
                $error['url'] = site_url("Weiadmin/Article/index");
                $error['wait'] = 3;
                $data['error'] = $error;
                $this->load->view('error.html', $data);
            }
        }
    }

}