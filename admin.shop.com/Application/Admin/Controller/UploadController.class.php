<?php


namespace Admin\Controller;


use Think\Controller;
use Think\Upload;

class UploadController extends Controller
{
    public function index()
    {
//        dump($_FILES);
        //��ȡ�����ָ���ķ���(�ռ�
        $dir=I("post.dir");
        $config = array(
//            'rootPath'     => './Uploads/', //�����·��
//            'savePath'     => $dir.'/', //����·��
            'rootPath'     => './', //���浽upyun�ĸ�·��
            'driver'=>'Upyun',
            'driverConfig' => array(
                'host'     => 'v0.api.upyun.com', //�����Ʒ�����
                'username' => 'xluo', //���Ĳ���Ա�û�
                'password' => 'lshaulu0.', //�����Ʋ���Ա����
                'bucket'   => $dir, //�ռ�����
                'timeout'  => 90, //��ʱʱ��
            ), // �ϴ���������
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