<?php
/**
 * QMJX - 线路解析出口（等效 quanminjiexi.com/api.php）
 * 用法: api.php?n={线路号}&url={视频地址}
 * 行为: 302 跳转到对应上游解析接口
 */

// 线路表（逆向自原站 api.php 的 302 目标）
$LINES = [
    0 => 'https://api.uono.uno/?v=%s',                       // 全能VIP解析通道
    1 => 'https://jx.nnxv.cn/tv.php?url=%s',                 // 备用线路1（原站默认）
    2 => 'https://jx.nnxv.cn/tv.php?url=%s',                 // 备用线路2
    3 => 'https://wpsseo.cn/player/?id=%s',                  // 备用线路3
    4 => 'https://vip.xxphp.cn/1907.php?eps=0&wd=%s',        // 备用线路4
    5 => 'https://jx.playerjy.com/?ads=0&url=%s',            // 备用线路5
    6 => 'https://t2.qlplayer.cyou/player/?url=%s',          // 备用线路6
    7 => 'https://wpsseo.cn/player/?id=%s',                  // 备用线路7
    8 => 'https://video.isyour.love/player/getplayer?url=%s',// 备用线路8
];

$n   = isset($_GET['n']) ? intval($_GET['n']) : 1;
$url = isset($_GET['url']) ? trim($_GET['url']) : '';

if ($url === '') {
    http_response_code(400);
    exit('missing url');
}
if (!isset($LINES[$n])) {
    http_response_code(404);
    exit('unknown line');
}

// 与原站一致：直接拼接未编码的 URL（上游接口把末尾整段当作视频地址）
header('Location: ' . sprintf($LINES[$n], $url), true, 302);
exit;
