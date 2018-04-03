<?php
namespace app\admin\controller;

use app\admin\common\Base;

class Index extends Base
{
    public function index()
    {
        //判断用户是否登陆
        $this -> isLogin();

        return $this->view ->fetch('index');
    }

    public function welcome()
    {
        return $this->view ->fetch('welcome');
    }
}
