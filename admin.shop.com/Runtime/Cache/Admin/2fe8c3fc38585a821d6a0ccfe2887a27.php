<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - <?php echo ($meta_title); ?> </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://admin.shop.com/Public/Admin/css/general.css" rel="stylesheet" type="text/css" />
<link href="http://admin.shop.com/Public/Admin/css/main.css" rel="stylesheet" type="text/css" />
<link href="http://admin.shop.com/Public/Admin/css/common.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="http://admin.shop.com/Public/Admin/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">

</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('index');?>"><?php echo mb_substr($meta_title,2,null,'utf-8');?>列表</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo ($meta_title); ?> </span>
    <div style="clear:both"></div>
</h1>


    <div id="tabbar-div">
        <p>
            <span class="tab-front">通用信息</span>
            <span class="tab-back">详细描述</span>
            <span class="tab-back">会员价格</span>
            <span class="tab-back">商品属性</span>
            <span class="tab-back">商品相册</span>
            <span class="tab-back">关联文章</span>
        </p>
    </div>
    <div class="main-div">
        <form method="post" action="<?php echo U();?>">
            <table cellspacing="1" cellpadding="3" width="100%">
                <tr>
                    <td class="label">商品名称</td>
                    <td>
                        <input type='text' name='name' maxlength='60' value='<?php echo ($name); ?>'/> <span
                            class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">简称</td>
                    <td>
                        <input type='text' name='short_name' maxlength='60' value='<?php echo ($short_name); ?>'/> <span
                            class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品分类</td>
                    <td>
                        <!--保存父分类的ID-->
                        <input type="hidden"  class="goods_category_id" name="goods_category_id" value="<?php echo ($goods_category_id); ?>">
                        <!--存放父分类名字.-->
                        <input type='text' class="goods_category_name" name='goods_category_name' maxlength='60' value='必须选择最子分类' disabled="disabled"/>
                        <style type="text/css">
                            .ztree{
                                margin-top: 10px;
                                border: 1px solid #617775;
                                background: #f0f6e4;
                                width: 220px;
                                height: auto;
                                overflow-y: scroll;
                                overflow-x: auto;
                            }
                        </style>
                        <ul id="treeDemo" class="ztree"></ul>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品品牌</td>
                    <td>
                        <!-- 生成下拉框的函数,传入名字和数据便生成一个下拉框-->
                     <?php echo arr2select('brand_id',$brands);?>

                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">供货商</td>
                    <td>
                        <!-- 生成下拉框的函数,传入名字和数据便生成一个下拉框-->
                        <?php echo arr2select('supplier_id',$suppliers);?>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">本店价格</td>
                    <td>
                        <input type='text' name='shop_price' maxlength='60' value='<?php echo ($shop_price); ?>'/> <span
                            class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">市场价格</td>
                    <td>
                        <input type='text' name='market_price' maxlength='60' value='<?php echo ($market_price); ?>'/> <span
                            class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品LOGO</td>
                    <td>
                        <input type='file' id="goods_logo" name='goods_logo' maxlength='60'/>
                        <input type='hidden' class="logo" name='logo' maxlength='60'/>
                        <!-- 显示预览图片的div-->
                        <div class="upload-img-box" style="display: none">
                            <div class="upload-pre-item">
                                <img src="">
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="label">库存</td>
                    <td>
                        <input type='text' name='stock' maxlength='60' value='<?php echo ($stock); ?>'/> <span
                            class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品状态</td>
                    <td>
                        <input type='checkbox' class='goods_status' name='goods_status[]' value='1'/> 精品
                        <input type='checkbox' class='goods_status' name='goods_status[]'  value='2'/> 新品
                        <input  type='checkbox' class='goods_status' name='goods_status[]' value='4'/> 热销
                        <span  class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">是否显示</td>
                    <td>
                        <input type='radio' class='status' name='status' value='1'/> 是<input type='radio' class='status'
                                                                                             name='status' value='0'/> 否
                        <span class="require-field">*</span>
                    </td>
                </tr>
            </table>
            <table cellspacing="1" cellpadding="3" width="100%" style="display: none">
                <tr>
                    <td colspan="2">
                        <textarea id="intro" name="intro"><?php echo ($intro); ?></textarea>
                    </td>
                </tr>
            </table>
            <table cellspacing="1" cellpadding="3" width="100%" style="display: none">
                <tr>
                    <td class="label">会员价格</td>
                    <td>
                        <input type='text' name='name' maxlength='60' value='<?php echo ($name); ?>'/> <span
                            class="require-field">*</span>
                    </td>
                </tr>
            </table>
            <table cellspacing="1" cellpadding="3" width="100%" style="display: none">
                <tr>
                    <td class="label">商品属性</td>
                    <td>
                        <input type='text' name='name' maxlength='60' value='<?php echo ($name); ?>'/> <span
                            class="require-field">*</span>
                    </td>
                </tr>
            </table>
            <table cellspacing="1" cellpadding="3" width="100%" style="display: none">
                <tr>
                    <td class="label">关联文章</td>
                    <td>
                        <input type='text' name='name' maxlength='60' value='<?php echo ($name); ?>'/> <span
                            class="require-field">*</span>
                    </td>
                </tr>
            </table>
            <table cellspacing="1" cellpadding="3" width="100%" style="display: none">
                <tr>
                    <td class="label">商品相册</td>
                    <td>
                        <input type='text' name='name' maxlength='60' value='<?php echo ($name); ?>'/> <span
                            class="require-field">*</span>
                    </td>
                </tr>
            </table>
            <div style="text-align: center">
                <input type="hidden" name="id" value="<?php echo ($id); ?>"/>
                <input type="submit" class="button ajax_post" value=" 确定 "/>
                <input type="reset" class="button" value=" 重置 "/>
            </div>

        </form>
    </div>

<div id="footer">
共执行 1 个查询，用时 0.018952 秒，Gzip 已禁用，内存占用 2.197 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
<script type="text/javascript" src="http://admin.shop.com/Public/Admin/js/jquery-1.11.2.js"></script>
<script type="text/javascript" src="http://admin.shop.com/Public/Admin/layer/layer.js"></script>
<script type="text/javascript" src="http://admin.shop.com/Public/Admin/js/jquery.form.js"></script>
<script type="text/javascript" src="http://admin.shop.com/Public/Admin/js/common.js"></script>
<script type="text/javascript">
    $(function(){
        //选中是否显示
        $('.status').val([<?php echo ((isset($status) && ($status !== ""))?($status):1); ?>]);

    });
</script>

    <!-- 加载需要的js-->
    <script type="text/javascript" src="http://admin.shop.com/Public/Admin/zTree/js/jquery.ztree.core-3.5.js"></script>
    <script type="text/javascript" src="http://admin.shop.com/Public/Admin/uploadify/jquery.uploadify.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="__UEDITOR__/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="__UEDITOR__/ueditor.all.min.js"> </script>

    <script type="text/javascript">
        $(function () {
            ////////////////////////////////////////////tab切换////////////////////////////////////////////////////////////////

            //完成tab的切换,找到标签加上点击事件
            $("#tabbar-div span").click(function () {
                //removeClass删除class.addClass添加class
                $("#tabbar-div span").removeClass("tab-front").addClass("tab-back");
                $(this).removeClass("tab-back").addClass("tab-front");
                //得到正在点击的span的索引 用到index
                var index = $(this).index();
                //将所有的table隐藏,在将点击的那个table显示出来
                $(".main-div form table").hide();
                $(".main-div form table").eq(index).show();//显示出点击的索引对应的table

                //当点击的索引为1 也就是点击的是详细描述的时候才初始化在线编辑器
                if(index==1){
//                    alert(index);
       ////////////////////////////////////////////////在线编辑器/////////////////////////////////
                    var editor =  UE.getEditor('intro',{    //第一个参数是表单元素的id   第二个参数是关于在线编辑器的配置
                        initialFrameHeight :400
                    });
                }
            });


    ///////////////////////////////////////////////////分类树/////////////////////////////////////////////////////////////////////

            //树结构的设置
            var setting = {
                data: {
                    simpleData: {
                        enable: true,
                        pIdKey: "parent_id",
                    }
                },
                callback: {
                    beforeClick: function(treeId, treeNode){
                        if(treeNode.isParent){
                            //显示出一个提示框
                            layer.msg('必须选中最子分类!', {
                                time:1000,  //等待时间后关闭
                                offset: 0,  //设置位置
                                icon:2,  //设置提示框中的图标
                            });
                        }

                        //商品必须选择到最子分类,返回true,不让用户选中
                        return  !treeNode.isParent;
                    },
                    onClick: function(event, treeId, treeNode){  //treeNode就是点击的这个节点
                        //将节点的id(就是数据库中的id) 和节点的name复制给  goods_category_id和goods_category_name表单元素
                        $('.goods_category_name').val(treeNode.name);
                        $('.goods_category_id').val( treeNode.id);

                    }
                }
            };
            //树的节点数据
            var zNodes = <?php echo ($zNodes); ?>;

            //找到ul,将ul变成一个树结构
            var treeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);


            <?php if(empty($id)): ?>//表示添加,  展开所有的节点
                    treeObj.expandAll(true);
            <?php else: ?>
            //表示编辑. 从treeObj中找到需要被选中的节点对象
            var goods_category_id = <?php echo ($goods_category_id); ?>;
            var node = treeObj.getNodeByParam('id',goods_category_id); //根据goods_category_id自己的值,找自己对应的节点
            treeObj.selectNode(node); //通过树对象treeObj 选中 找到的节点node

            //将选中的节点的名字和id赋值给表单元素
            $('.goods_category_name').val(node.name);
            $('.goods_category_id').val( node.id);<?php endif; ?>

 /////////////////////////////////////////////////////商品图片上传///////////////////////////////////////////////////
            $("#goods_logo").uploadify({
                height: 30,//插件高
                width: 100,//插件宽
                'buttonText': '上传图片',//插件按钮上显示的文字
                'debug': true,//开启调试模式
                'fileSizeLimit': '10MB',//限制上传图片的最大值为10MB
                'fileTypeExts': '*.jpg;*.jpeg;*.png;*.gif',//允许上传的图片类型
                //上传文件时额外传递过去的参数---->告知服务器上的IndexController中的index方法将来将文件上传到哪个文件夹下
                'formData': {'dir': 'goods'},
                'swf': 'http://admin.shop.com/Public/Admin/uploadify/uploadify.swf',//这个是flash插件的地址
                'uploader': "<?php echo U('Upload/index');?>",//这个是处理插件上传的文件.Upload控制器的index方法
                 'onUploadSuccess' : function(file, data, response) {  //data就是响应的 上传后的地址
                    $('.upload-img-box').show(); //显示出div
                    $('.upload-img-box .upload-pre-item img').attr('src','http://admin.shop.com/Uploads/'+data);
                    $('.logo').val(data);  //将上传后的路径同时也放到隐藏域中.. 一起提交给服务器.
                },
                'onUploadError' : function(file, errorCode, errorMsg, errorString) {
                    alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
                }
            })
        });
    </script>

</body>
</html>