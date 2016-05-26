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
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">反馈管理界面</strong> / <small>Feedback</small></div>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <button type="button" id="checkAll" class="am-btn am-btn-default"><span class="am-icon-check"></span> 全选</button>
                        <button type="button" id="checkRev" class="am-btn am-btn-default"><span class="am-icon-undo"></span> 反选</button>
                        <button type="button" id="checkNo" class="am-btn am-btn-default"><span class="am-icon-remove"></span> 取消</button>
                        <button type="button" id="delChecked" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span> 删除</button>

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
                            <th class="table-title">微信ID</th>
                            <th class="table-type">反馈内容</th>
                            <th class="table-type">反馈时间</th>
                            <th class="table-type">操作</th>  
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($feedbacks as $feedback){
                        ?>
                        <tr>
                            <td><input type="checkbox" class="checkItem" value="<?php echo $feedback -> feedback_id; ?>"/></td>
                            <td><?php echo $feedback -> feedback_id; ?></td>
                            <td><?php echo $feedback -> weixin_id; ?></td>
                            <td><?php echo $feedback -> feedback_content; ?></td>
                            <td><?php echo $feedback -> feedback_time; ?></td>
                            <td>
                                <div class="am-btn-toolbar">
                                    <div class="am-btn-group am-btn-group-xs">
                                        <button href="admin/delete_feedback" data-id="<?php echo $feedback -> feedback_id; ?>" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only am-btn-delete"><span class="am-icon-trash-o"></span> 删除</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
             <span id="result">共&lt;<?php echo $feedback_count;?>&gt;条结果</span>
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

        // $delCheckedBtn.on('click', function(){
        //     var $messageIds ='';
        //     //$('input:checked').parents('tr').hide();
        //     $('input:checked').each(function(index,elem){
        //         //console.log(index +','+elem.value);
        //         $messageIds = $messageIds + elem.value +',';
        //     });
        //     $messageIds = $messageIds.substring(0,($messageIds.length)-1);
        //     //console.log($messageIds);
        //     //@ $messageIds = 1,2,3,4

        //     //使用ajax异步删除
        //     //$.get(url, data, callback, type);

        //     $.get('admin/remove_checked_messages?Ids='+$messageIds,function(res){
        //         if(res == 'success'){
        //             $('input:checked').parents('tr').fadeOut(function(){
        //                 $(this).remove();
        //                 location.reload();
        //             });
        //         }
        //     },'text');
        // });
        $('#delChecked').on('click',function(){
            var $feedbackIds ='';
            $('input:checked').parents('tr').hide();
            $('input:checked').each(function(index,elem){
                $feedbackIds = $feedbackIds + elem.value +',';
            });
            $feedbackIds = $feedbackIds.substring(0,($feedbackIds.length-1));
            $.get('admin/delete_checked_feedback?Ids='+$feedbackIds,function(res){
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
</body>
</html>
