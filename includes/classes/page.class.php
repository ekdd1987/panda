<?php
/*
* ��ҳ��
*/
function page($page,$total,$phpfile,$pagesize=3,$pagelen=3,$key=''){
$pagecode = '';//�����������ŷ�ҳ���ɵ�HTML
$page = intval($page);//���������ҳ��
$total = intval($total);//��֤�ܼ�¼��ֵ������ȷ
if(!$total) return array();//�ܼ�¼��Ϊ�㷵�ؿ�����
$pages = ceil($total/$pagesize);//�����ܷ�ҳ
//����ҳ��Ϸ���
if($page<1) $page = 1;
if($page>$pages) $page = $pages;
//�����ѯƫ����
$offset = $pagesize*($page-1);
//ҳ�뷶Χ����
$init = 1;//��ʼҳ����
$max = $pages;//����ҳ����
$pagelen = ($pagelen%2)?$pagelen:$pagelen+1;//ҳ�����
$pageoffset = ($pagelen-1)/2;//ҳ���������ƫ����

//����html
$pagecode='<div class="page">';
$pagecode.="<span> $page / $pages </span>";//�ڼ�ҳ,����ҳ
//����ǵ�һҳ������ʾ��һҳ����һҳ������
if($page!=1){
$pagecode.="<a href=do.php?".key::GetEncrypt("{$phpfile}?key=".$key."page=1")."> ��һҳ </a>";//��һҳ
$pagecode.="<a href=do.php?".key::GetEncrypt("{$phpfile}?key=".$key."page=".($page-1))."> ��һҳ </a>";
}
//��ҳ������ҳ�����ʱ����ƫ��
if($pages>$pagelen){
//�����ǰҳС�ڵ�����ƫ��
if($page<=$pageoffset){
$init=1;
$max = $pagelen;
}else{//�����ǰҳ������ƫ��
//�����ǰҳ����ƫ�Ƴ�������ҳ��
if($page+$pageoffset>=$pages+1){
$init = $pages-$pagelen+1;
}else{
//����ƫ�ƶ�����ʱ�ļ���
$init = $page-$pageoffset;
$max = $page+$pageoffset;
}
}
}
//����html
for($i=$init;$i<=$max;$i++){
if($i==$page){
$pagecode.='<span> '.$i.' </span>';
} else {
$pagecode.="<a href=do.php?".key::GetEncrypt("{$phpfile}?key=".$key."&page={$i}")."> $i </a>";
}
}
if($page!=$pages){
$pagecode.="<a href=do.php?".key::GetEncrypt("{$phpfile}?key=".$key."&page=".($page+1))."> ��һҳ </a>";//��һҳ
$pagecode.="<a href=do.php?".key::GetEncrypt("{$phpfile}?key=".$key."&page={$pages}")."> ���һҳ </a>";//���һҳ
}
$pagecode.='</div>';
return array('pagecode'=>$pagecode,'sqllimit'=>' limit '.$offset.','.$pagesize);
}
?>