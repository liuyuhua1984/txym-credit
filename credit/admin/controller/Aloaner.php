<?php
/**
 * Class Loaner
 *TODO:
 *  出借者
 * @package app\admin\controller
 */
namespace app\admin\controller;
use app\home\model\Loaner;
use function beginDate;
use function endDate;
use function error_log;
use think\Log;
use function var_dump;

class Aloaner extends BaseController
{

    public function index(){

        //传入index,返回一个数组
        $tIndex =  $this->request->param('page');
        $start_date = $this->request->param('start_date');
        $end_date = $this->request->param('end_date');


        if (empty($tIndex)){
            $tIndex = 1;//表示页
        }

        $arr['page'] = $tIndex;

        // 查询状态为1的用户数据 并且每页显示10条数据 总记录数为
            if (empty($start_date) && empty($end_date)) {
                $list = Loaner::where('is_show', '=', 1)->order(['create_time'=>'desc'])->paginate(10,false,$arr);
                $start_date="";
                $end_date = "";
            }else{
                $list = Loaner::where('is_show', '=', 1)->whereBetween('create_time',[beginDate($start_date),endDate($end_date)])->order(['create_time'=>'desc'])->paginate(10, false, $arr);
            }

        //  var_dump($list);
        // 获取分页显示
        $page = $list->render();
        if (empty($page)){
            $page = 1;
        }

        //error_log("值::".$page);
        //var_dump($list[0]['create_time']);
        // 模板变量赋值
        $this->assign('list', $list);
        $this->assign('tIndex',$tIndex);
        $this->assign('page', $page);
        $this->assign('start_date',$start_date);
        $this->assign('end_date',$end_date);
        // 渲染模板输出
        return $this->fetch('index');

    }


    /**
     *删除del
     */
    public function del(){
        $ld =  $this->request->param('lId');
        $loaner = Loaner::get($ld);
        Log::error("id::".$ld);
        if (!empty($loaner)){
            $loaner['is_show'] = 0;
            Loaner::where('id','=',$ld)-> update(['is_show'=>0]);

        }
        return $this->index();
    }

}