<?php
require_once('common.php');
if (empty($_GET['user']) || empty($_GET['type'])) {
    header('Location: https://gitee.com/hamm/svg_badge_tool');
    die;
}
$user = trim($_GET['user'] ?? 'hamm');
$project = trim($_GET['project'] ?? 'svg_badge_tool');
$type = trim($_GET['type'] ?? 'fans');
$key = 'Weibo';
$value = '';

$url = "https://m.weibo.cn/api/container/getIndex?type=uid&value=" . $user ;
$html = httpGetFull($url);
$html = str_replace(PHP_EOL, '', $html);

$arr = json_decode($html,true);



switch ($type) {
    case 'followers':
        $key = '微博粉丝';
        $value = "查询失败";
        if($arr['ok'] == 1){
            $value = $arr['data']['userInfo']['followers_count'];
        }
        break;
    case 'following':
        $key = '微博关注';
        $value = "查询失败";
        if($arr['ok'] == 1){
            $value = $arr['data']['userInfo']['follow_count'];
        }
        break;
    default:
}
?>

<?php
$len_key = 11 * mb_strlen($key);
if (preg_match('/[a-zA-Z]/', $key)) {
    $len_key = 7 * strlen($key);
}

$len_value = 11 * mb_strlen($value);
if (preg_match('/[a-zA-Z.+-_#*\/@]/', $value)) {
    $len_value = 7 * strlen($value);
}

$radius = $_GET['radius'] ?? 3;

$icon_length = 0;
if (!empty($_GET['title'])) {
    $key = htmlspecialchars($_GET['title']);
}
$titleBg = '#c71d23';
if (!empty($_GET['bg'])) {
    $titleBg = '#' . htmlspecialchars($_GET['bg']);
}

$backColor = '#404550';
$backColor = !empty($_GET['color']) ? "#" . $_GET['color'] : $backColor;
$len_total = $len_key + $len_value + 11 * 2;
?>

<!-- This is build by svg tool , see more here :  https://gitee.com/hamm/svg_badge_tool-->
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="<?php echo $icon_length / 10 + $len_total; ?>" height="20">
    <style>
        .opencollective-svg {
            cursor: pointer;
        }
    </style>
    <?php if ($urlForSvg) { ?>
        <a xlink:href="<?php echo $urlForSvg; ?>" class="opencollective-svg" target="_blank">
        <?php } ?>
        <linearGradient id="b" x2="0" y2="100%">
            <stop offset="0" stop-color="#bbb" stop-opacity=".1" />
            <stop offset="1" stop-opacity=".1" />
        </linearGradient>
        
        <clipPath id="a">
            <rect width="<?php echo $icon_length / 10 + $len_total; ?>" height="20" rx="<?php echo $radius; ?>" fill="#fff" />
        </clipPath>
        <g clip-path="url(#a)">
            <path fill="<?php echo $titleBg; ?>" d="M0 0h<?php echo $icon_length / 10 + $len_key + 11; ?>v20H0z" />
            <path fill="<?php echo $backColor; ?>" d="M<?php echo $icon_length / 10 + $len_key + 11; ?> 0h<?php echo $icon_length / 10 + $len_value + 11; ?>v20H<?php echo $icon_length / 10 + $len_key + 11; ?>z" />
            <path fill="url(#b)" d="M0 0h<?php echo $icon_length / 10 + $len_total; ?>v20H0z" />
        </g>
        <g fill="#fff" text-anchor="middle" font-family="Consolas, PingFangSC-Regular, Microsoft YaHei" font-size="110" x="<?php echo $icon_length; ?>">
            <text x="<?php echo $icon_length + $len_key * 5 + 55; ?>" y="150" fill="#010101" fill-opacity=".3" transform="scale(.1)" textLength="<?php echo $len_key * 10; ?>"><?php echo $key; ?></text>
            <text x="<?php echo $icon_length + $len_key * 5 + 55; ?>" y="140" transform="scale(.1)" textLength="<?php echo $len_key * 10; ?>"><?php echo $key; ?></text>
            <text x="<?php echo $icon_length + $len_value * 5 + 110 * 1.5 + $len_key * 10; ?>" y="150" fill="#010101" fill-opacity=".3" transform="scale(.1)" textLength="<?php echo $len_value * 10; ?>"><?php echo $value; ?></text>
            <text x="<?php echo $icon_length + $len_value * 5 + 110 * 1.5 + $len_key * 10; ?>" y="140" transform="scale(.1)" textLength="<?php echo $len_value * 10; ?>"><?php echo $value; ?></text>
            
            <animateMotion from="0, -50" to="0, 0" dur="0.3s" fill="freeze"/>
        </g>
        <?php if ($urlForSvg) { ?>
        </a>
    <?php } ?>
</svg>