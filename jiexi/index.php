<?php
/**
 * QMJX - 多通道解析入口（等效 quanminjiexi.com/jiexi/?jx=）
 * 302 跳转到多线路播放页 /jx/?url=
 */
$url = isset($_GET['jx']) ? trim($_GET['jx']) : (isset($_GET['url']) ? trim($_GET['url']) : '');
if ($url === '') {
    header('Location: /', true, 302);
    exit;
}
header('Location: ../jx/?url=' . $url, true, 302);
exit;
