<?php
namespace app\home\controller;

use think\Controller;
use app\home\model\Loaner;
use think\Log;


class Index extends Controller
{
    public function index()
    {
        //传入index,返回一个数组
       $tIndex =  $this->request->param('tIndex');
       if (empty($tIndex)){
           $tIndex = 1;//表示页
       }

        $arr['page'] = $tIndex;

        // 查询状态为1的用户数据 并且每页显示10条数据 总记录数为
        $list = Loaner::where('is_show',1)->paginate(10,true,$arr);
      //  var_dump($list);
        // 获取分页显示
        $page = $list->render();
        if (empty($page)){
            $page = 1;
        }
        Log::write($page);
        // 模板变量赋值
        $this->assign('list', $list);
        $this->assign('tIndex',$tIndex);
        $this->assign('page', $page);
        // 渲染模板输出
        return $this->fetch();
    }
}
