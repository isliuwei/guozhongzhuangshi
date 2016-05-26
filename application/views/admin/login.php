<!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <title>管理员登录</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="format-detection" content="telephone=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <base href="<?php echo site_url();?>">
  <link rel="alternate icon" type="image/png" href="assets/i/favicon.png">
  <link rel="stylesheet" href="assets/css/amazeui.min.css"/>
  <style>
    .header {
      text-align: center;
    }
    .header h1 {
      font-size: 200%;
      color: #333;
      margin-top: 30px;
    }
    .header p {
      font-size: 14px;
    }
  </style>
</head>
<body>
<div class="header">
  <div class="am-g">
    
    <h1>管 理 员 登 录</h1>
    <img class="am-circle" src="img/logo.jpg" width="100" height="100"/>
    
    <p>黑龙江国众建筑装饰工程有限公司<br/>Guozhong Decorate, Inc. Background Management System.</p>

  </div>
  <hr />
</div>
<div class="am-g">
  <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">

    <form method="post" class="am-form" action="admin/check_login">
      <label for="email"><span class="am-icon-user"></span> 管理员:</label>
      <input type="text" name="admin_name" id="admin_name" value="">
      <br>
      <label for="password"><span class="am-icon-key"></span> 密码:</label>
      <input type="password" name="admin_pwd" id="admin_pwd" value="">
      <br />
      <div class="am-cf">
        <input type="submit" name="" value="登 录" class="am-btn am-btn-primary am-btn-sm am-fl">
      </div>
    </form>
    <hr>
  </div>
</div>
</body>
</html>