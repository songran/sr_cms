<?php
/**
 * @name SayModel
 * @desc 说说模型
 * @author root
 */
class CodeModel {

    public function __construct() {
        $this->db = Yaf_Registry::get('db');
    }

    /**
     * 获得文章列表
     */
    public function getlist($offset = 20, $limit = 0, $options = [],$common='') {
        $where = 'where 1';
        if (isset($options['title']) && $options['title'] != '') {
            $where .= " and title like '%{$options['title']}%'";
        }
        $limit = "limit " . $limit . ',' . $offset;
        $common = $common?$common:'*';
        $sql = "select {$common} from s_code {$where} order by id desc " . $limit;
        $data = $this->db->get_all($sql);
        return $data;
    }
    /**
     * 获得文章的总数量
     */
    public function getcount($options = []) {
        $where = 'where 1';
        if (isset($options['title']) && $options['title'] != '') {
            $where .= " and title like '%{$options['title']}%'";
        }
        $sql = "select count(*) as c from s_code {$where}";
        $data = $this->db->get_one($sql, 'c');
        return $data;
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
        $sql = "select * from s_code where id= " . $id;
        $data = $this->db->get_one($sql);
        return $data;
    }
    /**
     * 新增
     * @DESC
     * @Author   SongRan
     * @DateTime 2023-11-30
     * @param    [type]     $options [description]
     */
    public function addCode($options) {
        $options['create_time'] =  date('Y-m-d H:i:s',time());
        $this->db->insert('s_code', $options);
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
    public function updateCode($id, $options) {
        return $this->db->update('s_code', $options, "id={$id}");
    }
    /**
     * 删除
     * @DESC
     * @Author   SongRan
     * @DateTime 2023-11-30
     * @param    [type]     $id [description]
     * @return   [type]         [description]
     */
    public function delCode($id) {
        return $this->db->delete('s_code', "id={$id}");
    }

}
