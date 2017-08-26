<?php

namespace app\home\controller;

use function error_log;
use think\Controller;
use app\home\model\Loaner;
use think\Log;


class Index extends Controller
{
    public function index()
    {
        //传入index,返回一个数组
        $tIndex = $this->request->param('page');
        if (empty($tIndex)) {
            $tIndex = 1;//表示页
        }

        $arr['page'] = $tIndex;

        // 查询状态为1的用户数据 并且每页显示10条数据 总记录数为
        $list = Loaner::where('is_show', '=', 1)->order(['create_time' => 'desc'])->paginate(10, true, $arr);
        //  var_dump($list);
        // 获取分页显示
        $page = $list->render();
        if (empty($page)) {
            $page = 1;
        }
        // error_log("page::".$page);
        // 模板变量赋值
        $this->assign('list', $list);
        $this->assign('tIndex', $tIndex);
        $this->assign('page', $page);
        // 渲染模板输出
        return $this->fetch('index');
    }

    /**利息计算
     * @return mixed
     */
    public function interest()
    {
//        $months = $this->request->param("months");
//        $money = $this->request->param("money");
//        if (empty($days)){
//            $days =1;
//
//        }
//
//        if (empty($money)){
//            $money = 100;
//        }

//        $this->assign('months',$months);
//        $this->assign('money',$money);
//
//        $this->assign('month_back',10);
//        $this->assign("total_interest",1000);
//        $this->assign('month_interest_rate',10);

        return $this->fetch();
    }


    /**计算利息
     * @return array
     */
    public function interest_cal()
    {
        $months = $this->request->param("months");
        $money = $this->request->param("money");
        $month_interest_rate = $this->request->param("month_interest_rate");
        if (empty($months)) {
            $months = 1;

        }

        $months = intval($months);
        if (empty($money)) {
            $money = 100;
        }

        if (!preg_match('/^[0-9]+(.[0-9]{1,2})?$/', $month_interest_rate)) {
            return ['res' => -1];
        }
        $money = intval($money);

//        $this->assign('days',$days);
//        $this->assign('money',$money);
//
//        $this->assign('day_back',10*$money);
//        $this->assign("total_interest",1000);
//        $this->assign('day_interest_rate',10);
        $month_money = round(month_cal($months, $money, $month_interest_rate / 100),2);
        $total_interest = round(($month_money * $months) - $money, 2);
        error_log("计算利息::" . $month_money);
        return ['res' => 1, 'months' => $months, 'money' => $money, 'month_back' => $month_money, "total_interest" => $total_interest, 'month_interest_rate' => $month_interest_rate];
    }

}


?>