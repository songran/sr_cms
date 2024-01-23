<?php
/**
 * @name UserModel
 * @desc 用户模型
 * @author root
 */
class UserModel {

    public function __construct() {
        $this->db = Yaf_Registry::get('db');
        // $this->redis = Yaf_Registry::get('redis');
    }

    /**
     * 获得用户列表
     */
    public function getlist($offset = 20, $limit = 0) {
        $limit = "limit " . $limit . ',' . $offset;
        $sql = "select * from admin_user order by id desc " . $limit;
        $data = $this->db->get_all($sql);
        return $data;
    }
    /**
     * 的总数量
     */
    public function getcount() {
        $sql = "select count(*) as c from admin_user";
        $data = $this->db->get_one($sql, 'c');
        return $data;
    }

}
