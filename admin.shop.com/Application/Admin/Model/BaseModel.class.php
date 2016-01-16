<?php

namespace Admin\Model;


use Think\Model;
use Think\Page;

class BaseModel extends Model
{
//开启批量验证
    protected $patchValidate = true;
//用于更改状态和删除的方法,默认值为-1 表示删除
    public function changeStatus($id, $status = -1)
    {
        $data = array('status' => $status, 'id' => array("in", $id));
        //如果状态值为-1 则是删除状态,由于验证字段名是从数据库中查询所以添加一个删除标示,
        if ($status == -1) {
            $data["name"] = array("exp", "concat(name,'_del')");//exp 表示指定后面的参数是一个表达式,
        }
        return parent::save($data);
    }
//用于获取分页列表数据的方法
    public function getPage($wheres = array())
    {//设置默认值则在调用时可以不用传入参数都可以
        //查询条件, 分页的数据和总条数数据都是需要查询出状态大于1的记录
        $wheres["status"] = array("gt", -1);
        //准备分页工具条
        $pageHtml = "";
        $pageSize = 5;  //每页多少条
        $count = $this->where($wheres)->count();  //总条数
        $page = new Page($count, $pageSize);
        $pageHtml = $page->show();//生成分页的html
        //分页数据
        //如果起始条数大于总的条数就直接显示最后一页的数据
        if ($page->firstRow > $count) {
            //起始条数= 总条数-每页多少条
            $page->firstRow = $count - $page->listRows;
        }
        //得到分页后的每页的数据...
        $row = $this->where($wheres)->limit($page->firstRow, $page->listRows)->select();
        //返回分页数据
        return array("rows" => $row, "pageHtml" => $pageHtml);
    }
//查询出正常状态的数据
    public function getList($field="*")
    {
        return $this->field($field)->where(array('status' => array('gt', -1)))->select();
    }
}