<?php
namespace app\admin\common;

use app\admin\model\System;
use think\Controller;
use think\Request;
use think\Session;

//创建登陆标志常量
//对未登录进行处理
//对已登陆进行处理

class Base extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        //在初始化方法中创建一个常量来判断用户是否登陆
        define('USER_ID' , Session::get('user_id'));

        //获取网站配置信息
        $config = $this -> getSystem();

        //获取当前请求对象
        $request = Request::instance();

        //查询当前网站开关状态
        $this -> getStatus($request,$config);
    }
    //判断用户是否已经登陆,在后台入口调用
    protected function isLogin()
    {
        if (is_null(USER_ID))
        {
            $this->error('未登录，无权访问','login/index');
        }
    }

    protected function alreadyLogin()
    {
        if (!is_null(USER_ID))
        {
            $this->error('已登录，请不要重复登陆','index/index');
        }
    }

    //获取网站配置信息
    public function getSystem()
    {
        return System::get(1);
    }

    //判断当前网站的开启状态
    public function getStatus($request,$config)
    {
        if($request->module() !== 'admin')
        {
            if($config -> is_close == 1)
            {
                $this -> error('网站已关闭');
                exit();
            }
        }
    }

}