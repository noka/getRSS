<?php

include_once(__DIR__ . '/functions.inc.php');

if(getRss::is_modifier()) {
    $modx->event->params['url'] = $value;
    if(isset($opt)) {
        $modx->event->params['n'] = $opt;
    }
}

if(!getRss::param('url')) {
    return;
}

$simplepie = getRss::simplepie_object();
if (!$simplepie->init()){
    return '<li>最新情報の取得に失敗しました。</li>';
}

$c = 1;
foreach ($simplepie->get_items() as $item) {
    if(getRss::param('n', 5) < $c) {
        break;
    }
    $categories = array();
    foreach ((array)$item->get_categories() as $category){
        $categories[] = $category->get_label();
    };
    $feeds[] = evo()->parseText(
        getRss::format()
        , array(
            'url'        => $item->get_link(),
            'date'       => $item->get_date(),
            'title'      => $item->get_title(),
            'summary'    => $item->get_description(),
            'categories' => implode(',', $categories),
            'category'   => $categories ? $categories[0] : '',
        )
    );
    $c++;
}
return implode("\n", $feeds);
