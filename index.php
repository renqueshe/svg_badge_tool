<?php
    header('Content-Type:image/svg+xml');
    $urlForSvg = 'javascript:void(0)';
    if(empty($_GET['key']) || empty($_GET['value'])){
        header('Location: https://gitee.com/hamm/svg_badge_tool');
        die;
    }
    $key = trim($_GET['key'] ?? 'Key');
    $value = trim($_GET['value'] ?? 'Value');
    switch(strtolower($key)){
        case 'client':
            $value=strtolower($value);
            switch($value){
                case 'ip':
                    $key = "IP";
                    $value=get_client_ip();
                    break;
                case 'os':
                    $key = "系统";
                    $value=getOs();
                    break;
                case 'broswer':
                    $key = "浏览器";
                    $value=getBrowser();
                    break;
                default:
                    $key="Client";
                    $value="Tools";
            }
            break;
        case 'gitee':
            $key = ucfirst($key);
            switch($value){
                case 'star':
                    $project = trim($_GET['project']);
                    $url = "https://gitee.com/".$project;
                    $urlForSvg = "https://gitee.com/".$project."/stargazers";
                    try{
                        $html = httpGetFull($url);
                        if(preg_match('/stargazers" class="ui button action-social-count.*?" title="(.*?)"/', $html, $matches)){
                            $value = $matches[1]." Stars";
                        }else if(preg_match('/class="ui button action-social-count.*?stargazers.*?title="(.*?)"/', $html, $matches)){
                            $value = $matches[1]." Stars";
                        }else{
                            $value = "? Stars";
                        }
                    }catch(Exception $e){
                        $value = "? Stars";
                    }
                    break;
                case 'fork':
                    $project = trim($_GET['project']);
                    $url = "https://gitee.com/".$project;
                    $urlForSvg = "https://gitee.com/".$project."/members";
                    try{
                        $html = httpGetFull($url);
                        if(preg_match('/members" class="ui button action-social-count.*?" title="(.*?)"/', $html, $matches)){
                            $value = $matches[1]." Forks";
                        }else if(preg_match('/class="ui button action-social-count.*?members.*?title="(.*?)"/', $html, $matches)){
                            $value = $matches[1]." Forks";
                        }else{
                            $value = "? Stars";
                        }
                    }catch(Exception $e){
                        $value = "? Forks";
                    }
                    break;
                case 'watch':
                    $project = trim($_GET['project']);
                    $url = "https://gitee.com/".$project;
                    $urlForSvg = "https://gitee.com/".$project."/watchers";
                    try{
                        $html = httpGetFull($url);
                        if(preg_match('/watchers" class="ui button action-social-count.*?" title="(.*?)"/', $html, $matches)){
                            $value = $matches[1]." Watches";
                        }else if(preg_match('/class="ui button action-social-count.*?watchers.*?title="(.*?)"/', $html, $matches)){
                            $value = $matches[1]." Watches";
                        }else{
                            $value = "? Watches";
                        }
                    }catch(Exception $e){
                        $value = "? Watches";
                    }
                    break;
                case 'commit':
                    $project = trim($_GET['project']);
                    $url = "https://gitee.com/".$project;
                    $urlForSvg = "https://gitee.com/".$project."/commits/master";
                    try{
                        $html = httpGetFull($url);
                        if(preg_match('/icon-commit\'><\/i>\n<b>(.*?)<\/b>/', $html, $matches)){
                            $value = $matches[1]." Commits";
                        }else{
                            $value = "? Commits";
                        }
                    }catch(Exception $e){
                        $value = "? Commits";
                    }
                    break;
                default:
            }
            break;
        default:
    }
    
    
    $len_key = 11 * mb_strlen($key);
    if(preg_match('/[a-zA-Z]$/', $key)){
        $len_key = 6.5 * strlen($key);
    }
    
    $len_value = 11 * mb_strlen($value);
    if(preg_match('/[a-zA-Z.+-_#*\/@]$/', $value)){
        $len_value = 6.5 * strlen($value);
    }
    
    $radius = $_GET['radius'] ?? 3;
    
    $backColor = '#ff4500';
    switch(strtolower($value)){
        case 'php':
            $backColor = '#6c7fd5';
            $len_value = 9 * strlen($value);
            break;
        case 'c++':
            $backColor = '#074680';
            $len_value = 8.5 * strlen($value);
            break;
        case 'c#':
            $backColor = '#662577';
            $len_value = 8.5 * strlen($value);
            break;
        case 'java':
            $backColor = '#b85916';
            break;
        case 'javascript':
            $backColor = '#69a86b';
            break;
        case 'node':
            $backColor = '#6da149';
            $len_value = 8 * strlen($value);
            break;
        case 'node':
            $backColor = '#6da149';
            $len_value = 8 * strlen($value);
            break;
        case 'python':
            $backColor = '#fccd4d';
            break;
        default:
            $backColor = !empty($_GET['color']) ? "#".$_GET['color'] : randColor();
    }
    $len_total = $len_key+$len_value + 11*2;
   
function randColor() 
{ 
  $str='3456789ABC'; 
    $estr='#'; 
    $len=strlen($str); 
    for($i=1;$i<=6;$i++) 
    { 
        $num=rand(0,$len-1);   
        $estr=$estr.$str[$num];  
    } 
    return $estr; 
} 
/**
 * CURL GET
 *
 * @param string 请求地址
 * @param array 请求头
 * @param string COOKIES
 * @param boolean 是否返回header
 * @param boolean 是否后台请求
 * @param integer 超时时间
 * @param array 使用代理
 * @return mixed 
 */
function httpGetFull($url, $header = [], $cookies = "", $returnHeader = false, $isBackGround = false, $timeout = 0, $proxy = null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_COOKIE, $cookies);
    if ($timeout) {
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    }
    if (!empty($proxy)) {
        curl_setopt($ch, CURLOPT_PROXY, $proxy['ip']);
        curl_setopt($ch, CURLOPT_PROXYPORT, $proxy['port']);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "taras:taras-ss5");
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, $isBackGround ? 0 : 1);
    curl_setopt($ch, CURLOPT_HEADER, $returnHeader ? 1 : 0);
    $output = curl_exec($ch);
    if ($timeout) {
        if ($output === FALSE) {
            if (in_array(curl_errno($ch), [28])) {
                $output = 'TIMEOUT';
            } else {
                $output = 'ERROR';
            }
        }
    }
    curl_close($ch);
    return $output;
}

function get_client_ip()
{
    foreach (array(
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    ) as $key) {
        if (array_key_exists($key, $_SERVER)) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip);
                if ((bool) filter_var(
                    $ip,
                    FILTER_VALIDATE_IP,
                    FILTER_FLAG_IPV4
                    // FILTER_FLAG_NO_PRIV_RANGE |
                    // FILTER_FLAG_NO_RES_RANGE
                )) {
                    return $ip;
                }
            }
        }
    }
    return null;
}

/**
 * 获取操作系统
 *
 * @return string
 */
function  getOs()
{
    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        return 'Other';
    }
    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    if (strpos($agent, 'windows nt')) {
        $platform = 'Windows';
    } elseif (strpos($agent, 'macintosh')) {
        $platform = 'MacOS';
    } elseif (strpos($agent, 'ipod')) {
        $platform = 'iPod';
    } elseif (strpos($agent, 'ipad')) {
        $platform = 'iPad';
    } elseif (strpos($agent, 'iphone')) {
        $platform = 'iPhone';
    } elseif (strpos($agent, 'android')) {
        $platform = 'Android';
    } elseif (strpos($agent, 'unix')) {
        $platform = 'Unix';
    } elseif (strpos($agent, 'linux')) {
        $platform = 'Linux';
    } else {
        $platform = 'Other';
    }
    return $platform;
}
/**
 * 获取浏览器
 *
 * @return void
 */
function  getBrowser()
{
    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        return 'Unknown';
    }
    $agent = $_SERVER["HTTP_USER_AGENT"];
    if (strpos($agent, 'MSIE') !== false || strpos($agent, 'rv:11.0')) //ie11判断
    {
        return "IE";
    } else if (strpos($agent, 'Firefox') !== false) {
        return "Firefox";
    } else if (strpos($agent, 'Chrome') !== false) {
        return "Chrome";
    } else if (strpos($agent, 'Opera') !== false) {
        return 'Opera';
    } else if ((strpos($agent, 'Chrome') == false) && strpos($agent, 'Safari') !== false) {
        return 'Safari';
    } else {
        return 'Unknown';
    }
}
?>
<!-- This is build by svg tool , see more here :  https://gitee.com/hamm/svg_badge_tool-->
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="<?php echo $len_total;?>" height="20">
    <style>.opencollective-svg { cursor: pointer; }</style>
    <a xlink:href="<?php echo $urlForSvg;?>" class="opencollective-svg" target="_blank">
        <linearGradient id="b" x2="0" y2="100%">
            <stop offset="0" stop-color="#bbb" stop-opacity=".1"/>
            <stop offset="1" stop-opacity=".1"/>
        </linearGradient>
        <clipPath id="a">
            <rect width="<?php echo $len_total;?>" height="20" rx="<?php echo $radius;?>" fill="#fff"/>
        </clipPath>
        <g clip-path="url(#a)">
            <path fill="#333" d="M0 0h<?php echo $len_key+11;?>v20H0z"/>
            <path fill="<?php echo $backColor;?>" d="M<?php echo $len_key+11;?> 0h<?php echo $len_value+11;?>v20H<?php echo $len_key+11;?>z"/>
            <path fill="url(#b)" d="M0 0h<?php echo $len_total;?>v20H0z"/>
        </g>
        <g fill="#fff" text-anchor="middle" font-family="Consolas, PingFangSC-Regular, Microsoft YaHei" font-size="110">
            <text x="<?php echo $len_key*5+55;?>" y="150" fill="#010101" fill-opacity=".3" transform="scale(.1)" textLength="<?php echo $len_key*10;?>"><?php echo $key;?></text>
            <text x="<?php echo $len_key*5+55;?>" y="140" transform="scale(.1)" textLength="<?php echo $len_key*10;?>"><?php echo $key;?></text>
            <text x="<?php echo $len_value*5+ 110*1.5 + $len_key*10;?>" y="150" fill="#010101" fill-opacity=".3" transform="scale(.1)" textLength="<?php echo $len_value*10;?>"><?php echo $value;?></text>
            <text x="<?php echo $len_value*5+ 110*1.5 + $len_key*10;?>" y="140" transform="scale(.1)" textLength="<?php echo $len_value*10;?>"><?php echo $value;?></text>
        </g>
    </a>
</svg>