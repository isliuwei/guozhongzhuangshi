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
    <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">编辑界面</strong> / <small>Update</small></div>
  </div>

  <div class="am-tabs am-margin" data-am-tabs>
    <ul class="am-tabs-nav am-nav am-nav-tabs">
      <li class="am-active"><a href="#tab1">编辑场所</a></li>
      <li><a href="#tab2">编辑项目</a></li>

    </ul>

    <div class="am-tabs-bd">
      <div class="am-tab-panel am-fade am-in am-active" id="tab1">
        <form action="admin/update_service_category" method="post" class="am-form am-form-inline" enctype="multipart/form-data" data-am-validator>
          <input id="service_id" type="hidden" name="service_id" value="<?php echo $service_id;?>">
          <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">场所名称</div>
            <div class="am-u-sm-8 am-u-md-4 am-u-end">
              <input type="text" name="service_category" value="<?php echo $service_category[0]->service_name;?>">
            </div>
          </div>

          <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">英文名字</div>
            
            <div class="am-u-sm-8 am-u-md-4 am-u-end">
              <input type="text" name="service_en_category" value="<?php echo $service_category[0]->service_en_name;?>">
            </div>
             <div class="am-hide-sm-only am-u-md-6" style="color:blue">*选填</div>
          </div>


          <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">当前图片</div>
            <img src="<?php echo $service_category[0]->service_img;?>" alt="" width="40%" height="40%">
          </div>

          <div class="am-g am-margin-top">
            <input type="hidden" name="photo_old_url" value="<?php echo $service_category[0]->service_img;?>">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">场所图片</div>
            <div class="am-u-sm-8 am-u-md-4 am-u-end">
              <!--文件上传-->
              <div class="am-form-group am-form-file">
                <button type="button" class="am-btn am-btn-danger am-btn-sm">
                  <i class="am-icon-cloud-upload"></i> 选择要上传的文件</button>
                <input id="doc-form-file" type="file" multiple name="photo">
              <!--图片预览-->
                <br/>
                <small class="am-badge am-badge-success am-radius">预览图</small>
                <div id="imgdiv"><img id="imgShow" width="50%" height="50%" /></div>
              <!--图片预览-->
              </div>
              <div id="file-list"></div>
              <!--文件上传-->
            </div>
            <div class="am-hide-sm-only am-u-md-6">*如果不上传图片,则使用默认图片,图片大小不要超过3M</div>
          </div>

          <div class="am-margin">
            <input type="reset" class="am-btn am-btn-primary am-btn-xs" value="重置">
            <input type="submit" class="am-btn am-btn-primary am-btn-xs" value="提交保存">
            <button type="button" class="am-btn am-btn-primary am-btn-xs">放弃保存</button>
          </div>

        </form>
      </div>

      <div class="am-tab-panel am-fade" id="tab2">
        <form class="am-form" action="admin/update_service_item" method="post" enctype="multipart/form-data">
          <div class="am-g am-margin-top">
            <input type="hidden" name="service_id" value="<?php echo $service_id;?>">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">项目名称</div>
            <div class="am-u-sm-8 am-u-md-10" style="margin-bottom: 20px;">
            <select id="items"  style="width:300px">
                <?php foreach ($service_items as $item) 
                  {
                ?>
               
               <option value="<?php echo $item->service_id;?>"><?php echo $item->service_name;?></option>
                <?php 
                  }
                ?>
            </select>
            </div>
            
            <div class="am-u-sm-4 am-u-md-2 am-text-right">
              修改名称
            </div>
            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
              <input type="text" name="service_name" class="am-input-sm" value="<?php echo $item1 == NULL ? '':  $item1[0]->service_name?>">
            </div>
            <div class="am-hide-sm-only am-u-md-6">*必填</div>
          </div>

           



          

           

          <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">
              项目描述
            </div>
            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
              <input type="text" name="item_desc" class="am-input-sm" value="<?php echo $item1 == NULL ? '':  $item1[0]->service_desc?>">
              
            </div>
         
          </div>
          <div class="am-g am-margin-top">
            
            <div class="am-u-sm-4 am-u-md-2 am-text-right">当前图片</div>
            <img src="<?php echo $item1 == NULL ? '':  $item1[0]->service_img;?>" alt="" width="40%" height="40%">
          </div>

          <div class="am-g am-margin-top">
            <input type="hidden" name="photo_old_url" value="<?php echo $item1 == NULL ? '':  $item1[0]->service_img;?>">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">
              修改图片
            </div>
            <div class="am-u-sm-8 am-u-md-4">
              <!--文件上传-->
              <div class="am-form-group am-form-file">
                <button type="button" class="am-btn am-btn-danger am-btn-sm">
                  <i class="am-icon-cloud-upload"></i> 选择要上传的文件</button>
                <input id="doc-form-file1" type="file" multiple name="photo">
                <!--图片预览-->
                <br/>
                <small class="am-badge am-badge-success am-radius">预览图</small>
                <div id="imgdiv1"><img id="imgShow1" width="50%" height="50%" /></div>
                <!--图片预览-->
              </div>
              <div id="file-list1"></div>
              <!--文件上传-->
            </div>
            <div class="am-hide-sm-only am-u-md-6">*如果不上传图片,则使用默认图片,图片大小不要超过3M</div>
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
<script>
          $('#items').on('change',function(){
            var $item_id = $(this).find('option:selected').val();
            var $service_id = $('#service_id').val();
            location.href = 'admin/update_service_mgr2?item_id='+$item_id+'&service_id='+$service_id;   
        });

</script>




</body>
</html>