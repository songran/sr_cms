<?php
/**
 * @name TestController
 * @author root
 * @desc
 * @see
 */
class AdminController extends Yaf_Controller_Abstract {

    public function init() {
        $this->session    = Yaf_Session::getInstance();
        $this->adminmodel = new AdminModel();
        $actionname = $this->getRequest()->getActionName();

        // if (!loginstatus() && !in_array($actionname, $this->nologin())) {
        //     //$this->redirect(BASE_URL.'/admin/index');
        // }    

    }
    /**
     * 菜单
     * @Author   SongRan
     * @DateTime 2024-01-24
     * @return   [type]     [description]
     */
    public function caidan(){
        $authMod = new AuthModel();
        $list = $authMod->getlist(['is_show'=>1]); 
        
        $tree = getTree($list);
        return $tree; 
    }

     public function testAction(){
       echo "<pre>";
       $list = $this->caidan();
       echo "<pre>";
       print_r($list);
       // print_r($this->session);
       exit; 
    }

    /**
     * 允许未登录用户访问的方法名
     * @return array
     */
    private function nologin() {
        $nologin = ['index'];
        return $nologin;
    }

    //登录显示页面
    public function indexAction() {
        return true;
    }

    //登录方法
    public function loginAction() {
        //echo 123;exit;
        $date = $this->adminmodel->getadmin();

        $username = $this->getRequest()->getpost("username");
        $password = $this->getRequest()->getpost("password");

        if ($date['username'] == $username && $date['password'] == md5($password)) {
            $this->session->admin = true;

            $this->session->caidan = $this->caidan() ;
            $this->redirect(BASE_URL);
        } else {
            $this->redirect(BASE_URL . '/admin/index');
        }
        return false;
    }

    //退出方法
    public function logoutAction() {
        $this->session->del('admin');
        $this->redirect(BASE_URL . '/admin/index');
        return false;

    }

}
