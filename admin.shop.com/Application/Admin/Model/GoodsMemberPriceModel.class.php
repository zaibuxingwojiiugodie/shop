<?php


namespace Admin\Model;


use Think\Model;

class GoodsMemberPriceModel extends Model
{
    public function getMemberPrice($goods_id){
        $rows=$this->field("member_level_id,price")->where(array("goods_id"=>$goods_id))->select();
        //取出member_level_id
        $member_level_ids=i_array_column($rows,"member_level_id");
        //取出price
        $prices=i_array_column($rows,"price");
        //将member_level_id作为键值,price作为值
        $row=array_combine($member_level_ids,$prices);
        return $row;
        dump($row);
    }
}