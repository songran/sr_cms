<?php
/**
 * @name TestController
 * @author root
 * @desc  用户管理  列表
 * @see
 */
class UserController extends Yaf_Controller_Abstract {

    public function init() {
        $this->usermodel = new UserModel();

        if (!loginstatus()) {
            $this->redirect(BASE_URL . '/admin/index');
        }
    }

    public function indexAction() {

        $page     = $this->getRequest()->get("page");
        $page     = $page ? $page : 1;
        $url      = BASE_URL . '/user/index/';
        $offset   = 20;
        $count    = $this->usermodel->getcount();
        $pagehtml = page($url, $page, $count, $offset);

        $limit = ($page - 1) * $offset;
        $list  = $this->usermodel->getlist($offset, $limit);
        // echo '<pre>';
        //      print_r($list);
        //      exit;

        $this->getView()->assign("list", $list);
        $this->getView()->assign("page", $pagehtml);
        return true;
    }

}
