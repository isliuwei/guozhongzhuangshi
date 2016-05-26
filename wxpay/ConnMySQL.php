
<?php

    //@打开一个到 MySQL 服务器的新的连接
    $con = mysqli_connect("qdm189698249.my3w.com","qdm189698249","aliyunmysql1991");
    if (!$con)
    {// 检测是否连接成功
        die("连接MySQL数据库失败! <br/>错误代码: " . mysqli_connect_errno());
    }


    //@更改连接的默认数据库,选择 MySQL 数据库
    mysqli_select_db($con,"qdm189698249_db");

    //@设置默认客户端字符集
    mysqli_set_charset($con,"utf8");

?>

<?php
/**
********************
*General Information
********************
服务器类型: MySQL
连接名: guozhong
主机名或 IP 地址: qdm189698249.my3w.com
端口: 3306
用户名: qdm189698249
保存密码: 是
编码: Unicode (UTF-8)
Enable MySQL character set: 是
Use compression: 否

********************
*Advanced Information
********************
设置保存路径: /Users/liuwei/Library/Application Support/PremiumSoft CyberTech/Navicat for MySQL/guozhong
Socket timeout (sec): 30
Timeout reconnection: 否
Auto connect: 否
Use socket for localhost connection: 否
Use advanced connections: 否

********************
*SSL Information
********************
Use SSL: 否

********************
*SSH Information
********************
Use SSH tunnel: 否

********************
*HTTP Information
********************
Use HTTP tunnel: 否

********************
*Other Information
********************
服务器版本: N/A
通讯协定: N/A
信息: N/A
SSL 密文: N/A
*/
?>




