<?php
/**
 * ====================================================
 * Created by ZHI HUA WEI.
 * Author: ZhiHua_Wei <zhihua_wei@foxmail.com>
 * Date: 2017/6/16
 * Time: 18:00
 * Project: ZhiHuaWei-Blog 系统
 * Version: 1.0.0
 * Power:  后台管理员管理控制器
 * ====================================================
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Database extends Wei_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->dbutil();
        $this->load->model('setting_model', 'setting');
    }

    /**
     * 数据库表首页
     */
    public function index()
    {
        $data = $this->weiData;
        $table = $this->setting->get_database_table();
        //将键名转换为小写
        $data['tablelist'] = array_map('array_change_key_case', $table);
        $this->load->view('database.html', $data);
    }

    /**
     * 数据库表备份
     */
    public function backup()
    {
        $data = $this->weiData;
        $prefs = array('tables' => array(), 'ignore' => array(), 'format' => 'zip', 'filename' => date("YmdHis") . '_Pk_admin_backup.sql', 'newline' => "\n");

        $backup = $this->dbutil->backup($prefs);
        $this->load->helper('file');
        //备份文件路径
        $backup_path = "./Data/backup/";
        if (!file_exists($backup_path)) {
            mkdir($backup_path, 0777, true);
        }
        $path = $backup_path . date("YmdHis") . '_WeiBlog_Database_backup.zip';
        write_file($path, $backup);
        $success['msg'] = "数据库备份成功，备份文件路径：" . $path;
        $success['url'] = site_url("Weiadmin/Database/index");
        $success['wait'] = 3;
        $data['success'] = $success;
        $this->load->view('success.html', $data);
    }

    /**
     * 数据库表优化
     */
    public function optimize()
    {
        $data = $this->weiData;
        $result = $this->dbutil->optimize_database();
        if ($result !== FALSE) {
            $success['msg'] = "数据库优化成功！";
            $success['url'] = site_url("Weiadmin/Database/index");
            $success['wait'] = 3;
            $data['success'] = $success;
            $this->load->view('success.html', $data);
        } else {
            $error['msg'] = "数据库优化失败！";
            $error['url'] = site_url("Weiadmin/Database/index");
            $error['wait'] = 3;
            $data['error'] = $error;
            $this->load->view('error.html', $data);
        }
    }

    /**
     * 数据库表修复
     */
    public function repair()
    {
        $data = $this->weiData;
        $table = $this->setting->get_database_table();
        //将键名转换为小写
        $tablelist = array_map('array_change_key_case', $table);
        foreach ($tablelist as $key => $val) {
            $this->dbutil->repair_table($val['name']);
        }
        $success['msg'] = "数据库修复成功！";
        $success['url'] = site_url("Weiadmin/Database/index");
        $success['wait'] = 3;
        $data['success'] = $success;
        $this->load->view('success.html', $data);
    }

}