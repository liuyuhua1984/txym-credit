<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/8/15
 * Time: 14:39
 * TODO: 借钱申请记录
 */

namespace app\admin\controller;

use app\home\model\Borrower;
use app\home\model\BorrowRecord;
use app\home\model\Loaner;
use function array_push;
use function beginDate;
use function endDate;
use function error_log;
use think\Log;
use function var_dump;
class Borrowrecordlist extends BaseController
{

    public function index()
    {

        //传入index,返回一个数组
        $tIndex = $this->request->param('page');
        $start_date = $this->request->param('start_date');
        $end_date = $this->request->param('end_date');


        if (empty($tIndex)) {
            $tIndex = 1;//表示页
        }

        $arr['page'] = $tIndex;

        // 查询状态为1的用户数据 并且每页显示10条数据 总记录数为
        if (empty($start_date) && empty($end_date)) {

            $list = BorrowRecord::order(['flag'=>'asc','create_time'=>'desc']) ->paginate(10, false, $arr);
            $start_date = "";
            $end_date = "";
        }
        else {
            $list = BorrowRecord::whereBetween('create_time', [beginDate($start_date), endDate($end_date)])->order(['flag'=>'asc','create_time'=>'desc'])->paginate(10, false, $arr);
        }

        //  var_dump($list);
        // 获取分页显示
        $page = $list->render();
        if (empty($page)) {
            $page = 1;
        }

       // error_log("值::" . $page);
        //var_dump($list[0]['create_time']);
        $tList = array();
        foreach ($list as $item){
            $borrower  = Borrower::get($item['borrow_id']);
            if (!empty($borrower)){
                $item['b_phone'] = $borrower['phone'];
            }

           $loaner = Loaner::get($item['loaner_id']);
            if (!empty($loaner)){
                $item['l_phone'] = $loaner['phone'];
            }
            if (!(empty($item['l_phone']) || empty($item['b_phone']))) {
                array_push($tList, $item);
            }
        }
        // 模板变量赋值
        $this->assign('list', $tList);
        $this->assign('tIndex', $tIndex);
        $this->assign('page', $page);
        $this->assign('start_date', $start_date);
        $this->assign('end_date', $end_date);
        // 渲染模板输出
        return $this->fetch('index');

    }


    /**
     *拒绝
     */
    public function refuse()
    {
        $ld = $this->request->param('lId');
        $loaner = BorrowRecord::get($ld);
        Log::error("id::" . $ld);
        if (!empty($loaner)) {
            $loaner['flag'] = 2;
            BorrowRecord::where('id', $ld)->update(['flag' => 2]);

        }
        return $this->index();
    }

    /**
     *同意
     */
    public function agree()
    {
        $ld = $this->request->param('lId');
        $loaner = BorrowRecord::get($ld);
        Log::error("id::" . $ld);
        if (!empty($loaner)) {
            $loaner['flag'] = 1;
            BorrowRecord::where('id', $ld)->update(['flag' => 1]);

        }
        return $this->index();
    }
}

?>