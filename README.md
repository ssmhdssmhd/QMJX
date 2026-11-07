# QMJX 全民视频解析（功能复刻版）

> 当前版本：**QMJX.0.0.2 202611080714**
>
> 版本号规则：`v0.0.1` 起，满百进一位（v0.0.99 → v0.1.0）

对 `quanminjiexi.com` 视频解析站的逆向复刻，实现相同的 VIP 视频在线解析效果。
代码为独立重写，仅复用其「线路 → 上游解析接口」的路由配置。

## 逆向结论（原站工作原理）

原站本身不做解析，本质是一个**多线路跳转聚合器**：

```
首页 index.php
  └─ 选择线路 + 输入视频地址 → dihejk() 拼接前缀生成 iframe
       ├─ ./jiexi/?jx={url}        → 302 → ./jx/?url={url}     （多通道播放页）
       └─ ./line.php?n=N&url={url} → iframe 外壳
            └─ ./api.php?n=N&url={url} → 302 到上游解析接口
```

`api.php` 线路表（n → 上游 302 目标）：

| n | 上游解析接口 |
|---|--------------|
| 0 | `https://api.uono.uno/?v={url}` |
| 1 | `https://jx.nnxv.cn/tv.php?url={url}` |
| 2 | `https://jx.nnxv.cn/tv.php?url={url}` |
| 3 | `https://wpsseo.cn/player/?id={url}` |
| 4 | `https://vip.xxphp.cn/1907.php?eps=0&wd={url}` |
| 5 | `https://jx.playerjy.com/?ads=0&url={url}` |
| 6 | `https://t2.qlplayer.cyou/player/?url={url}` |
| 7 | `https://wpsseo.cn/player/?id={url}` |
| 8 | `https://video.isyour.love/player/getplayer?url={url}` |

v0.0.2 新增线路（逆向自 ScriptCat「404小站·VIP追剧神器 v3.5.6」）：

| n | 名称 | 上游解析接口 |
|---|------|--------------|
| 9 | TXNQ | `https://bfq.txnp.cn/player?url={url}` |
| 10 | 酥皮 | `https://art.txnp.cn/?url={url}` |
| 11 | 麒麟 | `https://free.maccms.xyz/?url={url}` |
| 12 | M1907 | `https://im1907.top/?jx={url}` |
| 13 | SVIP | `https://svip.qlplayer.cyou/?url={url}`（66大片网真接口） |
| 14 | LX解析 | `https://jx.lxyy.club/index.php?url={url}`（仅弹窗可用） |

`/jx/` 多通道页默认路由规则：搜狐视频 → `vip.xxphp.cn/wxd.php?wd=`，其余平台 → `jx.nnxv.cn/tv.php?url=`，顶部可切换全部备用线路。

## JSON API（v0.0.2 新增）

`api.php` 在原有 302 跳转之外，新增 `format=json` 输出，方便 App / 脚本直接调用：

```
# 全部线路 + 拼接好的播放地址
api.php?url={视频地址}&format=json

# 单条线路
api.php?n=9&url={视频地址}&format=json

# 接口清单（不含播放地址）
api.php?format=json
```

响应示例：

```json
{
  "code": 200,
  "msg": "success",
  "version": "0.0.2",
  "url": "https://v.qq.com/x/cover/xxx.html",
  "total": 15,
  "data": [
    {
      "n": 9,
      "name": "TXNQ",
      "api": "https://bfq.txnp.cn/player?url=",
      "play": "https://bfq.txnp.cn/player?url=https://v.qq.com/x/cover/xxx.html",
      "note": "追剧神器实测最稳"
    }
  ]
}
```

已开启 `Access-Control-Allow-Origin: *`，支持跨域调用。

## 文件结构

| 文件 | 作用 |
|------|------|
| [index.php](index.php) | 首页：线路选择 + 地址输入 + 内嵌播放 |
| [api.php](api.php) | 线路出口：302 跳转上游解析接口（核心） |
| [line.php](line.php) | 单线路 iframe 播放外壳 |
| [jiexi/index.php](jiexi/index.php) | 多通道入口，302 到 `/jx/` |
| [jx/index.php](jx/index.php) | 多线路播放页，支持切换线路 |

Logo 资源引用自 GitHub [ssmhdssmhd/MXLOGO](https://github.com/ssmhdssmhd/MXLOGO)（web/web-logo.png）。

## 运行

```bash
php -S 0.0.0.0:8000 -t /workspace
# 浏览器打开 http://127.0.0.1:8000
```

## 使用

1. 打开视频平台（腾讯/爱奇艺/优酷/芒果等）某部影片的播放页，复制地址栏 URL；
2. 粘贴到首页输入框，选择线路（推荐默认「多通道解析」）；
3. 点击「开始解析」，下方内嵌播放器直接播放。

## 更新日志

- **QMJX.0.0.2 202611080714** api.php 新增 `format=json` JSON 格式输出（全线路/单线路/纯清单三种，支持跨域）；合并 ScriptCat「404小站·VIP追剧神器」逆向出的 6 条新接口为线路 9-14；首页下拉框同步补充新线路。
- **QMJX.0.0.1 202611080548** 首次发布：完成 quanminjiexi.com 逆向，复刻首页解析、api.php 九条线路、line.php 外壳、jiexi 多通道跳转与 jx 播放页。

## 免责声明

本项目仅供学习交流使用，解析能力由第三方公开接口提供，请于下载后 24 小时内删除，勿用于商业用途。
