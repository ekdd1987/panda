<?php
/*
* 获取页码导航HTML
* @param $pageNum：当前页码
* @param $pageSize：每页数量
* @param $rowCount：记录总数
* @param $navUrl：链接页面URL
*/
function getNavHtml($pageNum,$pageSize,$rowCount,$navUrl){
$pageCount = (int)($rowCount/$pageSize); //总页数
if ($rowCount % $pageSize >0){
$pageCount++;
}
if ($pageNum>$pageCount){
$pageNum = 1;
}
$firstNav = "<a href=\"{$navUrl}page=1\" class=p_num>首页</a> ";
$lastNav = "<a href=\"{$navUrl}page={$pageCount}\" class=p_num>尾页</a> ";
$prevNav="";
$nextNav="";
if ($pageNum>1){
$navPageNum = $pageNum-1;
$prevNav = "<a href=\"{$navUrl}page={$navPageNum}\" class=p_num>上一页</a> ";
}
if ($pageNum<$pageCount && $pageCount>1){
$navPageNum = $pageNum+1;
$nextNav = "<a href=\"{$navUrl}page={$navPageNum}\" class=p_num>下一页</a> ";
}
$amongNav="";

//关键循环

for ($i=1;$i<=5;$i++){
$navPageNum = $pageNum+ $i-3;
if ($navPageNum>0 && $navPageNum<=$pageCount){
$navCss = $navPageNum == $pageNum?" class=\"hover\"":"";
$amongNav.="<a href=\"{$navUrl}page={$navPageNum}\" $navCss class=p_num>{$navPageNum}</a> ";
}
}
echo $firstNav.$prevNav.$amongNav.$nextNav.$lastNav." <span class=p_num>".$pageNum."/".$pageCount."</span> <span class=p_num>共有[".$rowCount."]条数据</span>";
}

?>