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
    <!-- <link rel="stylesheet" href="assets/css/amazeui.min.css"/>
    <link rel="stylesheet" href="assets/css/amazeui.datatables.css"/> -->
</head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，Amaze UI 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
    以获得更好的体验！</p>
<![endif]-->

<?php include 'admin-header.php'; ?>

<div class="am-cf admin-main">
    <?php include 'admin-sidebar.php'; ?>
    <!-- sidebar end -->

<!-- content start -->
<div class="admin-content">

  <div class="am-cf am-padding">
    <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">新增界面</strong> / <small>Add</small></div>
  </div>

  <div class="am-tabs am-margin" data-am-tabs>
    <ul class="am-tabs-nav am-nav am-nav-tabs">
      <li class="am-active"><a href="#tab1">新增类别</a></li>
      <li><a href="#tab2">新增品牌</a></li>

    </ul>

    <div class="am-tabs-bd">
      <div class="am-tab-panel am-fade am-in am-active" id="tab1">
        <form action="admin/save_procate_mgr" method="post" class="am-form am-form-inline" enctype="multipart/form-data" data-am-validator>
          <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">类别名称</div>
            <div class="am-u-sm-8 am-u-md-4 am-u-end">
              <input type="text" name="procate_name" value="">
            </div>
          </div>
  
          

          <div class="am-margin">
            <input type="reset" class="am-btn am-btn-primary am-btn-xs" value="重置">
            <input type="submit" class="am-btn am-btn-primary am-btn-xs" value="提交保存">
            <button type="button" class="am-btn am-btn-primary am-btn-xs">放弃保存</button>
          </div>

        </form>
      </div>

      <div class="am-tab-panel am-fade" id="tab2">
        <form class="am-form" action="admin/save_procate_brand" method="post" enctype="multipart/form-data">
          <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">产品类别</div>
            <div class="am-u-sm-8 am-u-md-10" style="margin-bottom: 20px;">
            <select name="pro_cate_id" style="width:320px">
            <?php
                foreach($cates as $cate){
            ?>
                <option value="<?php echo $cate->pro_cate_id ;?>"><?php echo $cate->pro_cate_name;?></option>
            <?php
                }
            ?>
              </select>
            </div>

            <div class="am-u-sm-4 am-u-md-2 am-text-right">
              品牌名称
            </div>
            <div class="am-u-sm-8 am-u-md-4">
              <input type="text" name="brand_name" class="am-input-sm">
            </div>
            <div class="am-hide-sm-only am-u-md-6">*必填</div>
          </div>

          


          <div class="am-margin">
            <input type="reset" class="am-btn am-btn-primary am-btn-xs" value="重置">
            <input type="submit"  class="am-btn am-btn-primary am-btn-xs" value="提交保存">
            <button type="button" class="am-btn am-btn-primary am-btn-xs">放弃保存</button>
          </div>

        </form>
      </div>


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




<script id="editor" type="text/plain" style="width:1024px;height:500px;"></script>
<script src="assets/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="assets/js/amazeui.min.js"></script>

<script src="assets/js/app.js"></script>

</body>
</html>

