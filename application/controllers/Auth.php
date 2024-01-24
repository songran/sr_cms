<?php
/**
 * @name TestController
 * @author root
 * @desc
 * @see
 */
class AuthController extends Yaf_Controller_Abstract {

    public function init() {
        $this->authmodel = new AuthModel();
        if (!loginstatus()) {
            $this->redirect(BASE_URL . '/admin/index');
        }
     }
    /**
     * 列表页
     * @DESC
     * @Author   SongRan
     * @DateTime 2023-11-30
     * @return   [type]     [description]
     */
    public function indexAction() {
        
 
        $list = $this->authmodel->getlist(['pageSize'=>999]);
        $tree = getTree($list);

        $this->getView()->assign("list", $tree);
  
        return true;

    }
    /**
     * 列表页
     * @Author   SongRan
     * @DateTime 2024-01-23
     * @return   [type]     [description]
     */
    public function listAction() {
        
        $page             = $this->getRequest()->get("page");
        $page             = $page ? $page : 1;
        $offset           = 20;
   
        $limit = ($page - 1) * $offset;

        $list = $this->authmodel->getlist($offset, $limit, $options,'id,title');
        returnJson(0,'ok',$list);
        exit;

    }

    /**
     * 详情
     * @DESC
     * @Author   SongRan
     * @DateTime 2023-11-30
     * @return   [type]     [description]
     */
    public function infoAction() {
        $id   = $this->getRequest()->get("id");
        $info = $this->authmodel->getInfo($id);
        $this->getView()->assign("info", $info);
        return true;
    }
    /**
     * 新增-显示
     * @DESC
     * @Author   SongRan
     * @DateTime 2023-11-30
     */
    public function addAction() {
        return true;
    }
    /**
     * 修改-显示
     * @DESC
     * @Author   SongRan
     * @DateTime 2023-11-30
     * @return   [type]     [description]
     */
    public function editAction() {
        $id   = $this->getRequest()->get("id");
        $info = $this->authmodel->getInfo($id);
        $this->getView()->assign("info", $info);
        return true;
    }
    /**
     * 删除-方法
     * @DESC
     * @Author   SongRan
     * @DateTime 2023-11-30
     * @return   [type]     [description]
     */
    public function delAction() {
        $id  = $this->getRequest()->get("id");
        $res = $this->authmodel->delAuth($id);
        $this->redirect(BASE_URL . '/auth/index');
    }

    /**
     * 新增或者修改-方法
     * @DESC
     * @Author   SongRan
     * @DateTime 2023-11-30
     * @return   [type]     [description]
     */
    public function saveAction() {
        $title   = $this->getRequest()->get("title");
        $isShow  = $this->getRequest()->get("is_show");
        $id      = $this->getRequest()->get("id");
        $url     = $this->getRequest()->get("url");
        $pid     = $this->getRequest()->get("pid");
        $sort_num= $this->getRequest()->get("sort_num");
        $editArr     = [
            'title'   => $title,
            'is_show' => (int)$isShow,
            'url'     => $url,
            'pid'	  => (int)$pid,
            'sort_num'=> (int)$sort_num,
         ];
        if ($id) {
            $res                = $this->authmodel->updateAuth($id, $editArr);
            if ($res) {
                $this->redirect(BASE_URL . '/auth/index');
            } else {
                $this->redirect(BASE_URL . '/auth/edit');
            }
        } else {
            $res = $this->Authmodel->addAuth($editArr);
            if ($res) {
                $this->redirect(BASE_URL . '/auth/index');
            } else {
                $this->redirect(BASE_URL . '/auth/add');
            }
        }
    }

}
