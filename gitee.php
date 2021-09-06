<?php
require_once('common.php');
//设置你自己的小号access_token!!!!! 否则你的仓库可能被人捣乱
$access_token = '';

if (empty($_GET['user']) || empty($_GET['type'])) {
    header('Location: https://gitee.com/hamm/svg_badge_tool');
    die;
}
$user = trim($_GET['user'] ?? 'hamm');
$type = trim($_GET['type'] ?? 'star');
$key = 'Gitee';
$value = '';

switch ($type) {
    case 'language':
        if (empty($_GET['project'])) {
            header('Location: https://gitee.com/hamm/svg_badge_tool');
            die;
        }
        $project = trim($_GET['project'] ?? 'svg_badge_tool');
        $url = "https://gitee.com/api/v5/repos/" . $user . "/" . $project."?access_token=".$access_token;
        $key = 'Language';
        $html = httpGetFull($url);
        $arr = json_decode($html,true);
        if (array_key_exists("id",$arr)) {
            $value = $arr['language'] ?? 'Unknown';
        } else {
            $value = 'Unknown';
        }
        break;
    case 'license':
        if (empty($_GET['project'])) {
            header('Location: https://gitee.com/hamm/svg_badge_tool');
            die;
        }
        $project = trim($_GET['project'] ?? 'svg_badge_tool');
        $url = "https://gitee.com/api/v5/repos/" . $user . "/" . $project."?access_token=".$access_token;
        $key = 'License';
        $html = httpGetFull($url);
        $arr = json_decode($html,true);
        if (array_key_exists("id",$arr)) {
            $value = $arr['license'] ?? 'Unknown';
        } else {
            $value = 'Unknown';
        }
        break;
    case 'star':
        if (empty($_GET['project'])) {
            header('Location: https://gitee.com/hamm/svg_badge_tool');
            die;
        }
        $project = trim($_GET['project'] ?? 'svg_badge_tool');
        $url = "https://gitee.com/api/v5/repos/" . $user . "/" . $project."?access_token=".$access_token;
        $html = httpGetFull($url);
        $arr = json_decode($html,true);
        if (array_key_exists("id",$arr)) {
            $value = $arr['stargazers_count'] ? $arr['stargazers_count']." Stars" : '***';
        } else {
            $value = '***';
        }
        break;
    case 'fork':
        if (empty($_GET['project'])) {
            header('Location: https://gitee.com/hamm/svg_badge_tool');
            die;
        }
        $project = trim($_GET['project'] ?? 'svg_badge_tool');
        $url = "https://gitee.com/api/v5/repos/" . $user . "/" . $project."?access_token=".$access_token;
        $html = httpGetFull($url);
        $arr = json_decode($html,true);
        if (array_key_exists("id",$arr)) {
            $value = $arr['forks_count'] ." Forks";
        } else {
            $value = '***';
        }
        break;
    case 'watch':
        if (empty($_GET['project'])) {
            header('Location: https://gitee.com/hamm/svg_badge_tool');
            die;
        }
        $project = trim($_GET['project'] ?? 'svg_badge_tool');
        $url = "https://gitee.com/api/v5/repos/" . $user . "/" . $project."?access_token=".$access_token;
        $html = httpGetFull($url);
        $arr = json_decode($html,true);
        if (array_key_exists("id",$arr)) {
            $value = $arr['watchers_count'] ." Watches" ;
        } else {
            $value = '***';
        }
        break;
    case 'issue':
        if (empty($_GET['project'])) {
            header('Location: https://gitee.com/hamm/svg_badge_tool');
        $url = "https://gitee.com/api/v5/repos/" . $user . "/" . $project."?access_token=".$access_token;
            die;
        }
        $project = trim($_GET['project'] ?? 'svg_badge_tool');
        $key = "Issues";
        $html = httpGetFull($url);
        $arr = json_decode($html,true);
        if (array_key_exists("id",$arr)) {
            $value = $arr['open_issues_count'] ." Opened" ;
        } else {
            $value = '***';
        }
        break;
    case 'branch':
        if (empty($_GET['project'])) {
            header('Location: https://gitee.com/hamm/svg_badge_tool');
        $url = "https://gitee.com/api/v5/repos/" . $user . "/" . $project."?access_token=".$access_token;
            die;
        }
        $project = trim($_GET['project'] ?? 'svg_badge_tool');
        $key = "Branch";
        $html = httpGetFull($url);
        $arr = json_decode($html,true);
        if (array_key_exists("id",$arr)) {
            $value = $arr['default_branch'] ? $arr['default_branch'] : " master";
        } else {
            $value = '***';
        }
        break;
    case 'release':
        if (empty($_GET['project'])) {
            header('Location: https://gitee.com/hamm/svg_badge_tool');
            die;
        }
        $project = trim($_GET['project'] ?? 'svg_badge_tool');
        $url = "https://gitee.com/api/v5/repos/" . $user . "/" . $project."?access_token=".$access_token;
        $key = "Release";
        $html = httpGetFull("https://gitee.com/api/v5/repos/" . $user . "/" . $project."/releases/latest?access_token=".$access_token);
        $arr = json_decode($html,true);
        if (array_key_exists("id",$arr)) {
            $value = $arr['name'] ? $arr['name'] : "No releases";
        } else {
            $value = 'No releases';
        }
        break;
    case 'commit':
        if (empty($_GET['project'])) {
            header('Location: https://gitee.com/hamm/svg_badge_tool');
            die;
        }
        $project = trim($_GET['project'] ?? 'svg_badge_tool');
        $url = "https://gitee.com/api/v5/repos/" . $user . "/" . $project."?access_token=".$access_token;
        try {
            $url = "https://gitee.com/" . $user . "/" . $project;
            $html = httpGetFull($url);
            $html = str_replace(PHP_EOL, '', $html);
            if (preg_match("/<i class='iconfont icon-commit'><\/i>(.*?) 次提交<\/a>/", $html, $matches)) {
                $value = $matches[1] . " Commits";
            } else {
                $value = "? Commits";
            }
        } catch (Exception $e) {
            $value = "? Commits";
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
if (empty($_GET['logo']) || $_GET['logo'] == 'yes') {
    $icon_length = 150;
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
            <?php
            if ($icon_length > 0) {
            ?>
                <path d='m11 3c3.8659932 0 7 3.13400675 7 7 0 3.8659932-3.1340068 7-7 7-3.86599325 0-7-3.1340068-7-7 0-3.86599325 3.13400675-7 7-7zm3.5432118 3.11132544h-4.83952239c-1.43184146 0-2.5925783 1.16073684-2.5925783 2.5925783v4.83930806c0 .1909122.15476491.3456771.34567711.3456771h5.09883128c1.2886291 0 2.3332694-1.0446403 2.3332694-2.3332694v-1.98759234c0-.19091219-.1547649-.3456771-.3456771-.3456771h-3.9752867c-.1908769.00009053-.3456272.15480028-.3457677.34567709l-.0002263.86415815c-.0001254.1670481.1183197.306452.2758292.3387264l.0697574.0069478 2.4201471-.0000202c.1670482-.0000039.3064221.1184865.3386565.2760054l.0070206.0696688v.1728299c0 .5727365-.4642947 1.0370313-1.0370313 1.0370313h-3.2841898c-.19088479-.0000096-.34562897-.1547495-.34564376-.3456343l-.00009052-3.28387133c-.00004142-.53455415.40439698-.97465454.92397834-1.03097164l.11302439-.00605968h4.83885775c.1908285-.00021447.3455587-.15484874.3458915-.34567704l.000536-.86415823c.0002911-.16704802-.1180908-.30649438-.2755871-.33882517z' fill='#FFFFFF' id='Clip-8-Copy-5'></path>
            <?php
            }
            ?>
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