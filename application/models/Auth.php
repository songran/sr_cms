<?php
/**
 * @name AuthModel
 * @desc 
 * @author root
 */
class AuthModel {

    public function __construct() {
        $this->db = Yaf_Registry::get('db');
        // $this->redis = Yaf_Registry::get('redis');
    }

    /**
     * 获得用户列表
     */
    public function getlist($options) {
        $page     = isset($options['page'])?$options['page']:1;
        $pageSize = isset($options['pageSize'])?$options['pageSize']:40;

        $limit = "limit " . ($page-1)*$pageSize . ',' . $pageSize;
        
        $where ='1';
        if($options['is_show']){
            $where.=" and is_show=1";
        } 

        $sql = "select * from admin_auth where {$where} order by sort_num desc " . $limit;
        $data = $this->db->get_all($sql);
        return $data;
    }
    /**
     * 的总数量
     */
    public function getcount() {
        $sql = "select count(*) as c from admin_auth";
        $data = $this->db->get_one($sql, 'c');
        return $data;
    }
    /**
     * 新增
     * @Author   SongRan
     * @DateTime 2024-01-24
     * @param    [type]     $options [description]
     */
    public function addAuth($options) {
        $options['create_time'] = date('Y-m-d H:i:s',time()) ;
        $this->db->insert('admin_auth', $options);
        return $this->db->insert_id();
    }
    /**
     * 更新
     * @DESC
     * @Author   SongRan
     * @DateTime 2023-11-30
     * @param    [type]     $id      [description]
     * @param    [type]     $options [description]
     * @return   [type]              [description]
     */
    public function updateAuth($id, $options) {
        return $this->db->update('admin_auth', $options, "id={$id}");
    }
    /**
     * 获得单条数据
     * @DESC
     * @Author   SongRan
     * @DateTime 2023-11-30
     * @param    [type]     $id [description]
     * @return   [type]         [description]
     */
    public function getInfo($id) {
        $sql = "select * from admin_auth where id= " . $id;
        $data = $this->db->get_one($sql);
        return $data;
    }

}
