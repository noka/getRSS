# getRSS
RSS/Atomの取得用modxのスニペット。simplepieライブラリ使用

### 使用方法

```
[[getRSS? &url=`atom/rss取得するURL` &tpl=`テンプレートチャンク名` &n=`取得件数`]]
```

もしくは、

```
[*tv_url:getRSS(n)*]
```

テンプレートで使用できるプレースホルダは、

```
[+title+][+url+][+date+][+summary+]
```

※Dittoテンプレートが使い回せるイメージ。

