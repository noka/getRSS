<?php
/*
* getRSS
*
* RSS/Atomフィードを取得する簡易スニペット
* [[getRSS &url &n &tpl]] / [*tv_url:getRSS(n)*]
*
*/

if(isset($value)) $url=$value;
if(isset($opt)) $n=$opt;

if(!isset($url)) return;
if(!isset($n)) $n=5; else $n=intval($n);
if(!isset($tpl)){
  $format = '<li class="rss-item"><a href="[+url+]" target="_blank"><span class="rss-date"><time>[+date:date(%Y.%m.%d)+]</time></span><span class="rss-title">[+title+]</span></a></li>';
}else{
  $format = $modx->getChunk($tpl);
}

//where is simplepie?
$autoload = $modx->config['base_path'] . 'assets/snippets/getRSS/simplepie/autoloader.php';
require_once($autoload);

$feed = new SimplePie();
$feed->set_feed_url($url);
if(!file_exists($modx->config['base_path'] . "assets/cache/rss/"))mkdir($modx->config['base_path'] . "assets/cache/rss/", 0777, true);
$feed->set_cache_location($modx->config['base_path'] . "assets/cache/rss/");
$feed->set_cache_duration(1800);
$success = $feed->init();

$c=1;
$r="";

if ($success){
  foreach ($feed->get_items() as $e ) {
    $cate = array();
    foreach ((array)$e->get_categories() as $category){
      $cate[] = $category->get_label();
    };
    $ph=array(
      'url'=>$e->get_link(),
      'date'=>$e->get_date(),
      'title'=> $e->get_title(),
      'summary'=>$e->get_description(),
      'categories'=>implode(',',$cate),
      'category'=>$cate[0],
    );
    $r .= $modx->parseText($format, $ph);
    if($c++==$n)break;
  }
}else{
    $r='<li>最新情報の取得に失敗しました。</li>';
}

return $r;
