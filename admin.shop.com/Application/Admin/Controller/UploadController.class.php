<?php


namespace Admin\Controller;


use Think\Controller;
use Think\Upload;

class UploadController extends Controller
{
    public function index()
    {
//        dump($_FILES);
        //��ȡ�û�ָ�����ļ��ϴ������ļ���
        $dir=I("post.dir");
        $config = array(
            'rootPath'     => './Uploads/', //�����·��
            'savePath'     => $dir.'/', //����·��
            'driver'=>'',
            'driverConfig'=>array(),
        );
        $upload=new Upload($config);
        $rst=$upload->uploadOne($_FILES['Filedata']);
        if($rst!==false){
            echo $rst['savepath'].$rst['savename'];
        }else{
            $upload->getError();
        }
    }
}