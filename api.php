<?php
/**
 * QMJX - 线路解析出口（等效 quanminjiexi.com/api.php）
 * 版本: v0.0.2 新增 JSON 格式输出
 *
 * 用法:
 *   网页跳转:  api.php?n={线路号}&url={视频地址}              → 302 到上游播放页
 *   JSON 输出: api.php?url={视频地址}&format=json             → 全部线路 + 拼接好的播放地址
 *              api.php?n={线路号}&url={视频地址}&format=json   → 单条线路
 *              api.php?format=json                            → 接口清单（不含播放地址）
 */

// 线路表：n => [名称, 接口前缀, 备注]
// n=0-8 逆向自 quanminjiexi.com/api.php；n=9-14 逆向自 ScriptCat「404小站·VIP追剧神器 v3.5.6」
$LINES = [
    0  => ['全能VIP解析通道', 'https://api.uono.uno/?v=',                        ''],
    1  => ['备用线路1',       'https://jx.nnxv.cn/tv.php?url=',                  '原站默认线路'],
    2  => ['备用线路2',       'https://jx.nnxv.cn/tv.php?url=',                  ''],
    3  => ['备用线路3',       'https://wpsseo.cn/player/?id=',                   ''],
    4  => ['备用线路4',       'https://vip.xxphp.cn/1907.php?eps=0&wd=',         ''],
    5  => ['备用线路5',       'https://jx.playerjy.com/?ads=0&url=',             ''],
    6  => ['备用线路6',       'https://t2.qlplayer.cyou/player/?url=',           ''],
    7  => ['备用线路7',       'https://wpsseo.cn/player/?id=',                   ''],
    8  => ['备用线路8·邦宁',  'https://video.isyour.love/player/getplayer?url=', ''],
    9  => ['TXNQ',            'https://bfq.txnp.cn/player?url=',                 '追剧神器实测最稳'],
    10 => ['酥皮',            'https://art.txnp.cn/?url=',                       '与TXNQ同一家'],
    11 => ['麒麟',            'https://free.maccms.xyz/?url=',                   ''],
    12 => ['M1907',           'https://im1907.top/?jx=',                         '支持选集'],
    13 => ['SVIP',            'https://svip.qlplayer.cyou/?url=',                '66大片网真接口'],
    14 => ['LX解析',          'https://jx.lxyy.club/index.php?url=',             '仅弹窗可用，内嵌会被域名授权拦截'],
];

const VERSION = '0.0.2';

$n      = isset($_GET['n']) ? intval($_GET['n']) : -1;
$url    = isset($_GET['url']) ? trim($_GET['url']) : '';
$isJson = (isset($_GET['format']) && $_GET['format'] === 'json')
       || (isset($_GET['type']) && $_GET['type'] === 'json');

/* ---------------- JSON 输出模式 ---------------- */
if ($isJson) {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');

    $build = function ($n, $line) use ($url) {
        [$name, $api, $note] = $line;
        $item = [
            'n'    => $n,
            'name' => $name,
            'api'  => $api,
            'play' => $url !== '' ? $api . $url : null,
        ];
        if ($note !== '') $item['note'] = $note;
        return $item;
    };

    // 单条线路
    if ($n >= 0) {
        if (!isset($LINES[$n])) {
            http_response_code(404);
            echo json_encode(['code' => 404, 'msg' => 'unknown line', 'n' => $n], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit;
        }
        echo json_encode(['code' => 200, 'msg' => 'success', 'version' => VERSION, 'url' => $url, 'data' => $build($n, $LINES[$n])], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    // 全部线路
    $list = [];
    foreach ($LINES as $k => $line) $list[] = $build($k, $line);
    echo json_encode([
        'code'    => 200,
        'msg'     => 'success',
        'version' => VERSION,
        'url'     => $url,
        'total'   => count($list),
        'data'    => $list,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

/* ---------------- 网页 302 跳转模式（与原站一致） ---------------- */
if ($url === '') {
    http_response_code(400);
    exit('missing url');
}
if (!isset($LINES[$n])) {
    http_response_code(404);
    exit('unknown line');
}

// 与原站一致：直接拼接未编码的 URL（上游接口把末尾整段当作视频地址）
header('Location: ' . $LINES[$n][1] . $url, true, 302);
exit;
