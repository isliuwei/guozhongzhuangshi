<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>国众装饰后台管理</title>
  <meta name="description" content="这是一个form页面">
  <meta name="keywords" content="form">
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
  <!-- sidebar start -->
  <?php include 'admin-sidebar.php'; ?>
  <!-- sidebar end -->

<!-- content start -->
<div class="admin-content">

  <div class="am-cf am-padding">
    <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">新增案例信息管理界面</strong> / <small>Add</small></div>
  </div>

  <div class="am-tabs am-margin" data-am-tabs>
    <ul class="am-tabs-nav am-nav am-nav-tabs">
      
     
    </ul>

    <div class="am-tabs-bd">


        <div class="am-tab-panel am-fade am-in am-active" >
          <form action="admin/save_case" method="post" class="am-form am-form-inline" enctype="multipart/form-data" data-am-validator>
            <div class="am-g am-margin-top-sm">
              <div class="am-u-sm-4 am-u-md-2 am-text-right">
                案例 客户
              </div>
              <div class="am-u-sm-8 am-u-md-4 am-u-end">
                <input type="text" class="am-input-sm" name="case_user">
              </div>
            </div>

            <div class="am-g am-margin-top">
              <div class="am-u-sm-4 am-u-md-2 am-text-right">
                案例 主图
              </div>
              <div class="am-u-sm-8 am-u-md-4">
                <!--文件上传-->
                <div class="am-form-group am-form-file">
                  <button type="button" class="am-btn am-btn-danger am-btn-sm">
                    <i class="am-icon-cloud-upload"></i> 选择要上传的文件</button>
                  <input id="doc-form-file" type="file" multiple name="case_img">
                  <!--图片预览-->
                  <br/>
                  <small class="am-badge am-badge-success am-radius">预览图</small>
                  <div id="imgdiv"><img id="imgShow" width="50%" height="50%" /></div>
                  <!--图片预览-->
                </div>
                <div id="file-list1"></div>
                <!--文件上传-->
              </div>
              <div class="am-hide-sm-only am-u-md-6">*如果不上传图片,则使用默认图片,图片大小不要超过3M</div>
            </div>

            <div class="am-g am-margin-top-sm">
              <div class="am-u-sm-4 am-u-md-2 am-text-right">
                案例 描述
              </div>
              <div class="am-u-sm-8 am-u-md-4 am-u-end">
                <textarea rows="4" name="case_desc"></textarea>
              </div>
            </div>
            <div class="am-g am-margin-top-sm">
              <div class="am-u-sm-4 am-u-md-2 am-text-right">
                案例 地址
              </div>
              <div class="am-u-sm-8 am-u-md-4 am-u-end">
                <input type="text" class="am-input-sm" name="case_add">
              </div>
            </div>
            <div class="am-margin">
              <input type="reset" class="am-btn am-btn-primary am-btn-xs" value="重置">
              <input type="submit" class="am-btn am-btn-primary am-btn-xs" value="提交保存">
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

<!--图片上传预览-->
<script src="assets/js/uploadPreview.min.js"></script>
<script>
  window.onload = function () {
    new uploadPreview({ UpBtn: "doc-form-file", DivShow: "imgdiv", ImgShow: "imgShow" });
    new uploadPreview({ UpBtn: "doc-form-file1", DivShow: "imgdiv1", ImgShow: "imgShow1" });
  }
</script>
<!--图片上传预览-->





<!--图片上传-->
<script>
  $(function() {

    $('#doc-form-file').on('change', function() {
      var fileNames = '';
      $.each(this.files, function() {
        fileNames += '<span class="am-badge">' + this.name + '</span> ';
      });
      $('#file-list').html(fileNames);
    });

    $('#doc-form-file1').on('change', function() {
      var fileNames = '';
      $.each(this.files, function() {
        fileNames += '<span class="am-badge">' + this.name + '</span> ';
      });
      $('#file-list1').html(fileNames);
    });

  });
</script>
<!--图片上传-->






</body>
</html>
