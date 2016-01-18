<?php
namespace Admin\Controller;


use Think\Controller;

class ArticleController extends BaseController
{
protected $meta_title = '文章';
    protected $usePostParams=true;//是否使用post中的所有数据,默认为false不使用

    public function _edit_view_before(){
        //准备文章分类的数据
        $articlecategorymodel=D("ArticleCategory");
        $articlecategorys=$articlecategorymodel->getList("id,name");
        $this->assign("articlecategroys",$articlecategorys);

        $id=I("get.id");
        if(!empty($id)){
            //在编辑时 从Article_content表中取出content
            $articleContentModel=M("ArticleContent");
            $content=$articleContentModel->getFieldByArticle_id($id,"content");
            $this->assign("content",$content);
        }
    }
    public function search($keyword){
        $wheres = array();
        if(!empty($keyword)){
            $wheres['name'] = array('like',"%{$keyword}%");
        }

        $rows = $this->model->getList('id,name',$wheres);
        //该方法会将传递进去的数据变成json发送给浏览器
        $this->ajaxReturn($rows);
    }
}