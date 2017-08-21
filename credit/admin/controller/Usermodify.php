<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2017/8/20
 * Time: 21:35
 */

namespace app\admin\controller;

use app\home\model\FrequentContacts;
use think\Controller;

use app\home\model\Loaner;
use app\home\model\Borrower;
use think\Log;

class Usermodify extends BaseController
{
    /**
     * 出借人信息
     * @return mixed|void
     */
    public function pLoanerInfo()
    {
        $did = $this->request->param('lId');

        $loaner = Loaner::get($did);
        Log::error("dddd::" . $loaner['phone']);
        if (!empty($loaner)) {
            $this->assign('loaner', $loaner);
            return $this->fetch('LoanerModify');
        } else {
            return $this->redirect('Index/index');
        }
    }

    public function modifyLoaner(){

    }

    /**
     *借款人显示信息
     */
    public function pBorrowerInfo()
    {
        $did = $this->request->param('lId');

        $borrower = Borrower::get($did);
        if (!empty($borrower)) {
            $frelist = FrequentContacts::where('borrower_id', $did)->select();
            if (!empty($frelist)) {
                $borrower['frelist'] = $frelist;
            }
            $this->assign('borrower', $borrower);
            return $this->fetch('BorrowerModify');
        } else {
            return $this->redirect('Index/index');

        }

    }

    /**
     *修改借款人
     */
    public function modifyVorrower(){

    }

}

?>