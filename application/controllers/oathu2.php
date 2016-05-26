<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   


    class OAuth2 extends CI_Controller{



    $userinfo = getUserInfo($code);

    function getUserInfo($code)
    {
        $appid = "wxef1e6d0a562373c8";
        $appsecret = "f44562e1b40a00e8d19ffabd18ba131e";

        //oauth2的方式获得openid
        $access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";
        $access_token_json = https_request($access_token_url);
        $access_token_array = json_decode($access_token_json, true);
        $openid = $access_token_array['openid'];

        //非oauth2的方式获得全局access token
        $new_access_token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
        $new_access_token_json = https_request($new_access_token_url);
        $new_access_token_array = json_decode($new_access_token_json, true);
        $new_access_token = $new_access_token_array['access_token'];
        
        //全局access token获得用户基本信息
        $userinfo_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$new_access_token."&openid=".$openid;
        $userinfo_json = https_request($userinfo_url);
        $userinfo_array = json_decode($userinfo_json, true);
        return $userinfo_array;
    }

    function https_request($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {return 'ERROR '.curl_error($curl);}
        curl_close($curl);
        return $data;
    }





}

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
    <HEAD><TITLE>OAuth2.0认证</TITLE>
        <META charset=utf-8>
        <META name=viewport content="width=device-width, user-scalable=no, initial-scale=1">
        <LINK rel="stylesheet" href="css/jquery.mobile-1.3.2.css">
        <SCRIPT src="js/jquery-1.10.2.js"></SCRIPT>
        <SCRIPT src="js/jquery.mobile-1.3.2.js"></SCRIPT>
    </HEAD>

    <BODY>
        <script type="text/javascript">
            document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
                WeixinJSBridge.call('hideOptionMenu');
            });
            document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
                WeixinJSBridge.call('hideToolbar');
            });
        </script>
        <div data-role="page" id="page1">
            <div data-role="content">
                <div style=" text-align:center">
                    <img style="width: 99%; height: %" src="<?php echo $userinfo["headimgurl"];?>">
                </div>
                <UL data-role="listview" data-inset="true">
                    <LI>
                        <P>
                            <div class="fieldcontain">
                                <label for="subscribe">是否关注</label>
                                <input name="subscribe" id="subscribe" value="<?php echo $userinfo["subscribe"];?>" type="text" >
                            </div>
                            <div class="fieldcontain">
                                <label for="openid">OpenID</label>
                                <input name="openid" id="openid" value="<?php echo $userinfo["openid"];?>" type="text" >
                            </div>
                            <div class="fieldcontain">
                                <label for="nickname">昵称</label>
                                <input name="nickname" id="nickname" value="<?php echo $userinfo["nickname"];?>" type="text" >
                            </div>
                            <div class="fieldcontain">
                                <label for="sex">性别</label>
                                <input name="sex" id="sex" value="<?php echo $userinfo["sex"];?>" type="text" >
                            </div>
                            <div class="fieldcontain">
                                <label for="country">国家</label>
                                <input name="country" id="country" value="<?php echo $userinfo["country"];?>" type="text" >
                            </div>
                            <div class="fieldcontain">
                                <label for="province">省份</label>
                                <input name="province" id="province" value="<?php echo $userinfo["province"];?>" type="text" >
                            </div>
                            <div class="fieldcontain">
                                <label for="city">城市</label>
                                <input name="city" id="city" value="<?php echo $userinfo["city"];?>" type="text" >
                            </div>
                            <div class="fieldcontain">
                                <label for="subscribe_time">关注时间</label>
                                <input name="subscribe_time" id="subscribe_time" value="<?php echo $userinfo["subscribe_time"];?>" type="text" >
                            </div>
                        </P>
                    </LI>
                </UL>
            </div>
            <div data-theme="a" data-role="footer" data-position="fixed">
                <h3>方倍工作室</h3>
            </div>
        </div>

    </BODY>
</HTML>





