<?php


namespace Admin\Controller;


use Think\Controller;
use Think\Upload;

class UploadController extends Controller
{
    public function index()
    {
//        dump($_FILES);
        //获取用户指定的文件上传到的文件夹
        $dir=I("post.dir");
        $config = array(
            'rootPath'     => './Uploads/', //保存根路径
            'savePath'     => $dir.'/', //保存路径
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