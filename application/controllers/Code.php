<?php
/**
 * @name TestController
 * @author root
 * @desc
 * @see
 */
class CodeController extends Yaf_Controller_Abstract {

    public function init() {
        $this->codemodel = new CodeModel();
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
        $page             = $this->getRequest()->get("page");
        $page             = $page ? $page : 1;
        $url              = BASE_URL . '/code/index/';
        $offset           = 20;
        $options['title'] = $this->getRequest()->get("title");
        $count            = $this->codemodel->getcount($options);
        $pagehtml         = page($url, $page, $count, $offset);

        $limit = ($page - 1) * $offset;

        $list = $this->codemodel->getlist($offset, $limit, $options);

        $this->getView()->assign("list", $list);
        $this->getView()->assign("page", $pagehtml);
        $this->getView()->assign("title", $options['title']);

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

        $list = $this->codemodel->getlist($offset, $limit, $options,'id,title');
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
        $info = $this->codemodel->getInfo($id);
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
        $info = $this->codemodel->getInfo($id);
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
        $res = $this->codemodel->delCode($id);
        $this->redirect(BASE_URL . '/code/index');
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
        $content = $this->getRequest()->get("content");
        $id      = $this->getRequest()->get("id");
        $editArr     = [
            'title'   => $title,
            'content' => addslashes($content),
         ];
        if ($id) {
            $res                = $this->codemodel->updateCode($id, $editArr);
            if ($res) {
                $this->redirect(BASE_URL . '/code/index');
            } else {
                $this->redirect(BASE_URL . '/code/edit');
            }
        } else {
            $res = $this->codemodel->addCode($editArr);
            if ($res) {
                $this->redirect(BASE_URL . '/code/index');
            } else {
                $this->redirect(BASE_URL . '/code/add');
            }
        }
    }

}
