<?php
/**
 * @name TestController
 * @author root
 * @desc
 * @see
 */
class IndexController extends Yaf_Controller_Abstract {

    public function init() {
        //$this->blogmodel = new BlogModel();
        //$this->tagmodel = new TagModel();
        if (!loginstatus()) {
            $this->redirect(BASE_URL . '/admin/index');
        }
    }

    public function indexAction() {

        //return true;

    }

}
