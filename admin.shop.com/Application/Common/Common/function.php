<?php
function show_model_error($model)
{
    //得到model中的错误信息
    $errors = $model->getError();
    $errorMsg = '<ul>';
    if (is_array($errors)) {
        //如果是数组将错误信息拼成一个ul
        foreach ($errors as $error) {
            $errorMsg .= "<li>{$error}</li>";
        }
    } else {
        $errorMsg .= "<li>{$errors}</li>";
    }
    $errorMsg .= '</ul>';
    return $errorMsg;
}
function arr2select($name,$rows,$defalutValue="" ,$valueField="id",$textField="name"){
//    dump(func_get_args());
    $select_html='<select class="{$name}" name="{$name}">';
    $select_html.="<option value=''>--请选择--</option>";
    foreach($rows as $row){
        $selected="";
        //根据默认值选中一个选项
        if($row[$valueField]===$defalutValue){
            $selected="selected";
        }
        $select_html.="<option value='{$row['id']}'>{$row['name']}</option>";
    }
    $select_html.='</select>';
//    dump($select_html);
    echo $select_html;
}