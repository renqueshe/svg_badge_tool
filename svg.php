<?php
    header('Content-Type:image/svg+xml');
    if(empty($_GET['key']) || empty($_GET['value'])){
        header('Location: https://gitee.com/hamm/svg_badge_tool');
        die;
    }
    $key = trim($_GET['key'] ?? 'Key');
    $value = trim($_GET['value'] ?? 'Value');
    
    switch($key){
        case 'gitee':
            $key = ucfirst($key);
            switch($value){
                case 'star':
                    $project = trim($_GET['project']);
                    $url = "https://gitee.com/".$project;
                    try{
                        $html = file_get_contents($url);
                        if(preg_match('/stargazers" class="ui button action-social-count" title="(.*?)"/', $html, $matches)){
                            $value = $matches[1]." stars";
                        }
                    }catch(Exception $e){
                        print_r($e->getMessage());die;
                    }
                    break;
                case 'fork':
                    $project = trim($_GET['project']);
                    $url = "https://gitee.com/".$project;
                    try{
                        $html = file_get_contents($url);
                        if(preg_match('/members" class="ui button action-social-count" title="(.*?)"/', $html, $matches)){
                            $value = $matches[1]." fork";
                        }
                    }catch(Exception $e){
                        print_r($e->getMessage());die;
                    }
                    break;
                case 'watch':
                    $project = trim($_GET['project']);
                    $url = "https://gitee.com/".$project;
                    try{
                        $html = file_get_contents($url);
                        if(preg_match('/watchers" class="ui button action-social-count" title="(.*?)"/', $html, $matches)){
                            $value = $matches[1]." watches";
                        }
                    }catch(Exception $e){
                        print_r($e->getMessage());die;
                    }
                    break;
                case 'commit':
                    $project = trim($_GET['project']);
                    $url = "https://gitee.com/".$project;
                    try{
                        $html = file_get_contents($url);
                        if(preg_match('/icon-commit\'><\/i>\n<b>(.*?)<\/b>/', $html, $matches)){
                            $value = $matches[1]." commit";
                        }
                    }catch(Exception $e){
                        print_r($e->getMessage());die;
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
?>
<!-- This is build by svg tool , see more here :  https://gitee.com/hamm/svg_badge_tool-->
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="<?php echo $len_total;?>" height="20">
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
</svg>