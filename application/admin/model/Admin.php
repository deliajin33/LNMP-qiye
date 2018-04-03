<?php

namespace app\admin\model;

use think\Model;

class Admin extends Model
{
    //??????
    public function getLastTimeAttr($val)
    {
        return date('Y/m/d',$val);
    }

    //修改器，密码md5加密处理
    public function setPasswordAttr($val)
    {
        return md5($val);
    }
}
