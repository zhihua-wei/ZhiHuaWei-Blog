<?php

/**
 * ====================================================
 * Created by ZHI HUA WEI.
 * Author: ZhiHua_Wei <zhihua_wei@foxmail.com>
 * Date: 2017/6/24
 * Time: 16:16
 * Project: ZhiHuaWei-Blog 系统
 * Version: 1.0.0
 * Power:  前台首页控制器
 * ====================================================
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Home_Controller
{

    public function index()
    {
        $data = $this->homeData;
        //记录访问人信息，地址，ip，日期，访问量+1

        $this->load->view('index.html', $data);
    }

    public function test()
    {

        echo 11115555111;

        //$this -> load -> view('welcome.html');

    }

}