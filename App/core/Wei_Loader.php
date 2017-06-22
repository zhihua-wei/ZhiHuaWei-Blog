<?php

/**
 * ====================================================
 * Created by ZHI HUA WEI.
 * Author: ZhiHua_Wei <zhihua_wei@foxmail.com>
 * Date: 2017/06/16 0032
 * Time: 上午 9:24
 * Project: ZhiHuaWei-Blog 系统
 * Version: 1.0.0
 * Power:  加载器扩展
 * ====================================================
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Wei_Loader extends CI_Loader {

	/**
	 * 设置博客前台视图路径
	 */
	public function set_home_view_dir() {
		$this -> _ci_view_paths = array(APPPATH . BLOG_VIEW_DIR => TRUE);
	}

	/**
	 * 设置博客后台视图路径
	 */
	public function set_admin_view_dir() {
		$this -> _ci_view_paths = array(APPPATH . ADMIN_VIEW_DIR => TRUE);
	}

}
