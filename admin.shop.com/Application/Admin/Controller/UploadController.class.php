<?php


namespace Admin\Controller;


use Think\Controller;
use Think\Upload;

class UploadController extends Controller
{
    public function index()
    {
//        dump($_FILES);
        //获取浏览器指定的服务(空间
        $dir=I("post.dir");
        $config = array(
//            'rootPath'     => './Uploads/', //保存根路径
//            'savePath'     => $dir.'/', //保存路径
            'rootPath'     => './', //保存到upyun的根路径
            'driver'=>'Upyun',
            'driverConfig' => array(
                'host'     => 'v0.api.upyun.com', //又拍云服务器
                'username' => 'xluo', //又拍操作员用户
                'password' => 'lshaulu0.', //又拍云操作员密码
                'bucket'   => $dir, //空间名称
                'timeout'  => 90, //超时时间
            ), // 上传驱动配置
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