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
    <link rel="stylesheet" href="assets/css/amazeui.chosen.css"/>
    <style>
        #search{
            float: right;
            padding-right: 30px;
            padding-bottom: 20px;
        }
        #result{
            float: left;
            margin-left: 20px;
            margin-top: 10px;
        }
        #page{
            float: right;
            margin-right: 20px;
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
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">线下订单管理界面</strong> / <small>offOrders</small></div>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <button type="button" class="am-btn am-btn-default"><span class="am-icon-plus"></span><a href="admin/admin_add_order"> 新增订单</a></button>
                        <button type="button" class="am-btn am-btn-default"><span class="am-icon-refresh"></span><a href="admin/redirect_offOrder" > 返回线下订单管理</a></button>

                    </div>
                </div>
            </div>
            <div>
                <div class="am-u-sm-12 am-u-md-3">
                    <div class="am-input-group am-input-group-sm">
                        <input id="keyword" type="text" class="am-form-field" name="offOrder_search_key" placeholder="请输入订单手机号">
                        <span class="am-input-group-btn">
                            <button id="search-btn" class="am-btn am-btn-default" type="button">搜索</button>
                        </span>
                    </div>
                </div>
            </div>
            

                
        </div>
        <div class="am-g" style="height: 1000px;">
            <div class="am-u-sm-12">
                <table class="am-table am-table-striped am-table-hover table-main">
                    <thead>
                        <tr>
                            
                            <th class="table-id">订单编号</th>
                            <th class="table-title">姓名</th>
                            <th class="table-type">服务类别</th>
                            <th class="table-type">地址</th>
                            <th class="table-type">联系方式</th>
                            <th class="table-type">预定时间</th>
                            <th class="table-type">订单状态</th> 
                            <th class="table-type">操作<button href="admin/delete_admin"  type="button" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only" id="doc-prompt-toggle" data-am-popover="{content: '请您在删除前输入管理员登录密码！', trigger: 'hover focus'}"><span class="am-icon-key"></span> 验证</button>
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
                            </th> 
                            
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php
                                $offOrder_id = 0;
                            foreach($offOrders as $offOrder){
                                $offOrder_id++;
                        ?>
                        <tr class="<?php echo $offOrder -> offOrder_color?>" selector="offOrder-tr<?php echo $offOrder -> offOrder_id; ?>" data-id="<?php echo $offOrder -> offOrder_id; ?>">
                            <td><?php echo $offOrder_id; ?></td>
                            <td><?php echo $offOrder -> offOrder_name; ?></td>
                            <td><?php echo $offOrder -> offOrder_type; ?></td>
                            <td><?php echo $offOrder -> offOrder_address; ?></td>
                            <td><?php echo $offOrder -> offOrder_tel; ?></td>
                            <td><?php echo $offOrder -> offOrder_time; ?></td>
                            <td> 
                                <input class="offOrder_id" type="hidden" value="<?php echo $offOrder -> offOrder_id; ?>">
                                <select data-id="<?php echo $offOrder -> offOrder_id; ?>" class="offOrder-status my-select" name="offOrder-status" data-placeholder="订单状态" style="width:140px;">
                                    <option data-id="<?php echo $offOrder -> offOrder_id; ?>" value="am-active" <?php echo $offOrder -> offOrder_color == 'am-active'?'selected="selected"':'';?>>已接单</option>
                                    <option data-id="<?php echo $offOrder -> offOrder_id; ?>" value="am-warning" <?php echo $offOrder -> offOrder_color == 'am-warning'?'selected="selected"':'';?>>施工中</option>
                                    <option data-id="<?php echo $offOrder -> offOrder_id; ?>" value="am-disabled" <?php echo $offOrder -> offOrder_color == 'am-disabled'?'selected="selected"':'';?>>问题单</option>
                                    <option data-id="<?php echo $offOrder -> offOrder_id; ?>" value="am-success" <?php echo $offOrder -> offOrder_color == 'am-success'?'selected="selected"':'';?>>完成</option>
                                </select>
                            </td>
                            <td>
                                <div class="am-btn-toolbar" >
                                    <div class="am-btn-group am-btn-group-xs">
                                        <button data-id="<?php echo $offOrder -> offOrder_id; ?>" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only am-btn-delete am-disabled"><span class="am-icon-trash-o"></span> 删除</button>
                                        <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only am-btn-success" data-am-offcanvas="{target: '#doc-oc-demo<?php echo $offOrder -> offOrder_id; ?>'}"><span class="am-icon-pencil"></span>备注</button>
                                        <div id="doc-oc-demo<?php echo $offOrder -> offOrder_id; ?>" class="am-offcanvas">
                                          <div class="am-offcanvas-bar am-offcanvas-bar-flip">
                                            <div class="am-offcanvas-content">
                                                <input type="hidden" name="offOrder_id" value="<?php echo $offOrder -> offOrder_id; ?>">
                                                <fieldset>
                                                    <legend style="color: #fff;">订单备注</legend>
                                                    <div class="am-form-group">
                                                      <label for="doc-ta-1">请输入订单备注信息</label>
                                                      <textarea  name="remark_content" class="remark_content" cols="30" rows="5" id="doc-ta-1" selector="offOrder-remark<?php echo $offOrder -> offOrder_id; ?>"><?php echo $offOrder -> offOrder_remark; ?></textarea>
                                                    </div>
                                                    <button type="button" class="am-btn remark" data-id= "<?php echo $offOrder -> offOrder_id; ?>">保存</button>
                                                </fieldset>
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
            <span id="result">共&lt;<span id="count"><?php echo $offOrder_count;?></span>&gt;条结果</span>
            <ul id="page" class="am-pagination am-fr admin-content-pagination">
                <?php echo $this->pagination->create_links();?>
            </ul>

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
<script src="assets/js/amazeui.chosen.min.js"></script>
<script src="assets/js/underscore.min.js"></script>
<script>
    
    $(function(){
        $('#tbody').on('click','.am-btn-delete', function(){
            var $offOrder_id = $(this).data('id');
            var $tr = $('tr[selector*='+$offOrder_id+']');
            //alert($offOrder_id);
            $.get('admin/admin_delete_offOrder',{'offOrder_id':$offOrder_id},function(res){
                if(res=='success'){
                    $tr.remove();
                    alert('删除成功！');
                    location.reload();
                    
                }
            },'text');

            
        });

    });
</script>

<script>
    $(function() {
      $('.my-select').chosen();

      $('.chosen-select').chosen({disable_search_threshold: 10});
    });
</script>

<script type="text/template" id="tmpl">
    

        <tr  class="<%= offOrder_color %>" selector="offOrder-tr<%= offOrder_id %>" data-id="<%= offOrder_id %>">
            <td><%= offOrder_id %></td>
            <td><%= offOrder_name %></td>
            <td><%= offOrder_type %></td>
            <td><%= offOrder_address %></td>
            <td><%= offOrder_tel %></td>
            <td><%= offOrder_time %></td>
            <td> 
                <input class="offOrder_id" type="hidden" value="<%= offOrder_id %>">
                <select data-id="<%= offOrder_id %>" class="offOrder-status my-select" name="offOrder_status" data-placeholder="订单状态" style="width:140px;">
                    <option data-id="<%= offOrder_id %>" value="am-active" <%= offOrder_color  == 'am-active'?'selected="selected"':''%>>已接单</option>
                    <option data-id="<%= offOrder_id %>" value="am-warning" <%= offOrder_color == 'am-warning'?'selected="selected"':''%>>施工中</option>
                    <option data-id="<%= offOrder_id %>" value="am-disabled" <%= offOrder_color == 'am-disabled'?'selected="selected"':''%>>失败</option>
                    <option data-id="<%= offOrder_id %>" value="am-success" <%= offOrder_color == 'am-success'?'selected="selected"':''%>>已完成</option>

                </select>
            </td>
            <td>
                <div class="am-btn-toolbar" >
                    <div class="am-btn-group am-btn-group-xs">
                        <button href="admin/delete_admin" data-id="<%= offOrder_id %>" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only am-btn-delete am-disabled"><span class="am-icon-trash-o"></span> 删除</button>
                        <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only am-btn-success" data-am-offcanvas="{target: '#doc-oc-demo<%= offOrder_id %>'}"><span class="am-icon-pencil"></span>备注</button>
                        <div id="doc-oc-demo<%= offOrder_id %>" class="am-offcanvas">
                          <div class="am-offcanvas-bar am-offcanvas-bar-flip">
                            <div class="am-offcanvas-content">
                                <input type="hidden" name="offOrder_id" value="<%= offOrder_id %>">
                                <fieldset>
                                    <legend style="color: #fff;">订单备注</legend>
                                    <div class="am-form-group">
                                      <label for="doc-ta-1">请输入订单备注信息</label>
                                      <textarea  name="remark_content" class="remark_content" cols="30" rows="5" id="doc-ta-1" selector="offOrder-remark<%= offOrder_id %>"><%= offOrder_remark %></textarea>
                                    </div>
                                    <button type="button" class="am-btn remark" data-id= "<%= offOrder_id %>">保存</button>
                                </fieldset>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </td>   
        </tr>
        
   
</script>


<script>
    $(function(){
        var $keyword = $('#keyword');
        $('#search-btn').on('click',function(){
            
            
            $.get('admin/admin_offOrder_search',{'keyword':$keyword.val()},function(res){
                $('#count').html(res.count);
                $('#tbody').empty();
                
                for(var i=0; i<res.data.length;i++){
                     //console.log(_.template);
                    var order = res.data[i];
                    
                   
                    $('#tbody').append(_.template( $('#tmpl').html() )(order));

                }

            },'json');
        });

    });  
</script>



<script>
    $('#tbody').on('change','.offOrder-status',function(){
        var $offOrder_color = $(this).find('option:selected').val();
        var $offOrder_id = $(this).data('id');
        var $tr = $('tr[selector*='+$offOrder_id+']');
        $.get('admin/update_offOrder_status',{'offOrder_color':$offOrder_color,'offOrder_id':$offOrder_id},function(res){
            if(res){
                $tr.removeClass().addClass(res.data[0].offOrder_color);
            }
        },'json');
           
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


<script>
    $(function(){

        $('#tbody').on('click','.remark',function(){
            $offOrder_id = $(this).data('id');
            $offOrder_remark = $('textarea[selector*='+$offOrder_id+']').val();

            $.get('admin/update_offOrder_remark',{'offOrder_id':$offOrder_id,'offOrder_remark':$offOrder_remark},function(res){
                if(res=="success"){
                    alert("修改成功");
                }
            });
            

        });

    });
    
</script>





</body>
</html>
