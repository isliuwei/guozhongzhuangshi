<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>国众装饰后台管理</title>
  <base href="<?php echo site_url();?>">
  <meta name="description" content="这是一个 index 页面">
  <meta name="keywords" content="index">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  

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
    <div class="admin-content-body">
      <div class="am-cf am-padding">
        <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">首页</strong> / <small>平台信息汇总</small></div>
      </div>

      <ul class="am-avg-sm-1 am-avg-md-4 am-margin am-padding am-text-center admin-content-list ">
        <li><a href="admin/admin_order_mgr" class="am-text-success"><span class="am-icon-btn am-icon-file-text"></span><br/>微信订单<br/><?php echo $orderTotal;?></a></li>
        <li><a href="admin/admin_offline_order_mgr" class="am-text-warning"><span class="am-icon-btn am-icon-briefcase"></span><br/>线下订单<br/><?php echo $offOrderTotal;?></a></li>
        <li><a href="admin/admin_message_mgr" class="am-text-danger"><!-- <span class="am-icon-btn am-icon-recycle"></span> --><span class="am-icon-btn am-icon-wechat"></span><br/>留言总数<br/><?php echo $message_count;?></a></li>
        <li><a href="admin/admin_order_mgr" class="am-text-secondary"><!-- <span class="am-icon-btn am-icon-rmb"></span> --><span class="am-icon-btn am-icon-cc-visa"></span><br/>资金总额<br/>¥<?php echo $orderTotalMoney[0] -> total;?>0元</a></li>
      </ul>

      <div class="am-g">
        <div class="am-u-sm-12">
          <table class="am-table am-table-bd am-table-striped admin-content-table">
            <thead>
            <tr>
              <th>序号</th>
              <th>订单状态</th>
              <th>订单状态比例</th>
              <th>订单数量</th>
              <th>管理</th>
            </tr>
            </thead>
            <tbody>
            <?php 
                
                function orderStatus($orderInfo){
                 
                  switch ($orderInfo)
                    {
                     case 'am-disabled':
                      echo "问题单";
                      break;
                     case 'am-active':
                      echo "已接单";
                      break;
                      case 'am-warning':
                      echo "施工中";
                      break;
                      case 'am-success':
                      echo "完成";
                      break;
                    }
                } 

                function orderColor($orderInfo){
                 
                  switch ($orderInfo)
                    {
                     case 'am-disabled':
                      echo "danger";
                      break;
                     case 'am-active':
                      echo "warning";
                      break;
                      case 'am-warning':
                      echo "secondary";
                      break;
                      case 'am-success':
                      echo "success";
                      break;
                    }
                }

                function orderProgress($orderInfo){
                 
                  switch ($orderInfo)
                    {
                     case 'am-disabled':
                      echo "30%";
                      break;
                     case 'am-active':
                      echo "50%";
                      break;
                      case 'am-warning':
                      echo "80%";
                      break;
                      case 'am-success':
                      echo "100%";
                      break;
                    }
                }

                function orderPercent($orderNum,$total){

                  return (($orderNum/$total))*100;

                }  

                
                $index = 0;
                foreach($orderInfo as $Info){
                $index++;
            ?>

            <tr class="<?php echo $Info -> order_color;?>">
              <td><?php echo $index; ?></td>
              <td><?php echo orderStatus($Info -> order_color);?></td>
              <td>
                <div class="am-progress am-progress-striped am-progress-sm am-active" style="margin:8px 0 0 0;">
                    <div class="am-progress-bar am-progress-bar-<?php echo orderColor($Info -> order_color);?>"  style="line-height:14px; width: <?php echo orderPercent($Info -> num,$orderTotal);?>%" ><?php echo  ceil(orderPercent($Info -> num,$orderTotal));?>%</div>

                    <!-- <div class="am-progress-bar am-progress-bar-<?php echo orderColor($Info -> order_color);?>"  style="width: <?php echo orderProgress($Info -> order_color);?>" ></div> -->
                </div>
              </td>
              <td><span class="am-badge am-badge-<?php echo orderColor($Info -> order_color);?>">+<?php echo $Info -> num;?></span></td>
              <td>
                <div class="am-dropdown" data-am-dropdown>
                  <button class="am-btn am-btn-default am-btn-xs am-dropdown-toggle" data-am-dropdown-toggle><span class="am-icon-cog"></span> <span class="am-icon-caret-down"></span></button>
                  <ul class="am-dropdown-content">
                    <li><a href="#">1. 编辑</a></li>
                    <li><a href="#">2. 下载</a></li>
                    <li><a href="#">3. 删除</a></li>
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

      <div class="am-g">
        

        <div class="am-u-md-12">
          

          <div class="am-panel am-panel-default">
            <div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-3'}">最近留言<span class="am-icon-chevron-down am-fr" ></span></div>
            <div class="am-panel-bd am-collapse am-in am-cf" id="collapse-panel-3">
              <ul class="am-comments-list admin-content-comment">
                <?php 
                    foreach($messages as $message){
                ?>
                <li class="am-comment">
                  <a href="#"><img src="http://s.amazeui.org/media/i/demos/bw-2014-06-19.jpg?imageView/1/w/96/h/96" alt="" class="am-comment-avatar" width="48" height="48"></a>
                  <div class="am-comment-main">
                    <header class="am-comment-hd">
                      <div class="am-comment-meta"><a href="#" class="am-comment-author"><?php echo $message -> weixin_id ?></a> 评论于 <time><?php echo $message -> message_time ?></time></div>
                    </header>
                    <div class="am-comment-bd"><p><?php echo $message -> message_content ?></p></div>
                    <div class="am-dropdown" data-am-dropdown>
                      <button class="am-btn am-btn-default am-btn-xs am-dropdown-toggle" data-am-dropdown-toggle><span class="am-icon-cog"></span> <span class="am-icon-caret-down"></span></button>
                      <ul class="am-dropdown-content">
                        <li><button type="button" class="am-btn am-btn-primary" data-am-modal="{target: '#doc-modal-<?php echo $message -> message_id ?>', closeViaDimmer: 0, width: 400, height: 250}">回复</button></li>
                        <li><button type="button" data-id="<?php echo $message -> message_id ?>" class="am-btn am-btn-default delete-msg">删除</button></li>
                      </ul>
                    </div>
                  </div>
                </li>

                <div class="am-modal am-modal-no-btn" tabindex="-1" id="doc-modal-<?php echo $message -> message_id ?>">
                    <div class="am-modal-dialog">
                      <div class="am-modal-hd"><span class="am-icon-wechat"></span> 回复消息
                        <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
                      </div>
                      <div class="am-modal-bd">
                          <input class="open-id" type="hidden" value="<?php  echo $message -> weixin_id  ;?>">
                          <textarea style="margin-bottom: 20px;border: none;text-indent: 10px;" name="msg_content" class="msg-content" cols="34" rows="5"></textarea>
                          <button type="submit" class="am-btn am-btn-primary reply-msg">回复</button>
                          <button type="reset" class="am-btn am-btn-default" data-am-modal-close>取消</button>
                      </div>
                    </div>
                </div>

                <?php 
                    }
                ?>

               
              </ul>

             <span id="result">共&lt;<?php echo $message_count;?>&gt;条结果</span>
             <ul id="page" class="am-pagination am-fr admin-content-pagination">
                <?php echo $this->pagination->create_links();?>
            </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <footer class="admin-content-footer">
      <hr>
      <p class="am-padding-left">© 2016 Guozhong Decorate, Inc. Background Management System. Power by Weichuang.</p>
    </footer>
  </div>
  <!-- content end -->

</div>

<a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu" data-am-offcanvas="{target: '#admin-offcanvas'}"></a>


</div>





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

    //删除消息
    var $deleteMsg = $('.delete-msg');
    $deleteMsg.on('click',function(){
      $messageId = $(this).data('id');
      //alert($messageId);
      location.href = "admin/delete_msg/"+$messageId;
    });

    //回复消息
    var $replyMsg = $('.reply-msg');

    $replyMsg.on('click',function(){
      $openId = $(this).prevAll('.open-id').val();
      $replyContent = $(this).prev('.msg-content').val();
      console.log($openId+" , "+$replyContent);

      $.get('admin/reply_msg',{'openId':$openId,'replyContent':$replyContent},function(res){
        if(res == 'success'){
          alert('回复成功!');
        }
      },'text');
    });

  });
</script>


</body>
</html>
