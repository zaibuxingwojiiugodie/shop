<?php


namespace Admin\Model;


use Think\Model;

class GoodsMemberPriceModel extends Model
{
    public function getMemberPrice($goods_id){
        $rows=$this->field("member_level_id,price")->where(array("goods_id"=>$goods_id))->select();
        //ȡ��member_level_id
        $member_level_ids=i_array_column($rows,"member_level_id");
        //ȡ��price
        $prices=i_array_column($rows,"price");
        //��member_level_id��Ϊ��ֵ,price��Ϊֵ
        $row=array_combine($member_level_ids,$prices);
        return $row;
        dump($row);
    }
}