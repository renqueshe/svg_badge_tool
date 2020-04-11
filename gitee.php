<?php
require_once('common.php');
if(empty($_GET['user']) || empty($_GET['project']) || empty($_GET['type'])){
    header('Location: https://gitee.com/hamm/svg_badge_tool');
    die;
}
$user = trim($_GET['user'] ?? 'hamm');
$project = trim($_GET['project'] ?? 'svg_badge_tool');
$type = trim($_GET['type'] ?? 'star');
$key = 'Gitee';
switch($type){
    case 'star':
        $url = "https://gitee.com/".$user."/".$project;
        $urlForSvg = "https://gitee.com/".$user."/".$project."/stargazers";
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
        $url = "https://gitee.com/".$user."/".$project;
        $urlForSvg = "https://gitee.com/".$user."/".$project."/members";
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
        $url = "https://gitee.com/".$user."/".$project;
        $urlForSvg = "https://gitee.com/".$user."/".$project."/watchers";
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
        $url = "https://gitee.com/".$user."/".$project;
        $urlForSvg = "https://gitee.com/".$user."/".$project."/commits/master";
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
require_once('svg.php');
?>
