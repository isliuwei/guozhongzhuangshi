<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>国众装饰后台管理</title>
    <meta name="description" content="这是一个 table 页面">
    <meta name="keywords" content="table">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <base href="<?php echo site_url();?>">

    <link rel="icon" type="image/png" href="assets/i/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="assets/i/app-icon72x72@2x.png">
    <meta name="apple-mobile-web-app-title" content="Amaze UI" />
    <link rel="stylesheet" href="assets/css/amazeui.min.css"/>
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/amazeui.datatables.css"/>
    <style>
        .disabled{
            disabled: disabled;

        }
        button.remark{
            margin-top: 30px;
        }
    </style>


</head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，Amaze UI 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
    以获得更好的体验！</p>
<![endif]-->

<?php include 'admin-header.php'; ?>

<div class="am-cf admin-main">
    <?php include 'admin-sidebar.php'; ?>

    <!-- content start -->
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">反馈管理界面</strong> / <small>Feedback</small></div>
        </div>

        <!-- <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <button type="button" class="am-btn am-btn-default"><span class="am-icon-plus"></span> 新增</button>
                        <button type="button" id="checkAll" class="am-btn am-btn-default"><span class="am-icon-check"></span> 全选</button>
                        <button type="button" id="checkRev" class="am-btn am-btn-default"><span class="am-icon-undo"></span> 反选</button>
                        <button type="button" id="checkNo" class="am-btn am-btn-default"><span class="am-icon-remove"></span> 取消</button>
                        <button type="button" id="delChecked" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span> 删除</button>

                    </div>
                </div>
            </div>
        </div> -->
        

        <div class="am-g">
            <div class="am-u-sm-12 am-scrollable-horizontal">
                <!-- <table class="am-table am-table-striped am-table-hover table-main">
                <table class="am-table am-table-striped am-table-bordered am-table-compact" id="example">
                    <thead>
                        <tr>
                            <th class="table-check"><input type="checkbox" /></th>
                            <th class="table-id">ID</th>
                            <th class="table-title">微信ID</th>
                            <th class="table-type">反馈内容</th>
                            <th class="table-type">反馈时间</th>
                            <th class="table-type">操作</th>  
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($feedbacks as $feedback){
                        ?>
                        <tr>
                            <td><input type="checkbox" class="checkItem" value="<?php echo $feedback -> feedback_id; ?>"/></td>
                            <td><?php echo $feedback -> feedback_id; ?></td>
                            <td><?php echo $feedback -> weixin_id; ?></td>
                            <td><?php echo $feedback -> feedback_content; ?></td>
                            <td><?php echo $feedback -> feedback_time; ?></td>
                            <td>
                                <div class="am-btn-toolbar">
                                    <div class="am-btn-group am-btn-group-xs">
                                        <button href="admin/delete_admin" data-id="<?php echo $feedback -> feedback_id; ?>" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only am-btn-delete"><span class="am-icon-trash-o"></span> 删除</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table> -->
                <!-- <table width="100%" class="am-table am-table-striped am-table-bordered am-table-compact am-text-nowrap" id="my-table"> -->
                <table class="am-table am-table-striped am-table-hover table-main" id="my-table">
                    <!-- <table width="100%" class="am-table am-table-striped am-table-bordered am-table-compact am-text-nowrap" id="my-table"> -->

                  <thead>
                        <tr>
                            <th class="table-check"><input type="checkbox" /></th>
                            <th class="table-id">ID</th>
                            <th class="table-title">姓名</th>
                            <th class="table-type">服务类别</th>
                            <th class="table-type">地址</th>
                            <th class="table-type">联系方式</th>
                            <th class="table-type">预定时间</th>
                            <th class="table-type">操作<button href="admin/delete_admin"  type="button" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only" id="doc-prompt-toggle" data-am-popover="{content: '请输入管理员密码，否则无法进行删除操作！', trigger: 'hover focus'}"><span class="am-icon-trash-o"></span>验证</button></th>  


                                                <div class="am-modal am-modal-prompt" tabindex="-1" id="my-prompt">
                                                  <div class="am-modal-dialog">
                                                    <div class="am-modal-hd">删除提示</div>
                                                    <div class="am-modal-bd">
                                                      请输入管理员密码，否则无法进行删除操作！
                                                      <input type="text" class="am-modal-prompt-input">
                                                    </div>
                                                    <div class="am-modal-footer">
                                                      <span class="am-modal-btn" data-am-modal-cancel>取消</span>
                                                      <span class="am-modal-btn" data-am-modal-confirm>提交</span>
                                                    </div>
                                                  </div>
                                                </div>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $index = 0;
                            foreach($orders as $order){
                                $index++;
                                
                        ?>
                        <tr>
                            <td><input type="checkbox" class="checkItem" value="<?php echo $order -> order_id; ?>"/></td>
                           <!--  <td><?php echo $order -> order_id; ?></td> -->
                            <td><?php echo $index; ?></td>
                            <td><?php echo $order -> order_name; ?></td>
                            <td><?php echo $order -> order_type; ?></td>
                            <td><?php echo $order -> order_address; ?></td>
                            <td><?php echo $order -> order_tel; ?></td>
                            <td><?php echo $order -> order_time; ?></td>
                            <td>

                                <div class="am-btn-toolbar">
                                    <div class="am-btn-group am-btn-group-xs">
                                        <button href="admin/delete_admin" data-id="<?php echo $order -> order_id; ?>" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only am-btn-delete am-disabled" ><span class="am-icon-trash-o"></span> 删除</button>
                                        <!-- <button href="admin/delete_admin" data-id="<?php echo $order -> order_id; ?>" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only am-btn-success data-am-offcanvas="{target: '#doc-oc-demo3'}"" ><span class="am-icon-trash-o"></span> 备注</button> -->
                                        <button class="am-btn am-btn-default am-btn-success" data-am-offcanvas="{target: '#doc-oc-demo<?php echo $order -> order_id; ?>'}">显示备注</button>
                                        <div id="doc-oc-demo<?php echo $order -> order_id; ?>" class="am-offcanvas">
                                          <div class="am-offcanvas-bar am-offcanvas-bar-flip">
                                            <div class="am-offcanvas-content">
                                                <form class="am-form" method="post" action="">
                                                    <input type="hidden" name="order_id" value="<?php echo $order -> order_id; ?>">
                                                    <fieldset>
                                                        <legend style="color: #fff;">订单备注</legend>
                                                            <div class="am-form-group">
                                                              <label for="doc-ta-1">请输入订单备注信息</label>
                                                              <textarea  name="remark_content" class="remark_content" cols="30" rows="5" id="doc-ta-1" selector="order-remark<?php echo $order -> order_id; ?>"><?php echo $order -> order_remark; ?></textarea>
                                                            </div>

                                                            <button type="button" class="am-btn remark" data-id= "<?php echo $order -> order_id; ?>">保存</button>
                                                     </fieldset>
                                                </form>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                        
                            </td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                         
                  
                 
                </table>
            </div>

        </div>
    </div>

    <!-- content end -->
</div>

<a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu" data-am-offcanvas="{target: '#admin-offcanvas'}"></a>

<footer>
    <hr>
    <p class="am-padding-left">© 2014 AllMobilize, Inc. Licensed under MIT license.</p>
</footer>


<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="assets/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="assets/js/amazeui.min.js"></script>
<script src="assets/js/app.js"></script>

<script src="assets/js/amazeui.datatables.min.js"></script>
<script src="assets/js/dataTables.responsive.min.js"></script>

<script>
    $(function() {
            jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "chinese-string-asc": function(s1, s2) {
              return s1.localeCompare(s2);
            },

            "chinese-string-desc": function(s1, s2) {
              return s2.localeCompare(s1);
            }
        });

      $(function() {
        $('#my-table').DataTable();
        $('#my-table-r').DataTable({
          responsive: true,
          dom: 'ti'
        });

        $('#sorting-chinese').dataTable({
          columnDefs: [
            {type: 'chinese-string', targets: '_all'}
          ]
        });
      });


    });
    </script>



<script>
    $(function(){
        $('.am-btn-reply').on('click',function(){
            var openId =  $(this).data('id');
            location.href = "admin/admin_reply?openId="+openId;
        });

    });
</script>


<script>
    $(function() {
       $('.am-btn-delete').on('click',function(){
        alert('haha');
       });

      $('#doc-prompt-toggle').on('click', function() {

        $('#my-prompt').modal({
          relatedTarget: this,
          onConfirm: function(e) {
            $.get('admin/check_delete',{'pwd':e.data},function(res){
                if(res == "true"){
                    alert('你的密码输入正确！');
                    $('.am-btn-delete').removeClass('am-disabled');
                }else{
                    alert('你的密码输入错误，无法进行删除操作！');
                }
            });
          },
          onCancel: function(e) {
            alert('你的输入有误!');
          }
        });
      });
      //Ajax更新备注
      $('button.remark').on('click',function(){
        $order_id = $(this).data('id');
        $order_remark = $('textarea[selector*='+$order_id+']').val();
        
        $.get('admin/update_order_remark',{'order_id':$order_id,'order_remark':$order_remark},function(res){
            if(res=="success"){
                alert("修改成功");
            }
        });
      });
});
</script>
</body>
</html>
