<?php

namespace app\home\controller;

use function convertDate;
use think\Controller;
use app\home\model\Loaner;
use app\home\model\Borrower;
use app\home\model\BorrowRecord;
use think\Session;
use think\Log;
use function time;

class Borrow extends Controller
{

    public function borrowRequest()
    {
//        'money': money,
//        'days': days,
//        'loaner_id':loaner_id,
//        'borrower_id' :borrower_id,

        $money = $this->request->param('money');
        $days = $this->request->param('days');
        $loaner_id = $this->request->param('loaner_id');
        $borrower_id = $this->request->param('borrower_id');

        $money =  preg_replace('/\s/','',$money);
        $days =  preg_replace('/\s/','',$days);
        $loaner_id =  preg_replace('/\s/','',$loaner_id);
        $borrower_id =  preg_replace('/\s/','',$borrower_id);
       Log::error($loaner_id.":".$borrower_id);

        //判断双方是否存在
        $loaner = Loaner::where('id', '=', $loaner_id)->find();
        $borrower = Borrower::where('id', '=', $borrower_id)->find();

        if (empty($borrower)) {
            return ['res' => -1];
        }
        if (empty($loaner)) {
            return ['res' => -2];
        }

        $borrowerRecord = new BorrowRecord();
        $borrowerRecord->data(['borrow_id'=>$borrower_id,'loaner_id'=>$loaner_id,'borrow_money'=>$money,'borrow_time_limit'=>$days,'order_id'=>build_order_no(),'create_time'=>convertDate(time())]);
        $borrowerRecord->save();

        return ['res' => 1];
    }
}