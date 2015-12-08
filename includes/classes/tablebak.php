<?php 
//ֻ��DbBak���ܵ�������� 
class TableBak{ 
var $_mysql_link_id; 
var $_dbDir; 
//private $_DbManager; 
function TableBak($mysql_link_id,$dbDir) 
{ 
$this->_mysql_link_id = $mysql_link_id; 
$this->_dbDir = $dbDir; 
} 
function backupTable($tableName) 
{ 
//step1:������ı���Ŀ¼���� 
$tableDir = $this->_dbDir.DIRECTORY_SEPARATOR.$tableName; 
!is_dir($tableDir) && mkdir($tableDir); 
//step2:��ʼ���ݣ� 
$this->_backupTable($tableName,$tableDir); 
} 
function restoreTable($tableName,$tableBakFile) 
{ 
set_time_limit(0); 
$fileArray = @file($tableBakFile) or die("can open file $tableBakFile"); 
$num = count($fileArray); 
mysql_unbuffered_query("DELETE FROM $tableName"); 
$sql = $fileArray[0]; 
for ($i=1;$i<$num-1;$i++){ 
mysql_unbuffered_query($sql.$fileArray[$i]) or (die (mysql_error())); 
} 
return true; 
} 
function _getFieldInfo($tableName){ 
$fieldInfo = array(); 
$sql="SELECT * FROM $tableName LIMIT 1"; 
$result = mysql_query($sql,$this->_mysql_link_id); 
$num_field=mysql_num_fields($result); 
for($i=0;$i<$num_field;$i++){ 
$field_name=mysql_field_name($result,$i); 
$field_type=mysql_field_type($result,$i); 
$fieldInfo[$field_name] = $field_type; 
} 
mysql_free_result($result); 
return $fieldInfo; 
} 
function _quoteRow($fieldInfo,$row){ 
foreach ($row as $field_name=>$field_value){ 
$field_value=strval($field_value); 
switch($fieldInfo[$field_name]){ 
case "blob": $row[$field_name] = "'".mysql_escape_string($field_value)."'";break; 
case "string": $row[$field_name] = "'".mysql_escape_string($field_value)."'";break; 
case "date": $row[$field_name] = "'".mysql_escape_string($field_value)."'";break; 
case "datetime": $row[$field_name] = "'".mysql_escape_string($field_value)."'";break; 
case "time": $row[$field_name] = "'".mysql_escape_string($field_value)."'";break; 
case "unknown": $row[$field_name] = "'".mysql_escape_string($field_value)."'";break; 
case "int": $row[$field_name] = intval($field_value); break; 
case "real": $row[$field_name] = intval($field_value); break; 
case "timestamp":$row[$field_name] = intval($field_value); break; 
default: $row[$field_name] = intval($field_value); break; 
} 
} 
return $row; 
} 
function _backupTable($tableName,$tableDir) 
{ 
//ȡ�ñ���ֶ����ͣ� 
$fieldInfo = $this->_getFieldInfo($tableName); 
//step1:����INSERT���ǰ�벿�� ��д���ļ��� 
$fields = array_keys($fieldInfo); 
$fields = implode(',',$fields); 
$sqltext="INSERT INTO $tableName($fields)VALUES \r\n"; 
$datafile = $tableDir.DIRECTORY_SEPARATOR.$tableName.'.sql'; 
(!$handle = fopen($datafile,'w')) && die("can not open file <b>$datafile</b>"); 
(!fwrite($handle, $sqltext)) && die("can not write data to file <b>$datafile</b>"); 
fclose($handle); 
//step2:ȡ������ ��д���ļ��� 
//ȡ������Դ�� 
set_time_limit(0); 
$sql = "select * from $tableName"; 
$result = mysql_query($sql,$this->_mysql_link_id); 
//�����ݱ����ļ�:$tableName.xml 
$datafile = $tableDir.DIRECTORY_SEPARATOR.$tableName.'.sql'; 
(!$handle = fopen($datafile,'a')) && die("can not open file <b>$datafile</b>"); 
//����ȡ�ñ��¼��д���ļ��� 
while ($row = mysql_fetch_assoc($result)) { 
$row = $this->_quoteRow($fieldInfo,$row); 
$record='(' . implode(',',$row) . ");\r\n"; 
(!fwrite($handle, $record)) && die("can not write data to file <b>$datafile</b>"); 
} 
mysql_free_result($result); 
//�ر��ļ��� 
fclose($handle); 
return true; 
} 
} 
?> 
