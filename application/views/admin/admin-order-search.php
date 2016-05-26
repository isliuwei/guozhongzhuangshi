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
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">订单管理界面</strong> / <small>Orders</small></div>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <a href="admin/redirect_order_mgr" type="button" class="am-btn am-btn-default"><span class="am-icon-refresh"></span> 返回订单管理页面</a>

                    <div id="result">共&lt;<?php echo $result_count;?>&gt;条结果</div>

                        

                    </div>
                </div>
            </div>
            <div>
                <form id="search" action="admin/admin_order_search" method="post">
                    <input type="text" name="order_search_key">
                    <input type="submit" value="搜索">
                </form>
        </div>
        </div>


        <div class="am-g" style="height:1000px;">
            <div class="am-u-sm-12">
                <table class="am-table am-table-striped am-table-hover table-main">
                    <thead>
                        <tr>
                            <th class="table-check"><input type="checkbox" /></th>
                            <th class="table-id">订单编号</th>
                            <th class="table-title">姓名</th>
                            <th class="table-type">服务类别</th>
                            <th class="table-type">地址</th>
                            <th class="table-type">联系方式</th>
                            <th class="table-type">预定时间</th>
                            <th class="table-type">订单状态</th> 
                            <th class="table-type">操作<button href="admin/delete_admin"  type="button" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only" id="doc-prompt-toggle" data-am-popover="{content: '请您在删除前输入管理员登录密码！', trigger: 'hover focus'}"><span class="am-icon-key"></span>验证</button>
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
                    <tbody>
                        <?php

                            foreach($order as $order){
                        ?>
                        <tr class="<?php echo $order -> order_color?>"  selector="order-tr<?php echo $order -> order_id; ?>" data-id="<?php echo $order -> order_id; ?>">
                            <td><input type="checkbox" class="checkItem" value="<?php echo $order -> order_id; ?>"/></td>
                            <td><?php echo $order -> order_no; ?></td>
                            <td><?php echo $order -> order_name; ?></td>
                            <td><?php echo $order -> order_type; ?></td>
                            <td><?php echo $order -> order_address; ?></td>
                            <td><?php echo $order -> order_tel; ?></td>
                            <td><?php echo $order -> order_time; ?></td>
                            <td> 
                                <input class="order_id" type="hidden" value="<?php echo $order -> order_id; ?>">
                                <select data-id="<?php echo $order -> order_id; ?>" class="order-status my-select" name="order-status" data-placeholder="订单状态" style="width:140px;" >
                                    <option data-id="<?php echo $order -> order_id; ?>" value="am-active" <?php echo $order -> order_color == 'am-active'?'selected="selected"':'';?>>已接单</option>
                                    <option data-id="<?php echo $order -> order_id; ?>" value="am-warning" <?php echo $order -> order_color == 'am-warning'?'selected="selected"':'';?>>施工中</option>
                                    <option data-id="<?php echo $order -> order_id; ?>" value="am-disabled" <?php echo $order -> order_color == 'am-disabled'?'selected="selected"':'';?>>问题单</option>
                                    <option data-id="<?php echo $order -> order_id; ?>" value="am-success" <?php echo $order -> order_color == 'am-success'?'selected="selected"':'';?>>完成</option>

                                </select>
                            </td>
                            <td>
                                <div class="am-btn-toolbar" >
                                    <div class="am-btn-group am-btn-group-xs">
                                        <button href="admin/delete_admin" data-id="<?php echo $order -> order_id; ?>" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only am-btn-delete am-disabled"><span class="am-icon-trash-o"></span> 删除</button>
                                        
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only am-btn-success" data-am-offcanvas="{target: '#doc-oc-demo<?php echo $order -> order_id; ?>'}"><span class="am-icon-pencil"></span>备注</button>

                                       <div id="doc-oc-demo<?php echo $order -> order_id; ?>" class="am-offcanvas">
                                          <div class="am-offcanvas-bar am-offcanvas-bar-flip">
                                            <div class="am-offcanvas-content">
                                                <!-- <form class="am-form" method="post" action="admin/update_remark">
                                                    <input type="hidden" name="order_id" value="<?php echo $order -> order_id; ?>">
                                                    <fieldset>
                                                        <legend style="color: #fff;">订单备注</legend>
                                                            <div class="am-form-group">
                                                              <label for="doc-ta-1">请输入订单备注信息</label>
                                                              <textarea  name="remark_content" class="remark_content" cols="30" rows="5" id="doc-ta-1"><?php echo $order -> order_remark; ?></textarea>
                                                            </div>

                                                            <p><button type="submit" class="am-btn am-btn-default am-btn-primary am-btn-sub">保存</button></p>
                                                     </fieldset>
                                                </form> -->
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
                            <td>
                                <button type="button" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only am-btn-secondary" data-am-modal="{target: '#my-actions<?php echo $order -> order_id; ?>'}">支付信息</button>

                                <div class="am-modal-actions" id="my-actions<?php echo $order -> order_id; ?>">
                                  <div class="am-modal-actions-group">
                                    <ul class="am-list">
                                      <li class="am-modal-actions-tel"><a href="javascript:;"><span class="am-icon-mobile-phone">  支付联系电话：<?php echo $order -> order_contact; ?></a></li>
                                      <li><a href="javascript:;"><span class="am-icon-money">  支付金额：</span><?php echo $order -> order_money; ?>元</a></li>
                                      <li class="am-modal-actions-danger">
                                        <a href="javascript:;"><i class="am-icon-calendar"></i>  支付时间：<?php echo $order -> pay_time; ?></a>
                                      </li>
                                    </ul>
                                  </div>
                                  <div class="am-modal-actions-group">
                                    <button class="am-btn am-btn-default am-btn-xs am-text-danger  am-btn-secondary am-btn-block" data-am-modal-close>取消</button>
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
<script src="assets/js/amazeui.chosen.min.js"></script>
<script>
    $(function(){
        $('.am-btn-reply').on('click',function(){
            var openId =  $(this).data('id');
            location.href = "admin/admin_reply?openId="+openId;
        });

    });

    $(function(){
        $('.am-btn-delete').on('click', function(){
            var messageId =  $(this).data('id');
            if(confirm('确定是否删除记录，不可恢复!?')){
                location.href = 'admin/delete_message?message_id='+messageId;
            }
        });

//!! 2016-01-20 12:00 by liuwei
/*****批量删除*****/
        //选择按钮
        var $checkAllBtn = $('#checkAll'),
            $checkNoBtn = $('#checkNo'),
            $checkRevBtn = $('#checkRev'),
            $checkItems = $('.checkItem'),
            $delCheckedBtn = $('#delChecked');

        //全选
        $checkAllBtn.on('click', function(){
            $checkItems.prop('checked','checked');
        });

        //反选
        $checkRevBtn.on('click', function(){
            $checkItems.each(function(){
                this.checked = !this.checked;
            });
        });

        //取消全选
        $checkNoBtn.on('click', function(){
            $checkItems.prop('checked',false);
        });

        //删除选中

        $delCheckedBtn.on('click', function(){
            var $messageIds ='';
            //$('input:checked').parents('tr').hide();
            $('input:checked').each(function(index,elem){
                //console.log(index +','+elem.value);
                $messageIds = $messageIds + elem.value +',';
            });
            $messageIds = $messageIds.substring(0,($messageIds.length)-1);
            //console.log($messageIds);
            //@ $messageIds = 1,2,3,4

            //使用ajax异步删除
            //$.get(url, data, callback, type);

            $.get('admin/remove_checked_messages?Ids='+$messageIds,function(res){
                if(res == 'success'){
                    $('input:checked').parents('tr').fadeOut(function(){
                        $(this).remove();
                        location.reload();
                    });
                }
            },'text');
        });
/*****批量删除*****/



    });
</script>
<script>
    $(function(){
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
<script>
$(function() {
  $('.my-select').chosen();

  $('.chosen-select').chosen({disable_search_threshold: 10});
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
//<option data-id="<?php echo $order -> order_id; ?>" value="am-primary" <?php echo $order -> order_color == 'am-primary'?'selected="selected"':'';?>>已付款</option>
    $(function(){
        $('.order-status').on('change',function(){
            var $order_color = $(this).find('option:selected').val();
            var $order_id = $(this).data('id');
            var $tr = $('tr[selector*='+$order_id+']');
            $.get('admin/update_order_status1',{'order_color':$order_color,'order_id':$order_id},function(res){
                if(res){
                    $tr.removeClass().addClass(res.data[0].order_color);

                }
            
            },'json');
            
        });
    });
</script>
</body>
</html>
