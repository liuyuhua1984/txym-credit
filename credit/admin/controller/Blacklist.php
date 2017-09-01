<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/8/15
 * Time: 14:41
 * TODO:黑名单
 */

namespace app\admin\controller;

use app\home\model\Black;
use app\home\model\Borrower;
use think\Log;
use app\home\model\FrequentContacts;

class Blacklist extends BaseController
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
            $list = Black::where('is_show', '=', 1)->order(['create_time' => 'desc'])->paginate(10, false, $arr);
            $start_date = "";
            $end_date = "";
        } else {
            $list = Black::where('is_show', '=', 1)->whereBetween('create_time', [beginDate($start_date), endDate($end_date)])->order(['create_time' => 'desc'])->paginate(10, false, $arr);
        }

        //  var_dump($list);
        // 获取分页显示
        $page = $list->render();
        if (empty($page)) {
            $page = 1;
        }


        foreach ($list as $item) {//查找关系
            $freList = FrequentContacts::where('borrower_id', '=', $item['id'])->select();

            if (!empty($freList)) {

                $item['fre_list'] = $freList;

            }

        }
        // error_log("值::".$page);

        // 模板变量赋值
        $this->assign('list', $list);
        $this->assign('tIndex', $tIndex);
        $this->assign('page', $page);
        $this->assign('start_date', $start_date);
        $this->assign('end_date', $end_date);
        // 渲染模板输出
        return $this->fetch('index');

    }


    /**
     *添加黑名单
     */
    public function add()
    {
        $name = $this->request->param("name");
        $phone = $this->request->param("phone");
        $name =  preg_replace('/\s/','',$name);
        $phone =  preg_replace('/\s/','',$phone);


        if (empty($name) || empty($phone)) {
            return $this->fetch();
        }
        if (!isPhoneNum($phone)){
            return $this->error('请输入正确的电话号码');
        }


        $arr=['phone'=>$phone];
        $arr=['name'=>$name];
        //添加
        $borrower = Borrower::where($arr)->find();
        if (!empty($borrower)) {
            Borrower::destroy(['phone'=>$phone]);
        }else{
            return $this->error('未找到借款人');
        }
        $blackVal = ['name' => $borrower['name'], 'phone' => $borrower['phone'], 'password' =>  $borrower['password'], 'sex' => $borrower['sex'], 'email' => $borrower['email'],
            'id_card_1' => $borrower['id_card_1'], 'id_card_2' => $borrower['id_card_2'],
            'house_licence' => $borrower['house_licence'], 'address' => $borrower['address'], 'driver_licence' => $borrower['driver_licence'], 'create_time' => convertDate(time())];
        $blackList = Black::where('phone','=',$phone)->find();
        if ($blackList){//更新
            Black::where('phone','=',$phone)->update($blackVal);
        }else {
            //添加到黑名单

            $blackList = new Black();
            $blackList->data($blackVal);
            $blackList->save();
        }
        return $this->index();
    }

    /**
     *删除del黑名单
     */
    public function del()
    {
        $ld = $this->request->param('lId');
        $loaner = Black::get($ld);
        Log::error("id::" . $ld);
        if (!empty($loaner)) {
            $loaner['is_show'] = 0;
            Black::destroy($ld);
           // Black::where('id', '=', $ld)->update(['is_show' => 0]);

        }
        return $this->index();
    }
}

?>