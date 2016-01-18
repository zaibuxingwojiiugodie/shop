<?php
namespace Admin\Controller;


use Think\Controller;

class GoodsController extends BaseController
{
    protected $meta_title = '商品';
    protected $usePostParams=true;

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

        //查询出会员级别数据
        $memberLevelModel=D("MemberLevel");
        $memberLevels=$memberLevelModel->getList("id,name");
        $this->assign("memberlevels",$memberLevels);
        //判断为编辑时
        $id = I('get.id');
        if(!empty($id)){
            //编辑时从goods_intro中查询出当前商品对应的商品简介
            $goodsIntroModel = M('GoodsIntro');
            $intro = $goodsIntroModel->getFieldByGoods_id($id,'intro');
            $this->assign('intro',$intro);

            //编辑时查询出每个商品每个会员级别对应的价格
            $goodsmemberpricemodel=D("GoodsMemberPrice");
//            dump($goodsmemberpricemodel);
            $memberPrices=$goodsmemberpricemodel->getMemberPrice($id);
//            dump($memberPrices);
            $this->assign("memberPrices",$memberPrices);


        }


    }

}