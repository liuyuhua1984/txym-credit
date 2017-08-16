<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/8/15
 * Time: 14:37
 * TODO: 借款者展示
 */

namespace app\admin\controller;
use app\home\model\Borrower;
use app\home\model\Loaner;
use function beginDate;
use function endDate;
use function error_log;
use think\Log;
use function var_dump;

class Borrowerlist extends BaseController
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
            $list = Borrower::where('is_show', '=', 1)->order(['create_time'=>'desc'])->paginate(10,false,$arr);
            $start_date="";
            $end_date = "";
        }else{
            $list = Borrower::where('is_show', '=', 1)->whereBetween('create_time',[beginDate($start_date),endDate($end_date)])->order(['create_time'=>'desc'])->paginate(10, false, $arr);
        }

        //  var_dump($list);
        // 获取分页显示
        $page = $list->render();
        if (empty($page)){
            $page = 1;
        }

        error_log("值::".$page);
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
        $loaner = Borrower::get($ld);
        Log::error("id::".$ld);
        if (!empty($loaner)){
            $loaner['is_show'] = 0;
            Borrower::where('id',$ld)-> update(['is_show'=>0]);

        }
        return $this->index();
    }
}

?>