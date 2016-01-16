<?php

namespace Admin\Controller;


use Think\Controller;

class GiiController extends Controller
{
public function index(){
    if(IS_GET){
        //get 方式时直接显示代码生成器主页
        $this->assign('meta_title','代码生成器');
        $this->display('index');
    }else{
        //编码
        header('Content-Type: text/html;charset=utf-8');
        //获取用户输入的表名生成tp规范表名
        $table_name=I("post.table_name");
        //parse_name生成规范的表名
        $name=parse_name($table_name,1);
//        dump($table_name);
//        dump($name);
        //通过表名查询得到其注解
        $sql = "select  TABLE_COMMENT from information_schema.`TABLES`  where TABLE_SCHEMA = '".C('DB_NAME')."' and TABLE_NAME = '{$table_name}'";
        $model = M();
        $rows = $model->query($sql);
        $meta_title = $rows[0]['table_comment'];
        //查询表中的字段信息,为主页和编辑页面的模型提供数据
        $sql = "show full columns from ".$table_name;
        $fields = $model->query($sql);  //fields中包含了当前表的每个字段的信息
       //从每列中取出注解的值
        foreach($fields as $k=>&$field){
            //因为id字段不用验证,所以将其从fields中删除
            if($field["field"]=="id"){
                unset($fields[$k]);//用删除键的方式删除
            }
            $comment=$field["comment"];
            if(strpos($comment,"@")!==false){//有@时
                $pattern="/(.*)@([a-z]*)\|?(.*)/";//用正则表达式匹配coment中的有用信息
                preg_match($pattern,$comment,$result);//用上面的正则表达式在coment中匹配将结果放在result中
                //匹配@前面的注释,取出索引为1的
                $field["comment"]=$result[1];
                //取出索引为2的,作为字段类型
                $field["field_type"]=$result[2];
                //匹配是否状态值
                if(!empty($result[3])){
                    parse_str($result[3],$option_values);//分割为数组
                    $field["option_values"]=$option_values;
                }
            }
        }
        unset($field);
        //定义模板目录
        defined("TPL_PATH") or define("TPL_PATH",ROOT_PATH."Template/");
        require TPL_PATH."Controller.tpl";
        //生成控制器,用到ob缓存,默认为开启的
        $controller_content = "<?php\r\n".ob_get_clean();
//        dump($controller_content);
        //定义控制器生成的目录
        $controller_path = APP_PATH.'Admin/Controller/'.$name.'Controller.class.php';
//        dump($controller_path);
//        exit;
        //将生成的控制器放到指定目录
        file_put_contents($controller_path,$controller_content);


        //生成模型
        ob_start();//再次开启ob缓存
        //加载模型模板文件
        require TPL_PATH.'Model.tpl';
        //生成模型...
        $model_content = "<?php\r\n".ob_get_clean();
        //定义模型生成的目录
        $model_path = APP_PATH.'Admin/Model/'.$name.'Model.class.php';
//        dump($model_content);
//        dump($model_path);
//        exit;
        //将生成的模型文件放到指定目录
        file_put_contents($model_path,$model_content);

        //生成edit页面
        ob_start();//开启缓存
        require TPL_PATH."edit.tpl";
        //生成编辑页面
        $edit_content=ob_get_clean();
        //定义编辑页面生成的目录
        $edit_dir=APP_PATH."Admin/View/".$name;
        //判断,如果视图文件目录不存在就创建
        if(!is_dir($edit_dir)){
            mkdir($edit_dir,0777,true);
        }
        $edit_path=$edit_dir."/edit.html";
        //将生成的编辑页面放到指定目录
        file_put_contents($edit_path,$edit_content);


        //生成index
        ob_start();//开启ob缓存
        require TPL_PATH.'index.tpl';
        $index_content = ob_get_clean();
        $index_dir = APP_PATH.'Admin/View/'.$name;
        if(!is_dir($index_dir)){
            mkdir($index_dir,0777,true);
        }
        $index_path = $index_dir.'/index.html';
        file_put_contents($index_path,$index_content);




        $this->success("生成成功..",U("index"));
    }

}
}