<?php
namespace Admin\Model;


use Think\Model;

class ArticleModel extends BaseModel
{
    // 每个表单都有自己不同的验证规则
    protected $_validate = array(
        array('name','require','文章名称不能够为空'),
array('article_category_id','require','文章分类ID不能够为空'),
array('inputtime','require','录入时间不能够为空'),
array('status','require','是否显示不能够为空'),
    );
    //用自动完成功能准备录入时间
    protected $_auto=array(
        array("inputtime",NOW_TIME)
    );
//覆盖父类的连接表的钩子方法
    protected function _setModel(){
        //连接另外一个表
        $this->join('__ARTICLE_CATEGORY__ as ac on obj.article_category_id = ac.id');
        //指定查询出表中的字段
        $this->field('obj.*,ac.name as article_category_name');
    }

    public function add($requestData){
        $id=parent::add();//create收集的数据保存在Article表中
        if($id===false){
            $this->error="文章保存失败";
            return false;
        }
        $articleContentModel=D("ArticleContent");
        $rst=$articleContentModel->add(array("article_id"=>$id,"content"=>$requestData['content']));
        if($rst==false){
            return false;
        }
        return $id;
    }
}