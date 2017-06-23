<?php

/**
 * ====================================================
 * Created by ZHI HUA WEI.
 * Author: ZhiHua_Wei <zhihua_wei@foxmail.com>
 * Date: 2017/06/16 0031
 * Time: 上午 9:23
 * Project: ZhiHuaWei-Blog 系统
 * Version: 1.0.0
 * Power:  控制器扩展
 * ====================================================
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 前台父类控制器
 */
class Home_Controller extends CI_Controller
{
    /**
     * @var $homeData 前台全局变量
     */
    public $homeData;

    public function __construct()
    {
        parent::__construct();
        $this->load->set_home_view_dir();
        //获取博客设置
        $this->homeData['config'] = $this->wei->get_config();
        //获取背景图设置
        $this->homeData['background'] = $this->wei->get_background();
        var_dump($this->homeData);

        exit;


    }

}

/**
 * 后台父类控制器
 */
class Wei_Controller extends CI_Controller
{

    /**
     * @var array 后台全局变量
     */
    public $weiData;

    public function __construct()
    {
        parent::__construct();
        $this->load->set_admin_view_dir();
        $this->weiData['setting'] = $this->wei->get_setting();
        //判断是否已登录
        $flag = false;
        $auth = get_cookie('auth');
        if (!empty($auth)) {
            list($identifier, $token) = explode(',', $auth);
            if (ctype_alnum($identifier) && ctype_alnum($token)) {
                $admin = $this->wei->get_admin_info_by($identifier);
                if ($admin) {
                    if ($token == $admin['token'] && $admin['identifier'] == password($admin['admin_id'] . md5($admin['username'] . $admin['salt']))) {
                        $flag = true;
                        $admin['head_pic'] = unserialize($admin['head_pic']);
                        $this->ADMINISTRSTORS = $admin;
                    }
                }
            }
        }
        if (!$flag) {
            redirect('Weiadmin/Login/index');
            exit(0);
        }
        $admin_id = $this->ADMINISTRSTORS['admin_id'];
        $admin_auth_group = $this->wei->get_admin_auth_group($admin_id);
        //不需要权限验证的控制器名称
        $allow_controller_name = array('Login');
        //不需要权限验证的函数名称
        $allow_action_name = array();
        //获取当前访问的控制器名称
        $controller = $this->router->fetch_class();
        //获取当前访问的方法名称
        $action = $this->router->fetch_method();
        //权限验证
        if ($admin_auth_group['group_id'] != 1 && !$this->auth->auth_chack($controller . '/' . $action, $admin_id) && !in_array($controller, $allow_controller_name) && !in_array($action, $allow_action_name)) {
            redirect('Weiadmin/Login/visit_error');
            exit(0);
        }
        //当前方法名称
        $current_action_name = ($action == "edit" ? "index" : $action);
        $current_rules = $this->wei->get_current_rules($controller, $current_action_name);
        $menu_access_id = $admin_auth_group['rules'];

        if ($admin_auth_group['group_id'] != 1) {
            $menu_where = "AND id in ($menu_access_id)";
        } else {
            $menu_where = null;
        }
        $menu = $this->wei->get_menu_rules($menu_where);
        $menu = $this->get_menu_tree($menu);
//var_dump($menu[1]);
        //exit;
//echo rand(0,11);
//		exit;
        $this->weiData['current'] = $current_rules;
        $this->weiData['menu'] = $menu;
        $this->weiData['admininfo'] = $this->ADMINISTRSTORS;
    }

    /**
     * 函数：操作菜单列表生成树状
     * @param array $items 菜单数组
     * @return array $tree 菜单树
     */
    protected function get_menu_tree($items, $id = 'id', $pid = 'pid', $son = 'children')
    {
        $tree = array();
        $tmpMap = array();

        foreach ($items as $item) {
            $tmpMap[$item[$id]] = $item;
        }

        foreach ($items as $item) {
            if (isset($tmpMap[$item[$pid]])) {
                $tmpMap[$item[$pid]][$son][] = &$tmpMap[$item[$id]];
            } else {
                $tree[] = &$tmpMap[$item[$id]];
            }
        }
        return $tree;
    }

    /**
     * 函数：图片上传
     * @param file $picture 图片文件资源$_FILES['logo']
     * @param string $dir 文件上传路径Data/upload/logo/' . date("Ym")
     * @param string $name 文件参数名称 logo
     * @param string $url 上传错误跳转地址 Weiadmin/Blogset/config
     * @return string
     */
    public function pic_upload($picture, $dir, $name, $url)
    {
        //头像上传
        if (!empty($picture['tmp_name'])) {
            //配置上传参数
            $config['upload_path'] = './' . $dir;
            //原图路径
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['file_name'] = 'Weiadmin_' . date("YmdHis") . random();
            $config['max_size'] = 2048;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload($name)) {
                $pic_info = $this->upload->data();
                return $dir . $pic_info['file_name'];
            } else {
                $error['msg'] = $this->upload->display_errors();
                $error['url'] = site_url($url);
                $error['wait'] = 3;
                $data['error'] = $error;
                $this->load->view('error.html', $data);
                return;
            }
        } else {
            return false;
        }
    }

}
