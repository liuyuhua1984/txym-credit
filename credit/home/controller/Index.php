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
       $tIndex =  $this->request->param('page');
       if (empty($tIndex)){
           $tIndex = 1;//表示页
       }

        $arr['page'] = $tIndex;

        // 查询状态为1的用户数据 并且每页显示10条数据 总记录数为
        $list = Loaner::where('is_show','=',1)->order(['create_time'=>'desc'])->paginate(10,false,$arr);
      //  var_dump($list);
        // 获取分页显示
        $page = $list->render();
        if (empty($page)){
            $page = 1;
        }
        //error_log("page::".$page);
        // 模板变量赋值
        $this->assign('list', $list);
        $this->assign('tIndex',$tIndex);
        $this->assign('page', $page);
        // 渲染模板输出
        return $this->fetch('index');
    }

    /**利息计算
     * @return mixed
     */
    public function interest(){
        $days = $this->request->param("days");
        $money = $this->request->param("money");
        if (empty($days)){
            $days =1;

        }

        if (empty($money)){
            $money = 100;
        }

        $this->assign('days',$days);
        $this->assign('money',$money);

        $this->assign('day_back',10);
        $this->assign("total_interest",1000);
        $this->assign('day_interest_rate',10);

        return $this->fetch();
    }


    public function interest_cal(){
        $days = $this->request->param("days");
        $money = $this->request->param("money");
        if (empty($days)){
            $days =1;

        }

        if (empty($money)){
            $money = 100;
        }

        $this->assign('days',$days);
        $this->assign('money',$money);

        $this->assign('day_back',10);
        $this->assign("total_interest",1000);
        $this->assign('day_interest_rate',10);

        return ['res' => 1];
    }

}
?>