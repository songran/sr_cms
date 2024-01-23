<?php
/**
 * @name
 * @desc  模型
 * @author root
 */
class AdminModel {

    public function __construct() {
        $this->db = Yaf_Registry::get('db');
        // $this->redis = Yaf_Registry::get('redis');
    }

    /**
     * 获得管理员 账户
     */
    public function getadmin() {

        $time = date('Hi', time());
        $data = array(
            'username' => 'admin',
            'password' => md5('admin'),
            'time' => $time,
        );
        return $data;
    }

}
