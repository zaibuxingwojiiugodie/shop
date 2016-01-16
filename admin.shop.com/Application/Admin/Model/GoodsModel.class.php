<?php
namespace Admin\Model;


use Think\Model;

class GoodsModel extends BaseModel
{
    // 每个表单都有自己不同的验证规则
    protected $_validate = array(
        array('name','require','商品名称不能够为空'),
array('short_name','require','简称不能够为空'),
array('sn','require','货号不能够为空'),
array('goods_category_id','require','商品分类不能够为空'),
array('brand_id','require','商品品牌不能够为空'),
array('supplier_id','require','供货商不能够为空'),
array('shop_price','require','本店价格不能够为空'),
array('market_price','require','市场价格不能够为空'),
array('logo','require','商品LOGO不能够为空'),
array('stock','require','库存不能够为空'),
array('goods_status','require','商品状态不能够为空'),
array('status','require','是否显示不能够为空'),


    );
}