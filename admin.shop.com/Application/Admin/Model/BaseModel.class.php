<?php

namespace Admin\Model;


use Think\Model;
use Think\Page;

class BaseModel extends Model
{
//����������֤
    protected $patchValidate = true;
//���ڸ���״̬��ɾ���ķ���,Ĭ��ֵΪ-1 ��ʾɾ��
    public function changeStatus($id, $status = -1)
    {
        $data = array('status' => $status, 'id' => array("in", $id));
        //���״ֵ̬Ϊ-1 ����ɾ��״̬,������֤�ֶ����Ǵ����ݿ��в�ѯ�������һ��ɾ����ʾ,
        if ($status == -1) {
            $data["name"] = array("exp", "concat(name,'_del')");//exp ��ʾָ������Ĳ�����һ�����ʽ,
        }
        return parent::save($data);
    }
//���ڻ�ȡ��ҳ�б����ݵķ���
    public function getPage($wheres = array())
    {//����Ĭ��ֵ���ڵ���ʱ���Բ��ô������������
        //��ѯ����, ��ҳ�����ݺ����������ݶ�����Ҫ��ѯ��״̬����1�ļ�¼
        $wheres["obj.status"] = array("gt", -1);
        //׼����ҳ������
        $pageHtml = "";
        $pageSize = 5;  //ÿҳ������
        $this->alias('obj');
        $count = $this->where($wheres)->count();  //������
        $page = new Page($count, $pageSize);
        $pageHtml = $page->show();//���ɷ�ҳ��html
        //��ҳ����
        //�����ʼ���������ܵ�������ֱ����ʾ���һҳ������
        if ($page->firstRow > $count) {
            //��ʼ����= ������-ÿҳ������
            $page->firstRow = $count - $page->listRows;
        }
        //Ϊ��ȡ������
        $this->alias('obj');
        $this->_setModel();//���ù��ӷ���
        //�õ���ҳ���ÿҳ������...
        $row = $this->where($wheres)->limit($page->firstRow, $page->listRows)->select();
        //���ط�ҳ����
        return array("rows" => $row, "pageHtml" => $pageHtml);
    }
    //���ӷ�����Ҫ���ڱ����า��
    protected function _setModel(){

    }


//��ѯ������״̬������
    public function getList($field = "*",$wheres=array())
    {
        $wheres['status'] = array('gt', -1);
        return $this->field($field)->where($wheres)->select();
    }
}