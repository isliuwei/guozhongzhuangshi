<?php
    $service_id = $this -> session -> userdata('service_id');
?>
<?php
    $items_id = $this -> session -> userdata('items_id');
?>
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
   <style>
    #texture-detail{
       padding: 6px;
       font-size: 7px; 
       color: blue;
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
    <!-- sidebar end -->

    <!-- content start -->
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="am-cf am-padding am-padding-bottom-0">
                <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">表格</strong> / <small>Table</small></div>
            </div>

            <hr>

            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-6">
                    <div class="am-btn-toolbar">
                        <div class="am-btn-group am-btn-group-xs">
                            <button type="submit" id="save-ser-texture" class="am-btn am-btn-default"><span class="am-icon-plus"></span> 新增</button>
            
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span> 删除</button>
                        </div>
                    </div>
                    <form id="texture-detail" action="admin/save_service_texture" method="post" style="display:none">
                        材质：<input type="text" name="service_texture" value="">
                        价格：<input type="text" name="texture_price" value="">
                        <input type="hidden" name="item_id" value="<?php echo $items_id ;?>">
                        <input type="hidden" name="service_id" value="<?php echo $service_id ;?>">
                        <input type="submit" value="保存">
                    </form>
                </div>

                <div class="am-u-sm-12 am-u-md-3">
                    <div class="am-form-group">
                        <!-- <select id="#items" data-am-selected="{btnSize: 'sm'}">
                            <option value="option1">所有类别</option>
                            <?php 
                                
                                foreach ($items as $item){
                                   
                            ?>
                            <option value="<?php echo $item->service_id;?>"><?php echo $item -> service_name ;?></option>
                            <?php
                                }
                            ?>
                        </select> -->



                         <select id="items">
                            
                            <?php 
                                
                                foreach ($items as $item){
                                   
                            ?>   
                            <option value="<?php echo $item->service_id;?>"><?php echo $item -> service_name ;?></option>
                            <?php
                                }
                            ?>
                        </select>











                    </div>
                </div>
                <div class="am-u-sm-12 am-u-md-3">
                    <div class="am-input-group am-input-group-sm">
                        <input type="text" class="am-form-field">
          <span class="am-input-group-btn">
            <button class="am-btn am-btn-default" type="button">搜索</button>
          </span>
                    </div>
                </div>
            </div>

            <div class="am-g">
                <div class="am-u-sm-12">
                                <table class="am-table am-table-striped am-table-hover table-main" id="my-table">
                                <thead>
                                <tr>
                                    <th class="table-check"><input type="checkbox" /></th>
                                    <th class="table-id">ID</th>
                                    <th class="table-type">产品</th>
                                    <th class="table-price">材质</th>
                                    <th class="table-set">价格</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach($contents as $content) {
                                            
                                    ?>
                                <tr>
                                    <td><input type="checkbox" /></td>
                                    <td><?php echo $content -> service_id ;?></td>
                                    <td><?php echo $content -> product_type ;?></td>
                                    <td><?php echo $content -> product_texture ;?></td>
                                    <td><?php echo $content -> product_price ;?></td>
                                    <td>
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <button data-id="<?php echo $content -> service_id ;?>" class="am-btn am-btn-default am-btn-xs am-text-secondary item-date"><span class="am-icon-pencil-square-o"></span> 编辑</button>
                                                <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                                <button type="button" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only" id="doc-prompt-toggle"><span class="am-icon-trash-o"></span>删除</button>

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

        <footer class="admin-content-footer">
            <hr>
            <p class="am-padding-left">© 2014 AllMobilize, Inc. Licensed under MIT license.</p>
        </footer>

    </div>
    <!-- content end -->
</div>

<a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu" data-am-offcanvas="{target: '#admin-offcanvas'}"></a>

<footer>
    <hr>
    <p class="am-padding-left">© 2014 AllMobilize, Inc. Licensed under MIT license.</p>
</footer>
<span id="service_id" data-id="<?php echo $service_id ;?>"></span>






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
<!-- <script src="js/jquery"></script> -->
<!-- <script src="assets/js/jquery.min.js"></script>
<script src="assets/js/amazeui.datatables.min.js"></script> -->

<script>
    // $(function() {

        

    //     jQuery.extend(jQuery.fn.dataTableExt.oSort, {
    //         "chinese-string-asc": function(s1, s2) {
    //           return s1.localeCompare(s2);
    //         },

    //         "chinese-string-desc": function(s1, s2) {
    //           return s2.localeCompare(s1);
    //         }
    //     });

    //   $(function() {
    //     $('#my-table').DataTable();
    //     $('#my-table-r').DataTable({
    //       responsive: true,
    //       dom: 'ti'
    //     });

    //     $('#sorting-chinese').dataTable({
    //       columnDefs: [
    //         {type: 'chinese-string', targets: '_all'}
    //       ]
    //     });
    //   });


    // });
    




</script>
<script>
    // $(function(){
    //     $('.item-date').on('click',function(e){
    //         e = e||window.event;
    //         e.preventDefault();
    //         location.href="admin/date_item";
    //     });
    // });




    $(function(){
        $('.item-date').on('click', function(){
            var serviceId =  $(this).data('id');
            if(confirm('是否确定进行编辑？！')){
                location.href = 'admin/date_item?service_id='+serviceId;
            }
        });


        $('#items').on('change',function(){
            var $items_id = $(this).find('option:selected').val();
            var $service_id = $('#service_id').data('id');
           
            //$('#texture-detail').find("input:hidden").val($items_id);
            

            location.href = 'admin/get_contents?items_id='+$items_id+'&service_id='+$service_id;    
        });





        //  $('#items').on('change',function(){
        //     $items_id = $(this).find('option:selected').val();
        //     $service_id = $('#service_id').data('id');

        //     //$.get(url,data,function(){},type)

        //     $.get('admin/get_contents',{
        //         items_id: $items_id,
        //         service_id: $service_id
        //     },function(res){
        //         if(res){
        //             console.log(res);
        //         }

        //     },json);






               
        // });


        


        






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
                    alert('你的密码输入正确！');
                    location.href = "http://www.baidu.com";
                }else{
                    alert('你的密码输入错误，无法进行删除操作！');
                }
            });
          },
          onCancel: function(e) {
            alert('不想说!');
          }
        });
      });
});
</script>
<script>
    $('#save-ser-texture').on('click',function(){
       $('#texture-detail').css('display','block');
       $('#texture-detail:first-child').focus();
    });
</script>

</body>
</html>
