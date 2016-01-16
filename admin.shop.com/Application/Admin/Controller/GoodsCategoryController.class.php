<?php
namespace Admin\Controller;


use Think\Controller;

class GoodsCategoryController extends BaseController
{
protected $meta_title = '商品分类';
    public function index(){
        //查询出所需数据
        $rows=$this->model->getTreeList();
        //分配数据到页面
        $this->assign('meta_title',$this->meta_title);
        $this->assign("rows",$rows);
        //将当前的url保存在cookie中
        cookie("__nowurl__", $_SERVER["REQUEST_URI"]);

        //调用模板显示
        $this->display("index");
    }
    protected function _edit_view_before(){
        //准备页面中ztree需要的数据
        $rows = $this->model->getTreeList(true,'id,name,parent_id');
//        dump($rows);
        $this->assign('zNodes',$rows);
    }


}