<?php

namespace app\admin\model;

use think\Collection;
use think\Model;

class Category extends Model
{
    protected $insert = [
      'cate_order' => 0
    ];
    public static function getCate($pid=0 , &$result=[] , $blank=0)
    {
        //分类表查询
        $res = self::all(['pid' => $pid]);

        //定义分类名称前的提示信息
        $blank += 2;

        //遍历分类表
        foreach($res as $key => $value)
        {
            //自定义分类名称的显示格式
            $cate_name = $value->cate_name;
            $value->cate_name = str_repeat('&nbsp;' , $blank).$cate_name;

            //将查询到的当前记录保存到结果result中
            $result[] = $value;

            //将当前记录的id作为下一级分类的父id，继续递归调用本方法
            self::getCate($value->id , $result , $blank);
        }

        //返回查询结果，调用结果集类make方法打包当前结果，转为二维数组返回
        return Collection::make($result)->toArray();
    }
}
