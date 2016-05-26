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
  <!-- sidebar start -->
  <?php include 'admin-sidebar.php'; ?>
  <!-- sidebar end -->

<!-- content start -->
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">产品编辑管理界面</strong> / <small>Add</small></div>
        </div>

        
          <div class="am-tabs am-margin" data-am-tabs>
            <ul class="am-tabs-nav am-nav am-nav-tabs"></ul>
          <div class="am-tabs-bd">
              <div class="am-tab-panel am-fade am-in am-active" >
                <form action="admin/update_pro" method="post" class="am-form am-form-inline" enctype="multipart/form-data" data-am-validator>
                  
                        <input type="hidden" name="pro_id" value="<?php echo $this -> uri -> segment(3) ;?>">
                        <div class="am-g am-margin-top">
                            

                            <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                产品 名称
                            </div>
                            <div class="am-u-sm-8 am-u-md-4">
                                <input type="text" name="pro_name" class="am-input-sm" value="<?php echo $pro -> product_name ;?>">
                            </div>
                            <div class="am-hide-sm-only am-u-md-6">*必填，不可重复</div>
                        </div>

                        <div class="am-g am-margin-top">
                            

                            <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                产品 价格
                            </div>
                            <div class="am-u-sm-8 am-u-md-4">
                                <input type="text" name="pro_price" class="am-input-sm" value="<?php echo $pro -> product_price ;?>">
                            </div>
                            <div class="am-hide-sm-only am-u-md-6">*必填，不可重复</div>
                        </div>

                        <div class="am-g am-margin-top">
                            

                            <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                产品 商家
                            </div>
                            <div class="am-u-sm-8 am-u-md-4">
                                <input type="text" name="pro_business" class="am-input-sm" value="<?php echo $pro -> product_business ;?>">
                            </div>
                            <div class="am-hide-sm-only am-u-md-6">*必填，不可重复</div>
                        </div>

                        <div class="am-g am-margin-top">
                            

                            <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                商家 地址
                            </div>
                            <div class="am-u-sm-8 am-u-md-4">
                                <input type="text" name="business_add" class="am-input-sm" value="<?php echo $pro -> business_address ;?>">
                            </div>
                            <div class="am-hide-sm-only am-u-md-6">*必填，不可重复</div>
                        </div>

                        <div class="am-g am-margin-top">
                            

                            <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                商家 电话
                            </div>
                            <div class="am-u-sm-8 am-u-md-4">
                                <input type="text" name="business_phone" class="am-input-sm" value="<?php echo $pro -> business_phone ;?>">
                            </div>
                            <div class="am-hide-sm-only am-u-md-6">*必填，不可重复</div>
                        </div>



                        
                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-2 am-text-right">当前产品主图</div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end">
                                <input type="hidden" name="photo_old_url" value="<?php echo $pro -> product_img ;?>">
                                <img src="<?php echo $pro -> product_img ;?>" style="width: 50%; height: 50%; cursor: pointer;" alt="当前文章主图缩略图" title="" data-am-popover="{content: '当前文章主图缩略图', trigger: 'hover focus'}"/>
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                产品 主图
                            </div>
                            <div class="am-u-sm-8 am-u-md-4">
                                <!--文件上传-->
                                <div class="am-form-group am-form-file">
                                    <button type="button" class="am-btn am-btn-danger am-btn-sm">
                                        <i class="am-icon-cloud-upload"></i> 选择要上传的文件</button>
                                    <input id="doc-form-file" type="file" multiple name="pro_img">
                                    <!--图片预览-->
                                    <br/>
                                    <small class="am-badge am-badge-success am-radius">预览图</small>
                                    <div id="imgdiv"><img id="imgShow" width="50%" height="50%" /></div>
                                    <!--图片预览-->
                                </div>
                                <div id="file-list"></div>
                                <!--文件上传-->
                            </div>
                            <div class="am-hide-sm-only am-u-md-6">*如果不上传图片,则使用原图片</div>
                        </div>

                        



                        

                        <div class="am-margin">
                            <input type="reset" class="am-btn am-btn-primary am-btn-xs" value="重置">
                            <input type="submit" class="am-btn am-btn-primary am-btn-xs" value="提交保存">
                            <button type="button" class="am-btn am-btn-primary am-btn-xs"><a href="admin/admin_article_mgr" style="color:#fff;">放弃保存</a></button>
                        </div>

                    </form>
                
              </div>
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


    });
</script>
<!--图片上传-->



</body>
</html>
