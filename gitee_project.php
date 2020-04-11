<?php
require_once('common.php');
if(empty($_GET['user']) || empty($_GET['project'])){
    header('Location: https://gitee.com/hamm/svg_badge_tool');
    die;
}
$user = trim($_GET['user'] ?? 'hamm');
$project = trim($_GET['project'] ?? 'svg_badge_tool');
$url = "https://gitee.com/".$user."/".$project;
$html = httpGetFull($url);
$star = 0;
if(preg_match('/stargazers" class="ui button action-social-count.*?" title="(.*?)"/', $html, $matches)){
    $star = $matches[1];
}else if(preg_match('/class="ui button action-social-count.*?stargazers.*?title="(.*?)"/', $html, $matches)){
    $star = $matches[1];
}

$fork = 0;
if(preg_match('/members" class="ui button action-social-count.*?" title="(.*?)"/', $html, $matches)){
    $fork = $matches[1];
}else if(preg_match('/class="ui button action-social-count.*?members.*?title="(.*?)"/', $html, $matches)){
    $fork = $matches[1];
}

$watch = 0;
if(preg_match('/watchers" class="ui button action-social-count.*?" title="(.*?)"/', $html, $matches)){
    $watch = $matches[1];
}else if(preg_match('/class="ui button action-social-count.*?watchers.*?title="(.*?)"/', $html, $matches)){
    $watch = $matches[1];
}


$commit = 0;
if(preg_match('/icon-commit\'><\/i>\n<b>(.*?)<\/b>/', $html, $matches)){
    $commit = $matches[1];
}

?>
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1000" height="50">
<rect width="1000" height="50" fill="#fff"/><?php
$playTime = 40;
?>
<text style="font-size:14px;" x="1000" y="15" fill="#999">
皮一下，实在无聊......本项目迄今为止共Commit了<?php echo $commit;?>次，获得了<?php echo $watch;?> 人的关注，其中 <?php echo $star;?> 人点了Star，还有 <?php echo $fork;?> 人默默的Fork了这个仓库。
<animateMotion path="M 0 20 L -3000 20" dur="<?php echo $playTime;?>s"   />
</text>
</svg>