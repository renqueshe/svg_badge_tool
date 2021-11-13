<?php
require_once('common.php');
//设置你自己的小号access_token!!!!! 否则你的仓库可能被人捣乱
$access_token = '';

if (empty($_GET['user'])) {
    header('Location: https://gitee.com/hamm/svg_badge_tool');
    die;
}
$user = trim($_GET['user'] ?? 'hamm');
$url = "https://gitee.com/api/v5/users/" . $user . "?access_token=".$access_token;


$html = httpGetFull($url);
$user = json_decode($html,true);
if (!array_key_exists("id",$user)) {
    header("Location: https://svg.hamm.cn/badge.svg?key=Error&value=User Not Found");
}
$userHead = "data:image/jpeg;base64," . base64_encode(httpGetFull($user['avatar_url']));
?>

<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="500" height="300">

    <defs>
        <linearGradient id="black_gray" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" style="stop-color:#111;stop-opacity:1"/>
            <stop offset="100%" style="stop-color:#333;stop-opacity:1"/>
        </linearGradient>
    </defs>

    <rect x="50" y="50" width="400" height="250" rx="10" ry="10" style="fill:url(#black_gray);" />
    
    <text x="250" y="140" fill="#000" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="24" style='dominant-baseline:middle;text-anchor:middle;'><?php echo $user['name'];?></text>
    <text x="250" y="141" fill="#fff" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="24" style='dominant-baseline:middle;text-anchor:middle;'><?php echo $user['name'];?></text>
    
    
    <text x="250" y="160" fill="#000" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="16" style='dominant-baseline:middle;text-anchor:middle;'>@<?php echo $user['login'];?></text>
    <text x="250" y="161" fill="#999" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="16" style='dominant-baseline:middle;text-anchor:middle;'>@<?php echo $user['login'];?></text>
    
    
    <text x="250" y="200" fill="#000" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="14" style='dominant-baseline:middle;text-anchor:middle;'><?php echo $user['bio'];?></text>
    <text x="250" y="201" fill="#999" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="14" style='dominant-baseline:middle;text-anchor:middle;'><?php echo $user['bio'];?></text>
    
    
    <text x="110" y="260" fill="#000" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="14" style='dominant-baseline:middle;text-anchor:middle;'>开源</text>
    <text x="110" y="261" fill="#999" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="14" style='dominant-baseline:middle;text-anchor:middle;'>开源</text>
    <text x="110" y="240" fill="#000" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="24" style='dominant-baseline:middle;text-anchor:middle;'><?php echo $user['public_repos'];?></text>
    <text x="110" y="241" fill="#fff" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="24" style='dominant-baseline:middle;text-anchor:middle;'><?php echo $user['public_repos'];?></text>
    
    <text x="180" y="260" fill="#000" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="14" style='dominant-baseline:middle;text-anchor:middle;'>粉丝</text>
    <text x="180" y="261" fill="#999" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="14" style='dominant-baseline:middle;text-anchor:middle;'>粉丝</text>
    <text x="180" y="240" fill="#000" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="24" style='dominant-baseline:middle;text-anchor:middle;'><?php echo $user['followers'];?></text>
    <text x="180" y="241" fill="#fff" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="24" style='dominant-baseline:middle;text-anchor:middle;'><?php echo $user['followers'];?></text>
    
    <text x="250" y="260" fill="#000" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="14" style='dominant-baseline:middle;text-anchor:middle;'>关注</text>
    <text x="250" y="261" fill="#999" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="14" style='dominant-baseline:middle;text-anchor:middle;'>关注</text>
    <text x="250" y="240" fill="#000" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="24" style='dominant-baseline:middle;text-anchor:middle;'><?php echo $user['following'];?></text>
    <text x="250" y="241" fill="#fff" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="24" style='dominant-baseline:middle;text-anchor:middle;'><?php echo $user['following'];?></text>
    
    <text x="320" y="260" fill="#000" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="14" style='dominant-baseline:middle;text-anchor:middle;'>Stars</text>
    <text x="320" y="261" fill="#999" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="14" style='dominant-baseline:middle;text-anchor:middle;'>Stars</text>
    <text x="320" y="240" fill="#000" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="24" style='dominant-baseline:middle;text-anchor:middle;'><?php echo $user['stared'];?></text>
    <text x="320" y="241" fill="#fff" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="24" style='dominant-baseline:middle;text-anchor:middle;'><?php echo $user['stared'];?></text>
    
    <text x="390" y="260" fill="#000" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="14" style='dominant-baseline:middle;text-anchor:middle;'>Watches</text>
    <text x="390" y="261" fill="#999" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="14" style='dominant-baseline:middle;text-anchor:middle;'>Watches</text>
    <text x="390" y="240" fill="#000" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="24" style='dominant-baseline:middle;text-anchor:middle;'><?php echo $user['watched'];?></text>
    <text x="390" y="241" fill="#fff" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="24" style='dominant-baseline:middle;text-anchor:middle;'><?php echo $user['watched'];?></text>
    
    <rect x="195" y="0" width="110" height="110" rx="110" ry="110" style="fill:#fff;stroke-width:5;"  />
    <rect id="headImageRect" x="200" y="5" width="100" height="100" rx="100" ry="100" style="fill:#eee;stroke-width:5;"  />
    <image  xlink:href="<?php echo $userHead;?>" width="100" height="100" x="200" y="5" clip-path="url(#headImagePath)"/>
    <clipPath id="headImagePath">
        <use xlink:href="#headImageRect" />
    </clipPath>
    
</svg> 