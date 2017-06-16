<?php
/**
 * ====================================================
 * Created by ZHI HUA WEI.
 * Author: ZhiHua_Wei <zhihua_wei@foxmail.com>
 * Date: 2017/6/16
 * Date: 2017/6/16
 * Time: 16:49
 * Project: ZhiHuaWei-Blog 系统
 * Version: 1.0.0
 * Power:  后台退出控制器
 * ====================================================
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 退出登录操作
     */
    public function index()
    {
        $data['setting'] = $this->wei->get_setting();
        delete_cookie('auth');
        $success['msg'] = "退出成功，跳转到登录页！";
        $success['url'] = site_url("Weiadmin/Login/index");
        $success['wait'] = 3;
        $data['success'] = $success;
        $this->load->view('Weiadmin/success.html', $data);
    }

}