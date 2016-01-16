<?php
namespace Admin\Model;


use Admin\Service\NestedSetsService;
use Think\Model;

class GoodsCategoryModel extends BaseModel
{
    // 每个表单都有自己不同的验证规则
    protected $_validate = array(
        array('name','require','分类名称不能够为空'),
        array('parent_id','require','父分类不能够为空'),
        array('status','require','是否显示不能够为空'),
    );
    public function getTreeList($isJSON=false,$field="*"){
//dump(func_get_args());
        //查询出正常状态下的分类数据并按照左边界排序
        $row=$this->field($field)->where(array("status"=>array("egt",0)))->order("lft")->select();
        if($isJSON){
            //将数据变为json数据
            $row=json_encode($row);
//            dump($row);
            return $row;
        }

        return $row;
    }

    public function add(){
        //创建能够执行sql的对象
        $dbmysql=new DbMysqlInterfaceImplModel();
        //计算边界,需要传入一份能够执行sql的对象
        $nestedsetsservice=new NestedSetsService($dbmysql,'goods_category','lft','rgt','parent_id','id','level');
        //设置添加的节点保存在哪个父节下,并返回该节点的id
        $nestedsetsservice->insert($this->data['parent_id'],$this->data,'bottom');
    }
    public function save(){
        //创建能够执行sql的对象
        $dbMysql = new DbMysqlInterfaceImplModel();
        //计算边界
        $nestedSetsService = new NestedSetsService($dbMysql,'goods_category','lft','rgt','parent_id','id','level');
        //将指定的节点移动一个父分类下面
        $nestedSetsService->moveUnder($this->data['id'],$this->data['parent_id']);
        //需要将请求中的其他数据修改到数据库中
        return parent::save();
    }
    //用于更改状态和删除的方法,默认值为-1 表示删除
    public function changeStatus($id, $status = -1)
    {
        //要实现改变父节点的状态把属于他的子节点状态一起更改
        //通过自身id找到子孙以及自己
        $sql="select child.id from goods_category as child,goods_category as parent where parent.id={$id} and child.lft>=parent.lft and child.rgt<=parent.rgt";
        $rows=$this->query($sql);//执行sql得到所需id的集合
        //用foreach循环取出id
        $id=array();
        foreach($rows as $row){
            $id[]=$row['id'];
        }
        $data = array('status' => $status, 'id' => array("in", $id));
        //如果状态值为-1 则是删除状态,由于验证字段名是从数据库中查询所以添加一个删除标示,
        if ($status == -1) {
            $data["name"] = array("exp", "concat(name,'_del')");//exp 表示指定后面的参数是一个表达式,
        }
        return parent::save($data);
    }


}