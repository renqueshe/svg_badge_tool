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
$value = '';

$url = "https://gitee.com/".$user."/".$project;
$html = httpGetFull($url);
$html = str_replace(PHP_EOL,'',$html);
// print_r($html);die;
switch($type){
    case 'star':
        try{
            if(preg_match('/\/stargazers" title="(.*?)"/', $html, $matches)){
                $value = $matches[1]." Stars";
            }else{
                $value = "? Stars";
            }
        }catch(Exception $e){
            $value = "? Stars";
        }
        break;
    case 'fork':
        try{
            if(preg_match('/\/members" title="(.*?)"/', $html, $matches)){
                $value = $matches[1]." Forks";
            }else{
                $value = "? Forks";
            }
        }catch(Exception $e){
            $value = "? Forks";
        }
        break;
    case 'watch':
        try{
            if(preg_match('/\/watchers" title="(.*?)"/', $html, $matches)){
                $value = $matches[1]." Watches";
            }else{
                $value = "? Watches";
            }
        }catch(Exception $e){
            $value = "? Watches";
        }
        break;
    case 'commit':
        try{
            if(preg_match("/<i class='iconfont icon-commit'><\/i>(.*?) 次提交<\/a>/", $html, $matches)){
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
