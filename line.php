<?php
/**
 * QMJX - 单线路播放器外壳（等效 quanminjiexi.com/line.php）
 * 用法: line.php?n={线路号}&url={视频地址}
 */
$n   = isset($_GET['n']) ? intval($_GET['n']) : 0;
$url = isset($_GET['url']) ? trim($_GET['url']) : '';
if ($url === '') {
    http_response_code(400);
    exit('missing url');
}
$src = 'api.php?n=' . $n . '&url=' . $url;
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
<title>QMJX 播放器</title>
<style>html,body{margin:0;padding:0;width:100%;height:100%;overflow:hidden}iframe{display:block}</style>
</head>
<body>
<iframe src="<?php echo htmlspecialchars($src, ENT_QUOTES); ?>" width="100%" height="100%" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
</body>
</html>
