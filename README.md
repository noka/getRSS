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

`[+title+]`
`[+url+]`
`[+date+]`
`[+summary+]`
`[+category+]`
`[+categories+]`

※Dittoテンプレートが使い回せるイメージ。

### 応用例

```
[+categories:find('お知らせ'):then('
    <li>
        <a href="[+url+]">
            <span class="date">[+date:date(%Y.%m.%d)+]</span>
            <span>[+title+]</span>
        </a>
    </li>
'):else('
    <!-- none -->
')+]
```
http://forum.modx.jp/viewtopic.php?t=1919
