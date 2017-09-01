<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2017 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: zhangyajun <448901948@qq.com>
// +----------------------------------------------------------------------

namespace think\paginator\driver;

use think\Paginator;

class Bootstrap extends Paginator
{

    /**
     * 上一页按钮
     * @param string $text
     * @return string
     */
    protected function getPreviousButton($text = "&laquo;")
    {

        if ($this->currentPage() <= 1) {
            return $this->getDisabledTextWrapper($text);
        }

        $url = $this->url(
            $this->currentPage() - 1
        );

        return $this->getPageLinkWrapper($url, $text);
    }

    /**
     * 下一页按钮
     * @param string $text
     * @return string
     */
    protected function getNextButton($text = '&raquo;')
    {
        if (!$this->hasMore) {
            return $this->getDisabledTextWrapper($text);
        }

        $url = $this->url($this->currentPage() + 1);

        return $this->getPageLinkWrapper($url, $text);
    }

    /**
     * 页码按钮
     * @return string
     */
    protected function getLinks()
    {
//        if ($this->simple)
//            return '';

        $block = [
            'first'  => null,
            'slider' => null,
            'last'   => null
        ];

        $side   = 3;
        $window = $side * 2;

        if ($this->lastPage < $window + 6) {
            $block['first'] = $this->getUrlRange(1, $this->lastPage);
        } elseif ($this->currentPage <= $window) {
            $block['first'] = $this->getUrlRange(1, $window + 2);
            $block['last']  = $this->getUrlRange($this->lastPage - 1, $this->lastPage);
        } elseif ($this->currentPage > ($this->lastPage - $window)) {
            $block['first'] = $this->getUrlRange(1, 2);
            $block['last']  = $this->getUrlRange($this->lastPage - ($window + 2), $this->lastPage);
        } else {
            $block['first']  = $this->getUrlRange(1, 2);
            $block['slider'] = $this->getUrlRange($this->currentPage - $side, $this->currentPage + $side);
            $block['last']   = $this->getUrlRange($this->lastPage - 1, $this->lastPage);
        }

        $html = '';

        if (is_array($block['first'])) {
            $html .= $this->getUrlLinks($block['first']);
        }

        if (is_array($block['slider'])) {
            $html .= $this->getDots();
            $html .= $this->getUrlLinks($block['slider']);
        }

        if (is_array($block['last'])) {
            $html .= $this->getDots();
            $html .= $this->getUrlLinks($block['last']);
        }

        return $html;
    }

//    /**
//     * 渲染分页html
//     * @return mixed
//     */
//    public function render()
//    {
//        if ($this->hasPages()) {
//            if ($this->simple) {
//                return sprintf(
//                    '<ul class="pager">%s %s</ul>',
//                    $this->getPreviousButton(),
//                    $this->getNextButton()
//                );
//            } else {
//                return sprintf(
//                    '<ul class="pagination">%s %s %s</ul>',
//                    $this->getPreviousButton(),
//                    $this->getLinks(),
//                    $this->getNextButton()
//                );
//            }
//        }
//    }



    /**
     * 渲染分页html
     * @return mixed
     */
    public function render()
    {
        if ($this->hasPages()) {
            if ($this->simple) {
//                return sprintf(
//                    '<ul class="pager">%s %s</ul>',
//                    $this->getPreviousButton(),
//                    $this->getNextButton()
//                );
                return $this->showSimplePager($this->getCurrentPath(),$this->currentPage,$this->listRows(),$this->total());
            } else {
//                return sprintf(
//                    '<ul class="pagination">%s %s %s</ul>',
//                    $this->getPreviousButton(),
//                    $this->getLinks(),
//                    $this->getNextButton()
//                );

               return $this->showPager($this->getCurrentPath(),$this->currentPage,$this->listRows(),$this->total());
            }
        }
    }

//<ul class="pagination">
//<li class="disabled"><span>&laquo;</span></li>
//<li class="active"><span>1</span></li>
//<li><a href="/txym-credit/public/admin/Aloaner/index?page=2">2</a>
//</li> <li><a href="/txym-credit/public/admin/Aloaner/index?page=2">&raquo;</a></li>
//</ul>


    //显示当前页的前后页数  4,5,6,七,8,9,10
    const OFFSET=3;

    protected  function showPager($link,&$page_no,$page_size,$row_count){
        $url="";
        $params="";
        if($link != ""){
            $pos = strpos($link,"?");

            if($pos ===false ){
                $url = $link;
            }else{
                $url=substr($link,0,$pos);
                $params=substr($link,$pos+1);
            }
        }

        $navibar = "<div class=\"pagination\"><ul>";
        $offset=self::OFFSET;
        //$page_size=10;
        $total_page=$row_count%$page_size==0?$row_count/$page_size:ceil($row_count/$page_size);

        $page_no=$page_no<1?1:$page_no;
        $page_no=$page_no>($total_page)?($total_page):$page_no;
        if ($page_no > 1){
            $navibar .= "<li><a href=\"$url?$params&page=1\">首页</a></li>\n <li><a href=\"$url?$params&page=".($page_no-1)." \">上一页</a></li>\n";
        }
        /**** 显示页数 分页栏显示11页，前5条...当前页...后5条 *****/
        $start_page = $page_no -$offset;
        $end_page =$page_no+$offset;
        if($start_page<1){
            $start_page=1;
        }
        if($end_page>$total_page){
            $end_page=$total_page;
        }
        for($i=$start_page;$i<=$end_page;$i++){
            if($i==$page_no){
                $navibar.= "<li><span>$i</span></li>";
            }else{
                $navibar.= "<li><a href=\"$url?$params&page=$i \">$i</a></li>";
            }
        }

        if ($page_no < $total_page){
            $navibar .= "<li><a href=\"$url?$params&page=".($page_no+1)."\">下一页</a></li>\n <li><a href=\"$url?$params&page=$total_page\">末页</a></li>\n ";
        }
        if($total_page>0){
            $navibar.="<li><a>".$page_no ."/". $total_page."</a></li>";
        }
        if ($row_count > 0) {
            $navibar .= "<li><a>共" . $row_count . "条</a></li>";
        }
        $jump ="";
        //$jump ="<li><form action='$url' method='GET' name='jumpForm'><input type='text' name='page_no' value='$page_no'></form></li>";

        $navibar.=$jump;
        $navibar.="</ul></div>";

        return $navibar;
    }

    /**
     * @param $link
     * @param $page_no
     * @param $page_size
     * @param $row_count
     *  简单page
     * @return string
     */
    protected  function showSimplePager($link,&$page_no,$page_size,$row_count){
        $url="";
        $params="";
        if($link != ""){
            $pos = strpos($link,"?");

            if($pos ===false ){
                $url = $link;
            }else{
                $url=substr($link,0,$pos);
                $params=substr($link,$pos+1);
            }
        }

        $navibar = "<div class=\"pagination\"><ul>";
        $offset=self::OFFSET;
        //$page_size=10;
        $total_page=$row_count%$page_size==0?$row_count/$page_size:ceil($row_count/$page_size);

        $page_no=$page_no<1?1:$page_no;
        $page_no=$page_no>($total_page)?($total_page):$page_no;
        if ($page_no > 1){
            $navibar .= "<li><a href=\"$url?$params&page=1\">首页</a></li>\n <li><a href=\"$url?$params&page=".($page_no-1)." \">上一页</a></li>\n";
        }
        /**** 显示页数 分页栏显示11页，前5条...当前页...后5条 *****/
        $start_page = $page_no -$offset;
        $end_page =$page_no+$offset;
        if($start_page<1){
            $start_page=1;
        }
        if($end_page>$total_page){
            $end_page=$total_page;
        }
        for($i=$start_page;$i<=$end_page;$i++){
            if($i==$page_no){
                $navibar.= "<li><span>$i</span></li>";
            }else{
                $navibar.= "<li><a href=\"$url?$params&page=$i \">$i</a></li>";
            }
        }

        if ($page_no < $total_page){
            $navibar .= "<li><a href=\"$url?$params&page=".($page_no+1)."\">下一页</a></li>\n <li><a href=\"$url?$params&page=$total_page\">末页</a></li>\n ";
        }
        if($total_page>0){
            $navibar.="<li><a>".$page_no ."/". $total_page."</a></li>";
        }
       // $navibar.="<li><a>共".$row_count."条</a></li>";
        $jump ="";
        //$jump ="<li><form action='$url' method='GET' name='jumpForm'><input type='text' name='page_no' value='$page_no'></form></li>";

        $navibar.=$jump;
        $navibar.="</ul></div>";

        //error_log("bootstarp::".$navibar);
        return $navibar;
    }

    /**
     * 生成一个可点击的按钮
     *
     * @param  string $url
     * @param  int    $page
     * @return string
     */
    protected function getAvailablePageWrapper($url, $page)
    {
        return '<li><a href="' . htmlentities($url) . '">' . $page . '</a></li>';
    }

    /**
     * 生成一个禁用的按钮
     *
     * @param  string $text
     * @return string
     */
    protected function getDisabledTextWrapper($text)
    {
        return '<li class="disabled"><span>' . $text . '</span></li>';
    }

    /**
     * 生成一个激活的按钮
     *
     * @param  string $text
     * @return string
     */
    protected function getActivePageWrapper($text)
    {
        return '<li class="active"><span>' . $text . '</span></li>';
    }

    /**
     * 生成省略号按钮
     *
     * @return string
     */
    protected function getDots()
    {
        return $this->getDisabledTextWrapper('...');
    }

    /**
     * 批量生成页码按钮.
     *
     * @param  array $urls
     * @return string
     */
    protected function getUrlLinks(array $urls)
    {
        $html = '';

        foreach ($urls as $page => $url) {
            $html .= $this->getPageLinkWrapper($url, $page);
        }

        return $html;
    }

    /**
     * 生成普通页码按钮
     *
     * @param  string $url
     * @param  int    $page
     * @return string
     */
    protected function getPageLinkWrapper($url, $page)
    {
        if ($page == $this->currentPage()) {
            return $this->getActivePageWrapper($page);
        }

        return $this->getAvailablePageWrapper($url, $page);
    }
}
