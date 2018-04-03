<?php

namespace app\admin\controller;

use app\admin\common\Base;
use think\Request;
use app\admin\model\Admin;
use think\Session;

class Login extends Base
{
    //渲染登陆界面
    public function index()
    {
        //判断用户是否重复登陆
        $this -> alreadyLogin();

        return $this->view ->fetch('login');
    }

    //验证用户身份
    public function check(Request $request)
    {
        //设置status
        $status = 0 ;
        //获取表单数据
        $data = $request -> param();
        $username = $data['username'];
        $password = md5($data['password']);
        //在admin表中进行查询，以用户为条件
        $map = ['username' => $username];
        $admin = Admin::get($map);

        //用户名与密码分开验证
        if(is_null($admin))
        {
            $message = '用户名不正确';

        }
        else if($admin -> password != $password)
        {
            $message = '密码不正确';
        }
        else
        {
            $status = 1;
            $message = '验证通过';

            //更新登录次数与时间
            $admin -> setInc('login_count');
            $admin -> save(['last_time' => time()]);

            //登陆信息保存到session中
            Session::set('user_id' , $username);
            Session::set('user_info' , $admin->toArray());


        }

        return ['status' => $status , 'message' => $message];
    }

    //退出登陆
    public function logout()
    {
        Session::delete('user_id');
        Session::delete('user_info');
        $this -> success('注销成功，正在返回...' , 'login/index');
    }

}
