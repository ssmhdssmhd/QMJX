<?php
/**
 * QMJX - 多线路播放页（等效 quanminjiexi.com/jx/?url=）
 * 按视频域名选择默认解析接口，顶部可切换全部线路
 */
$url = isset($_GET['url']) ? trim($_GET['url']) : '';
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
<title>QMJX 多通道解析</title>
<style>
html,body{margin:0;padding:0;height:100%;overflow:hidden;background:#000}
.panel{display:none;position:absolute;top:0;left:0;width:100%;z-index:10;background:rgba(20,20,20,.95);padding:8px 4px;text-align:center}
.panel a{display:inline-block;margin:3px 6px;padding:5px 12px;color:#fff;background:#e64533;border-radius:4px;text-decoration:none;font-size:14px}
.panel a:hover{background:#c73626}
.slide{position:absolute;top:0;right:10px;z-index:11;margin:0}
.slide a{display:inline-block;padding:6px 14px;background:#f7b52c;color:#fff;font-size:13px;border-radius:0 0 6px 6px;cursor:pointer;text-decoration:none}
#WANG{position:absolute;top:0;left:0;width:100%;height:100%;border:0}
</style>
</head>
<body>
<div class="panel" id="panel"></div>
<p class="slide"><a class="OK-jiexi" id="toggle">切换线路</a></p>
<iframe id="WANG" scrolling="no" allowtransparency="true" frameborder="0" src="" allowfullscreen></iframe>
<script>
var VIDEO_URL = <?php echo json_encode($url, JSON_UNESCAPED_SLASHES); ?>;

// 与原站 jx 页面一致的域名路由：搜狐走 xxphp，其余走 nnxv
var DEFAULT_APIS = {
    sohu:  'https://vip.xxphp.cn/wxd.php?wd=',
    other: 'https://jx.nnxv.cn/tv.php?url='
};

// 全部备用线路（对应 api.php 的 n 参数）
var LINE_COUNT = 9;

function buildPanel() {
    var p = document.getElementById('panel'), html = '';
    for (var n = 1; n < LINE_COUNT; n++) {
        html += '<a href="javascript:playLine(' + n + ')">[' + (n === 1 ? '默认1' : '线路' + n) + ']</a>';
    }
    p.innerHTML = html;
}

function play(src) {
    document.getElementById('WANG').src = src;
}

function playLine(n) {
    play('/api.php?n=' + n + '&url=' + VIDEO_URL);
    togglePanel();
}

function togglePanel() {
    var p = document.getElementById('panel');
    p.style.display = (p.style.display === 'block') ? 'none' : 'block';
}

function defaultPlay() {
    if (!VIDEO_URL) return;
    var api = (VIDEO_URL.indexOf('sohu.com') >= 0) ? DEFAULT_APIS.sohu : DEFAULT_APIS.other;
    play(api + VIDEO_URL);
}

document.getElementById('toggle').onclick = togglePanel;
buildPanel();
defaultPlay();
</script>
</body>
</html>
