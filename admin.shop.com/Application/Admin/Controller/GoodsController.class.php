<?php
namespace Admin\Controller;


use Think\Controller;

class GoodsController extends BaseController
{
protected $meta_title = '商品';

    //覆盖钩子方法,为页面展示之前准备数据
    protected function _edit_view_before(){
        //查询出商品分类的数据
        $goodscategorymodel=D("GoodsCategory");
        $rows=$goodscategorymodel->getTreeList(true,'id,name,parent_id');
        //分配数据到页面
        $this->assign("zNodes",$rows);

        //查询出品牌数据
        $brandmodel=D("Brand");
        $brands=$brandmodel->getList("id,name");
        $this->assign("brands",$brands);

        //查询出供应商数据
        $suppliermodel=D("Supplier");
        $suppliers=$suppliermodel->getList("id,name");
        $this->assign("suppliers",$suppliers);


    }
}