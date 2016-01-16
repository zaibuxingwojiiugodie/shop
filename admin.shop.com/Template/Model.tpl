namespace Admin\Model;


use Think\Model;

class <?php echo $name ?>Model extends BaseModel
{
    // 每个表单都有自己不同的验证规则
    protected $_validate = array(
        <?php  foreach($fields as $field){
               //主键id和可以为空的内容不用生成验证规则
              if($field['field']=='id' || $field['null']=='YES'){
                    continue;
              }
             echo "array('{$field['field']}','require','{$field['comment']}不能够为空'),\r\n";
        }   ?>


    );
}