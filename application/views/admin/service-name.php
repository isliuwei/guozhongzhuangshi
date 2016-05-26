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
        <div class="admin-content-body">
            <div class="am-cf am-padding">
                <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">首页</strong> / <small>一些常用模块</small></div>
            </div>

            <div class="am-g">
                <div class="am-u-sm-12">
                    <table class="am-table am-table-bd am-table-striped admin-content-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>服务类别</th>
                            <th>备注</th>
                            <th class="table-type">操作<button href="admin/delete_admin"  type="button" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only" id="doc-prompt-toggle" data-am-popover="{content: '请您在操作前输入管理员登录密码！', trigger: 'hover focus'}"><span class="am-icon-trash-o"></span>验证</button></th>  


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
                            foreach($services as $service){
                        ?>  
                        <tr>
                            <td><?php echo $service -> service_id ;?></td>
                            <td><a href="admin/write_item/<?php echo $service -> service_id ;?>"><?php echo $service -> service_name ;?></td>
                            <td><a href="admin/write_item/<?php echo $service -> service_id ;?>"><?php echo $service -> service_en_name ;?></a></td>
                            <td>
                                <div class="am-dropdown" data-am-dropdown>
                                    <button class="am-btn am-btn-default am-btn-xs am-dropdown-toggle am-disabled" data-am-dropdown-toggle ><span class="am-icon-cog"></span> <span class="am-icon-caret-down"></span></button>
                                    <ul class="am-dropdown-content">
                                        <li><a href="admin/update_service_mgr/<?php echo $service -> service_id;?>">1. 编辑</a></li>
                                        <li><a href="admin/delete_service_category/<?php echo $service -> service_id;?>">2. 删除</a></li>
                                    </ul>
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

        <footer class="admin-content-footer">
            <hr>
            <p class="am-padding-left">© 2014 AllMobilize, Inc. Licensed under MIT license.</p>
        </footer>
    </div>
    <!-- content end -->

</div>

<a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu" data-am-offcanvas="{target: '#admin-offcanvas'}"></a>
<span id="service_id" data-id="<?php echo $this -> uri -> segment(3) ;?>"></span>
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
<script>
 // $service_id = $('#service_id').data('id');
 //  localStorage["service_id"] = $service_id;
</script>
<script>
    $(function() {
      $('#doc-prompt-toggle').on('click', function() {
        $('#my-prompt').modal({
          relatedTarget: this,
          onConfirm: function(e) {
            $.get('admin/check_delete',{'pwd':e.data},function(res){
                if(res == "true"){
                    alert('你的密码输入正确！');
                    $('.am-dropdown-toggle').removeClass('am-disabled');
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