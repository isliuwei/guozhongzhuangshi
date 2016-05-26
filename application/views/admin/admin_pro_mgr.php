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
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">产品管理界面</strong> / <small>Feedback</small></div>
        </div>

        <div class="am-g">
      <div class="am-u-sm-12 am-u-md-6">
        <div class="am-btn-toolbar">
          <div class="am-btn-group am-btn-group-xs">
            <button type="button" class="am-btn am-btn-default"><span class="am-icon-plus"></span><a href="admin/admin_add_pro/<?php echo $this -> uri -> segment(3);?>"> 新增</a></button>
            
          </div>
        </div>
      </div>
    </div>
        <div class="am-g">
            <div class="am-u-sm-12 am-scrollable-horizontal">
                
                <table class="am-table am-table-striped am-table-hover table-main" id="my-table">
                    
                  <thead>
                        <tr>
                            <th class="table-check"><input type="checkbox" /></th>
                            <th class="table-id">ID</th>
                            <th class="table-title">产品名称</th>
                            <th class="table-type">产品价格</th>
                            <th class="table-type">产品配图</th>
                            <th class="table-type">产品商家</th>
                            <th class="table-type">商家地址</th>
                            <th class="table-type">商家电话</th>
                            <th class="table-type">操作<!-- <button href="admin/delete_admin"  type="button" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only" id="doc-prompt-toggle" data-am-popover="{content: '请您在操作前输入管理员登录密码！', trigger: 'hover focus'}"><span class="am-icon-trash-o"></span>验证</button> --></th>  


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
                            foreach($products as $product){
                                $index++;
                                
                        ?>
                        <tr>
                            <td><input type="checkbox" class="checkItem" value="<?php echo $product -> product_id; ?>"/></td>
                            <td><?php echo $index; ?></td>
                            <td><?php echo $product -> product_name; ?></td>
                            <td><?php echo $product -> product_price; ?></td>
                            <td><img src="<?php echo $product -> product_img; ?>" width="100px" height="50px" alt="" /></td>
                            <td><?php echo $product -> product_business; ?></td>
                            <td><?php echo $product -> business_address; ?></td>
                            <td><?php echo $product -> business_phone; ?></td>
                            
                            <td>

                                <div class="am-btn-toolbar">
                                    <div class="am-btn-group am-btn-group-xs">
                                        <!-- <button href="admin/edit_pro" data-id="<?php echo $product -> product_id; ?>" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only am-btn-update am-disabled"><span class="am-icon-pencil"></span> 编辑</button> -->
                                        <!-- <button href="admin/delete_pro" data-id="<?php echo $product -> product_id; ?>" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only am-btn-delete am-disabled"><span class="am-icon-trash-o"></span> 删除</button> -->
                                        <button href="admin/edit_pro" data-id="<?php echo $product -> product_id; ?>" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only am-btn-update "><span class="am-icon-pencil"></span> 编辑</button>
                                        <button href="admin/delete_pro" data-id="<?php echo $product -> product_id; ?>" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only am-btn-delete "><span class="am-icon-trash-o"></span> 删除</button>
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

   $('.am-btn-delete').on('click', function(){
     var proId =  $(this).data('id');
     if(confirm('确定是否删除记录，不可恢复!?')){
       location.href = "admin/delete_pro/"+proId;
     }
   });

   $('.am-btn-update').on('click', function(){
     var proId =  $(this).data('id');
     if(confirm('确定是否更新记录，不可恢复!?')){
       location.href = 'admin/get_pro/'+proId;
     }
   });




 });
</script>



<script>
    $(function() {
      $('#doc-prompt-toggle').on('click', function() {
        $('#my-prompt').modal({
          relatedTarget: this,
          onConfirm: function(e) {
            $.get('admin/check_delete',{'pwd':e.data},function(res){
                if(res == "true"){
                    //alert('你的密码输入正确！');
                    $('.am-btn-update').removeClass('am-disabled');
                    $('.am-btn-delete').removeClass('am-disabled');
                }else{
                    alert('你的密码输入错误，无法进行后续操作！');
                }
            });
          },
          onCancel: function(e) {
            alert('你的输入有误!');
          }
        });
      });
});
</script>
</body>
</html>
