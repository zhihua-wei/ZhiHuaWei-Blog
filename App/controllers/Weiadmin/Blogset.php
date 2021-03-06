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
            $params['coryright'] = $this->input->post('coryright');
            $params['description'] = $this->input->post('description');
            $is_open = $this->input->post('is_open');
            if (empty($is_open)) {
                $params['is_open'] = 0;
            } else {
                $params['is_open'] = 1;
            }
            $params['reason'] = $this->input->post('reason');
            //LOGO上传
            if (!empty($_FILES['logo']['tmp_name'])) {
                $logourl = $this->pic_upload($_FILES['logo'], "Data/upload/logo/", "logo", "Weiadmin/Blogset/config");
                if ($logourl) {
                    $params['logo'] = $logourl;
                }
            }
            $this->con->update_blog_config($params);
            $this->wei->add_log('修改博客配置信息！', $this->ADMINISTRSTORS['admin_id'], $this->ADMINISTRSTORS['username']);
            $success['msg'] = "博客配置信息设置成功！";
            $success['url'] = site_url("Weiadmin/Blogset/config");
            $success['wait'] = 3;
            $data['success'] = $success;
            $this->load->view('success.html', $data);
        } else {
            $this->load->view('config.html', $data);
        }
    }

    /**
     * 背景图设置
     */
    public function background()
    {
        $data = $this->weiData;
        $data['background_list'] = $this->con->get_blog_background_list();
        $this->load->view('background.html', $data);
    }

    /**
     * 新增背景图
     */
    public function background_add()
    {
        $data = $this->weiData;
        $this->load->view('background_add.html', $data);
    }

    /**
     * 修改背景图
     */
    public function background_edit($id)
    {
        $data = $this->weiData;
        $data['background'] = $this->con->get_background_info($id);
        $this->load->view('background_edit.html', $data);
    }

    /**
     * 删除背景图
     */
    public function background_del($id)
    {
        $data = $this->weiData;
        if ($this->con->del_background($id)) {
            $this->wei->add_log('删除背景图，ID：' . $id, $this->ADMINISTRSTORS['admin_id'], $this->ADMINISTRSTORS['username']);
            $success['msg'] = "删除背景图操作成功！";
            $success['url'] = site_url("Weiadmin/Blogset/background");
            $success['wait'] = 3;
            $data['success'] = $success;
            $this->load->view('success.html', $data);
        } else {
            $error['msg'] = "删除背景图操作失败！";
            $error['url'] = site_url("Weiadmin/Blogset/background");
            $error['wait'] = 3;
            $data['error'] = $error;
            $this->load->view('error.html', $data);
        }
    }

    /**
     * 保存背景图
     */
    public function background_update()
    {
        $data = $this->weiData;
        $id = $this->input->post('id');
        $params['background_name'] = $this->input->post('background_name');
        $params['background_desc'] = $this->input->post('background_desc');
        $params['add_time'] = time();
        if (!empty($_FILES['background_pic']['tmp_name'])) {
            $background_pic = $this->pic_upload($_FILES['background_pic'], "Data/upload/background/", "background_pic", "Weiadmin/Blogset/background");
            if ($background_pic) {
                $params['background_url'] = $background_pic;
            }
        }
        if ($id) {
            //修改背景图
            if ($this->con->update_background($id, $params)) {
                $this->wei->add_log('修改博客背景图：' . $params['background_name'], $this->ADMINISTRSTORS['admin_id'], $this->ADMINISTRSTORS['username']);
                $success['msg'] = "修改博客背景图成功！";
                $success['url'] = site_url("Weiadmin/Blogset/background");
                $success['wait'] = 3;
                $data['success'] = $success;
                $this->load->view('success.html', $data);
            } else {
                $error['msg'] = "修改博客背景图失败！";
                $error['url'] = site_url("Weiadmin/Blogset/background");
                $error['wait'] = 3;
                $data['error'] = $error;
                $this->load->view('error.html', $data);
            }
        } else {
            //新增背景图
            if ($this->con->insert_background($params)) {
                $this->wei->add_log('新增博客背景图：' . $params['background_name'], $this->ADMINISTRSTORS['admin_id'], $this->ADMINISTRSTORS['username']);
                $success['msg'] = "新增博客背景图成功！";
                $success['url'] = site_url("Weiadmin/Blogset/background");
                $success['wait'] = 3;
                $data['success'] = $success;
                $this->load->view('success.html', $data);
            } else {
                $error['msg'] = "新增博客背景图失败！";
                $error['url'] = site_url("Weiadmin/Blogset/background");
                $error['wait'] = 3;
                $data['error'] = $error;
                $this->load->view('error.html', $data);
            }
        }

    }

    /**
     * 轮播图设置
     */
    public function carousel()
    {
        $data = $this->weiData;
        $data['carousel_list'] = $this->con->get_blog_carousel_list();
        $this->load->view('carousel.html', $data);
    }

    /**
     * 新增轮播图
     */
    public function carousel_add()
    {
        $data = $this->weiData;
        $this->load->view('carousel_add.html', $data);
    }

    /**
     * 修改轮播图
     */
    public function carousel_edit($id)
    {
        $data = $this->weiData;
        $data['carousel'] = $this->con->get_carousel_info($id);
        $this->load->view('carousel_edit.html', $data);
    }

    /**
     * 删除背景图
     */
    public function carousel_del($id)
    {
        $data = $this->weiData;
        if ($this->con->del_carousel($id)) {
            $this->wei->add_log('删除轮播图，ID：' . $id, $this->ADMINISTRSTORS['admin_id'], $this->ADMINISTRSTORS['username']);
            $success['msg'] = "删除轮播图操作成功！";
            $success['url'] = site_url("Weiadmin/Blogset/carousel");
            $success['wait'] = 3;
            $data['success'] = $success;
            $this->load->view('success.html', $data);
        } else {
            $error['msg'] = "删除轮播图操作失败！";
            $error['url'] = site_url("Weiadmin/Blogset/carousel");
            $error['wait'] = 3;
            $data['error'] = $error;
            $this->load->view('error.html', $data);
        }
    }

    /**
     * 保存轮播图
     */
    public function carousel_update()
    {
        $data = $this->weiData;
        $id = $this->input->post('id');
        $params['carousel_name'] = $this->input->post('carousel_name');
        $params['carousel_desc'] = $this->input->post('carousel_desc');
        $params['add_time'] = time();
        if (!empty($_FILES['carousel_pic']['tmp_name'])) {
            $carousel_pic = $this->pic_upload($_FILES['carousel_pic'], "Data/upload/carousel/", "carousel_pic", "Weiadmin/Blogset/carousel");
            if ($carousel_pic) {
                $params['carousel_url'] = $carousel_pic;
            }
        }
        if ($id) {
            //修改背景图
            if ($this->con->update_carousel($id, $params)) {
                $this->wei->add_log('修改博客轮播图：' . $params['carousel_name'], $this->ADMINISTRSTORS['admin_id'], $this->ADMINISTRSTORS['username']);
                $success['msg'] = "修改博客轮播图成功！";
                $success['url'] = site_url("Weiadmin/Blogset/carousel");
                $success['wait'] = 3;
                $data['success'] = $success;
                $this->load->view('success.html', $data);
            } else {
                $error['msg'] = "修改博客轮播图失败！";
                $error['url'] = site_url("Weiadmin/Blogset/carousel");
                $error['wait'] = 3;
                $data['error'] = $error;
                $this->load->view('error.html', $data);
            }
        } else {
            //新增背景图
            if ($this->con->insert_carousel($params)) {
                $this->wei->add_log('新增轮播背景图：' . $params['carousel_name'], $this->ADMINISTRSTORS['admin_id'], $this->ADMINISTRSTORS['username']);
                $success['msg'] = "新增轮播背景图成功！";
                $success['url'] = site_url("Weiadmin/Blogset/carousel");
                $success['wait'] = 3;
                $data['success'] = $success;
                $this->load->view('success.html', $data);
            } else {
                $error['msg'] = "新增博客轮播图失败！";
                $error['url'] = site_url("Weiadmin/Blogset/carousel");
                $error['wait'] = 3;
                $data['error'] = $error;
                $this->load->view('error.html', $data);
            }
        }
    }

}