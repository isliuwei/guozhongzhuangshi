<?php
    $admin = $this -> session -> userdata('admin');
    $currentOrderTotal = $this -> session -> userdata('currentOrderTotal');
    if(!$admin){
        redirect('admin/login');
    }
?>


<header class="am-topbar am-topbar-inverse admin-header">
<!-- 将当前订单总数保存 --> 
<input type="hidden" name="currentOrderTotal" id="currentOrderTotal" value="<?php echo $currentOrderTotal ; ?>">


    <div class="am-topbar-brand">
        <small>国众装饰后台管理</small>
    </div>
    
    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>
    
    <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

        <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
            <li><a href="mailto:lw.588@163.com"><span class="am-icon-envelope-o"></span><span  id="msg-span" class="am-badge am-badge-warning am-hide" ><marquee id="msg"></marquee></span></a></li>
            <li class="am-dropdown" data-am-dropdown>
                <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
                    <span class="am-icon-users"></span> 管理员 | <img src="<?php echo $admin -> admin_photo;?>" style="width: 20px;height: 20px;"alt="">&nbsp;<?php echo $admin -> admin_name;?> <span class="am-icon-caret-down"></span>
                </a>
                <ul class="am-dropdown-content">
                    <li><a href="#"><span class="am-icon-user"></span> 资料</a></li>
                    <li><a href="admin/get_admin?admin_id=<?php echo $admin -> admin_id;?>"><span class="am-icon-cog"></span> 设置</a></li>
                    <li><a href="admin/logout"><span class="am-icon-power-off"></span> 退出</a></li>
                </ul>
            </li>
            <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
        </ul>
    </div>
</header>
<!-- <audio id="chatAudio"><source src="assets/audio/notify.ogg" type="audio/ogg"><source src="assets/audio/notify1.mp3" type="audio/mpeg"><source src="assets/audio/notify.wav" type="audio/wav" autoplay="autoplay"></audio> -->
<audio id="chatAudio"><source src="assets/audio/notify1.mp3" type="audio/mpeg"></audio>
<!-- <audio id="chatAudio"><source src="assets/audio/4.m4r" type="audio/mpeg"></audio> -->
<script src="assets/js/jquery.min.js"></script>
<script>
    var m1= "您有新的订单...";
    var m2= "-";
    var msg=m2+m1;
    function titnimation() {
        msg=msg.substring(1,msg.length)+msg.substring(0,1); 
        document.title = msg;
    }

    


  
    var $input = $('#currentOrderTotal');
    var $currentOrderTotal = $input.val();

    setInterval(function() {
        //console.log($currentOrderTotal);
        $.get('admin/find_new_order',{'currentOrderTotal':$currentOrderTotal},function(res){
            
            if(res == 'success'){
                console.log('有新的订单');
                $('#chatAudio')[0].play();
                setInterval("titnimation()",300);
                 $('#msg-span').removeClass("am-hide");
                 $('#msg').html("您有新的订单...请及时处理");
              
            }else{
                console.log('无新的订单');

                //$('#chatAudio')[0].play();
            }
        },'text');

    }, 6000);











   

 

</script>

