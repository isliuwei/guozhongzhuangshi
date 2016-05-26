<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define("TOKEN", "weixin");
define("APPID", "wx8bdd74650fd816e3");
// define("APPID", "wxef1e6d0a562373c8");
define("APPSECRET", "1363298f77bfc489f6935e44508e9747");
// define("APPSECRET", "f44562e1b40a00e8d19ffabd18ba131e");

class CI_Wechat {

    private $_CI;
    private $access_token;

    public function __construct() {

        $this->_CI =& get_instance();
        $this->_CI->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

    }

    /**
     * 向用户推送消息
     * @param array 其中msgtype代表消息类型：text为文本，news为图文
     */
    function push_message($msg_data) {

        $this->checkAuth();

        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $this->access_token;

        $result = $this -> http_post($url, json_encode($msg_data));
        return json_decode($result);
        //return $result;
    }

    /**
     * 构造http请求，可以是post和get方式
     * @param url string 请求路径
     * @param post_data json格式的字符串，不传是get方式
     * @return http请求结果
     */
    private function http_post($url, $post_data = '') {
         $curl = curl_init();
         curl_setopt($curl, CURLOPT_URL, $url);
         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
         curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
         if ($post_data) {
             curl_setopt($curl, CURLOPT_POST, 1);
             curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
         }
         $result = curl_exec($curl);
         if (curl_errno($curl)) {
             return 'Errno' . curl_error($curl);
         }
         curl_close($curl);
         return $result;
     }
    /**
     * GET 请求
     * @param string $url
     */
    private function http_get($url){
        $oCurl = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if(intval($aStatus["http_code"])==200){
            return $sContent;
        }else{
            return false;
        }
    }

    /**
     * POST 请求
     * @param string $url
     * @param array $param
     * @param boolean $post_file 是否文件上传
     * @return string content
     */
    /*private function http_post($url,$param,$post_file=false){
        $oCurl = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        if (is_string($param) || $post_file) {
            $strPOST = $param;
        } else {
            $aPOST = array();
            foreach($param as $key=>$val){
                $aPOST[] = $key."=".urlencode($val);
            }
            $strPOST =  join("&", $aPOST);
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($oCurl, CURLOPT_POST,true);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if(intval($aStatus["http_code"])==200){
            return $sContent;
        }else{
            return false;
        }
    }*/

    function get_openid() {
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
        } else {
            echo "NO CODE";
        }

        // 运行cURL，请求网页
        $data = $this -> http_post('https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . APPID . '&secret=' . APPSECRET . '&code=' . $code . '&grant_type=authorization_code');

        // 获取access_token；
        $reg = "#{.+}#";
        preg_match_all($reg, $data, $matches);
        $json = $matches[0][0];

        $accessArr = json_decode($json, true);
        $access_token = $accessArr['access_token'];
        $openid = $accessArr['openid'];

        return $openid;
    }

    /**
     * 获取access_token
     * @param string $appid 如在类初始化时已提供，则可为空
     * @param string $appsecret 如在类初始化时已提供，则可为空
     * @param string $token 手动指定access_token，非必要情况不建议用
     */
    private function checkAuth(){
        $authname = 'wechat_access_token_'.APPID;
        if ($rs = $this->getCache($authname))  {
            $this->access_token = $rs;
            return $rs;
        }



        $result = $this->http_get('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.APPID.'&secret='.APPSECRET);
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || isset($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            $this->access_token = $json['access_token'];
            $expire = $json['expires_in'] ? intval($json['expires_in'])-100 : 3600;
            $this->setCache($authname,$this->access_token,$expire);
            return $this->access_token;
        }
        return false;
    }

    /**
     * 重载设置缓存
     * @param string $cachename
     * @param mixed $value
     * @param int $expired
     * @return boolean
     */
    private function setCache($cachename, $value, $expired) {
        return $this->_CI->cache->save($cachename, $value, $expired);
    }

    /**
     * 重载获取缓存
     * @param string $cachename
     * @return mixed
     */
    private function getCache($cachename) {
        return $this->_CI->cache->get($cachename);
    }

    /**
     * 重载清除缓存
     * @param string $cachename
     * @return boolean
     */
    private function removeCache($cachename) {
        return $this->_CI->cache->delete($cachename);
    }

}