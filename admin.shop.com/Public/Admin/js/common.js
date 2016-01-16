$(function(){
    //实现全选功能
    //首先找到要操作的按钮
    $(".selectAll").click(function(){
        //找到所有的id框,将全选按钮的状态赋值给他便实现全选功能
        $(".ids").prop("checked",$(this).prop("checked"))
    });
    //实现全部选中状态下全选,其他情况不
    //如果找到没有被选中的id复选框长度为0的话表示是全选状态
    $(".ids").click(function(){
        $(".selectAll").prop("checked",$(".ids:not(:checked)").length==0);
    });





  //ajax的get请求,点击标签时触发事件,发送ajax请求
  $(".ajax_get").click(function(){
      //从当前标签中得到请求的url地址
    var url=$(this).attr("href");
      console.debug(url);
    //发送ajax请求
    $.get(url,showajax);
    return false;//取消默认操作
  })

  //ajax   post请求
    $(".ajax_post").click(function(){
        //通过当前标签向上查找,找到form.得到其action便是请求的url
        var form=$(this).closest("form");
        var url=form.attr("action");
        if(form.length!==0){
            //form.ajaxSubmit({success:showAjaxLayer});
            //序列化要提交的表单请求数据
            var params=form.serialize();
            //发送ajax post请求
            $.post(url,params,showajax);
        }else{
            //得到删除按钮上的url
            var url=$(this).attr("url");

            //得到选中的id
            var params=$(".ids:checked").serialize();
            console.debug(params);
            //发送ajax post请求
            $.post(url,params,showajax);

        }
        //取消默认操作
        return false;
    })

})



//显示提示框的回调函数
function showajax(data){
  var icon;//操作结果的标示,提示框的图标
  console.debug(data);
  console.debug(data.status);
  console.debug(data.info);
  if(data.status){
      //成功时的标示
    icon=1;
  }else{
    //失败时为2
    icon=2;
  }
//layer.msg("66666");
  layer.msg(data.info,{
        time:1000,
        offset:0,
        shift:6,
        icon:icon
      },function(){//此函数会在提示框隐藏后执行
        if(data.url){
          location.href=data.url;
        }
      });
}