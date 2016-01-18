<?php
namespace Admin\Model;


use Think\Model;

class GoodsModel extends BaseModel
{
    // 每个表单都有自己不同的验证规则
//    protected $_validate = array(
//        array('name','require','商品名称不能够为空'),
//        array('short_name','require','简称不能够为空'),
//        array('sn','require','货号不能够为空'),
//        array('goods_category_id','require','商品分类不能够为空'),
//        array('brand_id','require','商品品牌不能够为空'),
//        array('supplier_id','require','供货商不能够为空'),
//        array('shop_price','require','本店价格不能够为空'),
//        array('market_price','require','市场价格不能够为空'),
//        array('logo','require','商品LOGO不能够为空'),
//        array('stock','require','库存不能够为空'),
//        array('goods_status','require','商品状态不能够为空'),
//        array('status','require','是否显示不能够为空'),

//
//    );
    protected function _setModel(){

        //连接其他表
        $this->join('__GOODS_CATEGORY__ as gc on obj.goods_category_id = gc.id ');
        $this->join('__BRAND__ as b on obj.brand_id = b.id ');
        $this->join('__SUPPLIER__ as s on obj.supplier_id = s.id ');
        //取出其他表中的name
        $this->field('obj.*,gc.name as goods_category_name,b.name as brand_name,s.name as supplier_name');
    }

public function add($requestData){
//    dump($requestData);
//    exit;
    //开启事物
    $this->startTrans();
    //不仅要将请求中的数据保存在goods表,还要讲简介保存到goods_intro表中
    $id= parent::add();//a调用父类的方法完成基本数据保存,返回id
    if($id==false){
        $this->rollback();//事物回滚
        return false;
    }
    //计算请求中的商品状态值
    $this->handleGoodsStatus();
//    exit;
    //计算当前的商品货号 并将其更新到数据库中,
    $sn=date("Ymd").str_pad($id,9,"0",STR_PAD_LEFT);//用当前日期和id生成货号
    $rst=parent::save(array("id"=>$id,"sn"=>$sn));
    if($rst==false){
        $this->error="保存货号失败..";
        $this->rollback();//事物回滚
        return false;
    }
    //再将请求中的intro数据保存到goodsintro表中
    $goodsintromodel=M("GoodsIntro");
    $rst=$goodsintromodel->add(array("goods_id"=>$id,"intro"=>$requestData["intro"]));//将请求中的intro信息保存在goods_intro表中
    if($rst==false){
        $this->error="保存商品描述失败..";
        $this->rollback();//事物回滚
        return false;
    }
    //保存商品的会员价格到商品价格表中
    $rst=$this->handleMemberPrice($id,$requestData['memberPrice']);
    if($rst===false){
        $this->rollback();//失败则回滚
        return false;
    }


    $this->commit();//提交事物
    return $id;
}
    public function save($requestData){
//        dump($requestData);
        $goods_id = $this->data['id'];

        $this->startTrans();//开启事务

        //将this->data中的数据更新到goods表中
        $this->handleGoodsStatus();//计算goods_status的值
        $result = parent::save();
        if($result===false){
            $this->rollback();//回滚
            return false;
        }
        //将intro数据更新到goods_intro表中
        $goodsIntroModel = M('GoodsIntro');
        $result1 = $goodsIntroModel->save(array('goods_id'=>$goods_id,'intro'=>$requestData['intro']));
        if($result1===false){
            $this->error = '更新商品描述失败,,,';
            $this->rollback();//回滚
            return false;
        }

        //更新会员价格
        $rst = $this->handleMemberPrice($goods_id,$requestData['memberPrice']);
        if($rst===false){
            return false;
        }


        $this->commit();
        return $result;
    }


    private function handleGoodsStatus(){
//        dump($this->data['goods_status']);
//        exit;
        //计算请求数据中的商品状态
        $goods_status=0;//将状态值初始化为0.之后的每个状态与之进行或运算
        foreach($this->data['goods_status'] as $gs){
            //每取出一个状态值便与当前状态进行或运算
            $goods_status = $goods_status | $gs;
        }
        //计算完成之后再放进goods_status中
        $this->data['goods_status']=$goods_status;
//        dump($this->data['goods_status']);
    }
    private function handleMemberPrice($goods_id,$memberPrices){
//        dump($memberPrices);
//        exit;
        $goodsMemberPriceModel = M('GoodsMemberPrice');
         //先删除,  如果添加方法使用到该函数, 不会删除任何数据
        $rst = $goodsMemberPriceModel->where(array('goods_id'=>$goods_id))->delete(); //delete from goods_member_price where goods_id = 7
        if($rst===false){
            $this->rollback();
            $this->error = '删除会员价格失败!';
            return false;
        }

        //再添加,,要保存当前商品的多个会员价格
        $rows = array();
        foreach ($memberPrices as $member_level_id => $price) {
            $rows[] = array('goods_id' => $goods_id, 'member_level_id' => $member_level_id, 'price' => $price);
//            dump($rows);
        }
        if (!empty($rows)) {
            $rst = $goodsMemberPriceModel->addAll($rows);
            if ($rst === false) {
                $this->error = '添加会员价格失败!';
                $this->rollback();
                return false;
            }
        }
    }
}