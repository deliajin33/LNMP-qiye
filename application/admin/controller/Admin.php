<?php

namespace app\admin\controller;

use app\admin\common\Base;
use think\Request;
use app\admin\model\Admin as AdminModel;

class Admin extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //读取admin管理员表的信息
        $admin = AdminModel::get(['username' => 'admin']);
        //将读取到的信息赋值给模版
        $this -> view -> assign('admin', $admin);
        //渲染模版
        return $this->view ->fetch('admin_list');
    }


    public function edit(Request $request)
    {
        //读取admin管理员表的信息
        $admin = AdminModel::get($request->param('id'));
        //将读取到的信息赋值给模版
        $this -> view -> assign('admin', $admin);
        //渲染模版
        return $this->view ->fetch('admin_edit');
    }


    public function update(Request $request)
    {
        if($request -> isAjax(true))
        {
            //过滤空值
            $data = array_filter($request->param());

            //设置更新条件
            $map = ['is_update' => $data['is_update']];

            //更新表
            $res = AdminModel::update($data,$map);

            $status = 1;
            $message = '更新成功';

            if(is_null($res))
            {
                $status = 0;
                $message = '更新失败';
            }
        }
        return ['status' => $status , 'message' => $message];
    }

}
