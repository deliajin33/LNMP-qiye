<?php

namespace app\admin\controller;

use app\admin\common\Base;
use think\Request;
use app\admin\model\System as SystemModel;

class System extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //获取配置信息
//        $system = SystemModel::get(1);
        //模版赋值
        $this->view->assign('system' , $this->getSystem());
        //渲染模版
        return $this->view ->fetch('system_list');
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request)
    {
        $data = $request->param();
        $map = ['is_update'=>$data['is_update']];
        $res = SystemModel::update($data,$map);

        $status = 1;
        $message = '更新成功';

        if(is_null($res))
        {
            $status = 0;
            $message = '更新失败';
        }

        return ['status' => $status, 'message' => $message];
    }
}
