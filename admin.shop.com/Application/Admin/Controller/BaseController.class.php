<?php

namespace Admin\Controller;


use Think\Controller;

class BaseController extends Controller
{

    protected $model;
    protected $usePostParams=false;//是否使用post中的所有数据,默认为false不使用

    public function index()
    {

        //获取用来搜索的关键字
        $keyword = I("get.keyword", "");
        if (!empty($keyword)) {
            $wheres["name"] = array("like", "{$keyword}%");//where name like $keyword
        }
        //查询数据,分页后的数据
        $rows = $this->model->getPage($wheres);
        //分配数据
        $this->assign($rows);
        //将当前的url保存在cookie中
        cookie("__nowurl__", $_SERVER["REQUEST_URI"]);
        $this->assign("meta_title",$this->meta_title);
        //调用展示页面
        $this->display("index");

    }
//更改显示状态和删除,删除时就是将其状态值改成-1,移除时就使用默认状态的-1
    public function changeStatus($id, $status = -1)
    {
        //模型中的方法 来更改其状态 ,
        $result = $this->model->changeStatus($id, $status);
        if ($result !== false) {
            //操作成功了就跳转到当前页面,从cookie中取出当前页面的url
            $this->success('操作成功..', cookie("__nowurl__"));
        } else {
            $this->error('操作失败..' . show_model_error($this->model));
        }
    }

    public function add()
    {
        if (IS_GET) {
            //get方式时 展示添加页面
            $this->assign("meta_title", "添加" . $this->meta_title);
            //查询所需数据
            $this->_edit_view_before();
            $this->display("edit");
        } else {
            //post提交时需要create收集数据并将其添加到数据库中
            if ($this->model->create() !== false) {//收集到了数据将将其用add方法添加
                //判断,添加成功时跳转,失败时提示信息
                if ($this->model->add($this->usePostParams?I('post.'):'')!== false) {
                    $this->success("添加成功..", U("index"));
                } else {
                    //添加失败提示错误信息
                    $this->error("添加失败" . show_model_error($this->model));
                }


            }
        }
    }

    public function edit($id)
    {
        //get提交时 根据id查询出相应的数据进行回显
        if (IS_GET) {
            $rows = $this->model->find($id);//查询一条数据用find
            //分配数据到页面
            $this->assign($rows);
            $this->_edit_view_before();
            $this->assign("meta_title", "编辑$this->meta_title");
            //调用显示页面
            $this->display("edit");
        } else {
            //post提交时用create方法收集数据,并用save方法更新到数据库涨
            if ($this->model->create() !== false) {//有数据时进行更新操作
                if ($this->model->save($this->usePostParams?I('post.'):'') !== false) {
                    //更新成功时跳转到cookie中保存的当前页面
                    $this->success("更新成功...", cookie("__nowurl__"));
                    return;
                }
                $this->error("更新失败.." . show_model_error($this->model));
            }
        }

    }
//此方法是为了让子类覆盖,不用此方法的就是调用这个空方法
    protected function _edit_view_before(){

    }

    public function _initialize()
    {
        //创建模型.由于这里创建属于局部变量所以需要用属性的方式 在外面存储
        $this->model = D(CONTROLLER_NAME);
    }
}