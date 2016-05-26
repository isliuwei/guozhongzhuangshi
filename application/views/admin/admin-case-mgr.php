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

    <div class="am-cf am-padding">
      <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">案例管理界面</strong> / <small>Case</small></div>
    </div>

    <div class="am-g">
      <div class="am-u-sm-12 am-u-md-6">
        <div class="am-btn-toolbar">
          <div class="am-btn-group am-btn-group-xs">
            <button type="button" class="am-btn am-btn-default"><span class="am-icon-plus"></span><a href="admin/admin_add_case"> 新增</a></button>
            
          </div>
        </div>
      </div>
    </div>

    <div class="am-g">
      <div class="am-u-sm-12">
          <table class="am-table am-table-striped am-table-hover table-main">
            <thead>
              <tr>
                <th class="table-check"><input type="checkbox" /></th>
                <th class="table-id">ID</th>
                <th class="table-title">案例客户</th>
                <th class="table-title">案例描述</th>
                <th class="table-type">案例图片1</th>
                <th class="table-type">案例图片2</th>
                <th class="table-type">案例地址</th>
                <th class="table-set">操作</th>
              </tr>
          </thead>
          <tbody>
          <?php
            foreach($cases as $case){
          ?>
              <tr>
                <td><input type="checkbox" /></td>
                <td><?php echo $case -> case_id; ?></td>
                <td><a href="#"><?php echo $case -> case_user; ?></a></td>
                <td><a href="#"><?php echo $case -> case_desc; ?></a></td>
                <td><img src="<?php echo $case -> case_img1; ?>" width="100px" height="50px" alt="" /></td>
                <td><img src="<?php echo $case -> case_img2; ?>" width="100px" height="50px" alt="" /></td>
                <td><a href="#"><?php echo $case -> case_add; ?></a></td>
               
                <td>
                  <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                      <button data-id="<?php echo $case -> case_id; ?>" class="am-btn am-btn-default am-btn-xs am-text-secondary am-btn-updata"><span class="am-icon-pencil-square-o"></span> 编辑</button>
                      <button data-id="<?php echo $case -> case_id; ?>" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only am-btn-delete"><span class="am-icon-trash-o"></span> 删除</button>
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


<!--弹出层-->
<div class="am-modal am-modal-alert" tabindex="-1" id="my-alert">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">Warning!</div>
    <div class="am-modal-bd">
      当前用户没有编辑权限
    </div>
    <div class="am-modal-footer">
      <span class="am-modal-btn">确定</span>
    </div>
  </div>
</div>
<!--弹出层-->

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

 $(function(){

   $('.am-btn-delete').on('click', function(){
     var caseId =  $(this).data('id');
     if(confirm('确定是否删除记录，不可恢复!?')){
       location.href = "admin/delete_case/"+caseId;
     }
   });

   $('.am-btn-updata').on('click', function(){
     var caseId =  $(this).data('id');
     if(confirm('确定是否更新记录，不可恢复!?')){
       location.href = 'admin/get_case/'+caseId;
     }
   });




 });
</script>
</body>
</html>
