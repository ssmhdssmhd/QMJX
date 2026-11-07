<?php
/**
 * QMJX - 全民视频解析（功能复刻版）
 * 版本: v0.0.2
 */
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>视频解析 - 全民解析 - 全网影视视频在线解析</title>
<meta name="keywords" content="视频解析,全民解析,优酷VIP解析,爱奇艺VIP解析,腾讯VIP解析,乐视VIP解析,视频解析接口,芒果VIP解析等解析接口">
<meta name="description" content="全民视频解析为广大网友提供优酷VIP解析,爱奇艺VIP解析,腾讯VIP解析,乐视VIP解析,芒果VIP解析等解析。">
<link rel="icon" href="https://raw.githubusercontent.com/ssmhdssmhd/MXLOGO/main/favicon/favicon-32.png">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:"PingFang SC","Microsoft YaHei",sans-serif;background:#f0f2f5 url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"><circle cx="2" cy="2" r="1" fill="%23d9dee4"/></svg>') repeat;min-height:100vh}
.topbar{position:fixed;top:0;left:0;right:0;height:52px;background:#2d3238;z-index:100;display:flex;align-items:center;padding:0 16px}
.topbar .brand{display:flex;align-items:center;color:#fff;font-size:18px;font-weight:600;text-decoration:none}
.topbar .brand img{width:32px;height:32px;margin-right:8px;border-radius:6px}
.wrap{max-width:860px;margin:0 auto;padding:84px 12px 40px}
.logo-box{text-align:center;margin:18px 0 26px}
.logo-box img{width:80%;max-width:360px}
.card{background:#fff;border-radius:10px;box-shadow:0 2px 12px rgba(0,0,0,.08);padding:22px 18px}
.form-row{display:flex;flex-wrap:wrap;gap:10px}
.form-row select,.form-row input{height:48px;font-size:16px;border:1px solid #d0d5dd;border-radius:8px;padding:0 12px;outline:none}
.form-row select:focus,.form-row input:focus{border-color:#e64533}
.form-row select{width:100%;max-width:280px}
.form-row input{flex:1;min-width:200px}
.btn{height:48px;padding:0 34px;font-size:18px;color:#fff;background:#e64533;border:none;border-radius:8px;cursor:pointer;white-space:nowrap}
.btn:hover{background:#c73626}
.player{margin-top:28px;width:100%;display:none}
.player iframe{width:100%;height:60vh;min-height:360px;border:0;border-radius:10px;background:#000}
.platforms{margin-top:30px;background:#fff;border-radius:10px;box-shadow:0 2px 12px rgba(0,0,0,.08);padding:18px}
.platforms h2{font-size:16px;color:#333;margin-bottom:12px}
.tag{display:inline-block;margin:4px 6px;padding:6px 14px;background:#f4f6f9;border-radius:16px;font-size:14px;color:#555}
.footer{text-align:center;color:#99a1ab;font-size:12px;margin-top:34px}
@media (max-width:640px){.form-row select{max-width:100%}.btn{width:100%}}
</style>
</head>
<body>
<nav class="topbar">
    <a class="brand" href="/"><img src="https://raw.githubusercontent.com/ssmhdssmhd/MXLOGO/main/web/web-logo.png" alt="logo">全民视频解析</a>
</nav>

<div class="wrap">
    <div class="logo-box">
        <img src="https://raw.githubusercontent.com/ssmhdssmhd/MXLOGO/main/web/web-logo.png" alt="全民视频解析">
    </div>

    <div class="card">
        <div class="form-row">
            <select id="jk">
                <option value="./line.php?n=0&url=">①全能VIP解析通道</option>
                <option value="./jiexi/?jx=" selected>超清VIP视频解析【多通道解析】</option>
                <option value="./line.php?n=1&url=">备用线路1</option>
                <option value="./line.php?n=2&url=">备用线路2</option>
                <option value="./line.php?n=3&url=">备用线路3</option>
                <option value="./line.php?n=4&url=">备用线路4</option>
                <option value="./line.php?n=5&url=">备用线路5</option>
                <option value="./line.php?n=6&url=">备用线路6</option>
                <option value="./line.php?n=7&url=">备用线路7</option>
                <option value="./line.php?n=8&url=">备用线路8</option>
                <option value="./line.php?n=9&url=">备用线路9·TXNQ</option>
                <option value="./line.php?n=10&url=">备用线路10·酥皮</option>
                <option value="./line.php?n=11&url=">备用线路11·麒麟</option>
                <option value="./line.php?n=12&url=">备用线路12·M1907</option>
                <option value="./line.php?n=13&url=">备用线路13·SVIP</option>
                <option value="./line.php?n=14&url=">备用线路14·LX解析</option>
            </select>
            <input type="search" id="url" placeholder="输入影片名称或粘贴视频地址到此处[手机直接长按粘贴网址-电脑使用Ctrl+V]" autocomplete="on">
            <button class="btn" type="button" onclick="dihejk()">开始解析</button>
        </div>
    </div>

    <div class="player" id="playerBox">
        <iframe id="bingdouplayer" allowfullscreen allow="autoplay; encrypted-media"></iframe>
    </div>

    <div class="platforms">
        <h2>支持平台（200+）</h2>
        <span class="tag">爱奇艺</span><span class="tag">优酷</span><span class="tag">腾讯视频</span><span class="tag">乐视</span><span class="tag">搜狐视频</span><span class="tag">芒果TV</span><span class="tag">1905电影网</span><span class="tag">西瓜视频</span><span class="tag">哔哩哔哩</span><span class="tag">咪咕视频</span>
    </div>

    <div class="footer">QMJX v0.0.2 · 仅供学习交流，请于下载后 24 小时内删除</div>
</div>

<script>
function dihejk() {
    var url = document.getElementById('url').value.trim();
    if (url === '') { alert('请输入视频地址'); return; }
    var jk = document.getElementById('jk');
    var prefix = jk.options[jk.selectedIndex].value;
    var box = document.getElementById('playerBox');
    box.style.display = 'block';
    document.getElementById('bingdouplayer').src = prefix + url;
    box.scrollIntoView({behavior: 'smooth'});
}
document.getElementById('url').addEventListener('keydown', function (e) {
    if (e.key === 'Enter') { e.preventDefault(); dihejk(); }
});
</script>
</body>
</html>
