<?
require_once('tablebak.php'); 
class DbBak { 
var $_mysql_link_id; 
var $_dataDir; 
var $_tableList; 
var $_TableBak; 
function DbBak($_mysql_link_id,$dataDir) 
{ 
( (!is_string($dataDir)) || strlen($dataDir)==0) && die('error:$datadir is not a string'); 
!is_dir($dataDir) && mkdir($dataDir); 
$this->_dataDir = $dataDir; 
$this->_mysql_link_id = $_mysql_link_id; 
} 
function backupDb($dbName,$tableName=null) 
{ 
( (!is_string($dbName)) || strlen($dbName)==0 ) && die('$dbName must be a string value'); 
//step1:ѡ�����ݿ⣺ 
mysql_select_db($dbName); 
//step2:�������ݿⱸ��Ŀ¼ 
$dbDir = $this->_dataDir.DIRECTORY_SEPARATOR.$dbName; 
!is_dir($dbDir) && mkdir($dbDir); 
//step3:�õ����ݿ����б��� ����ʼ���ݱ� 
$this->_TableBak = new TableBak($this->_mysql_link_id,$dbDir); 
if(is_null($tableName)){//backup all table in the db 
$this->_backupAllTable($dbName); 
return; 
} 
if(is_string($tableName)){ 
(strlen($tableName)==0) && die('....'); 
$this->_backupOneTable($dbName,$tableName); 
return; 
} 
if (is_array($tableName)){ 
foreach ($tableName as $table){ 
( (!is_string($table)) || strlen($table)==0 ) && die('....'); 
} 
$this->_backupSomeTalbe($dbName,$tableName); 
return; 
} 
} 
function restoreDb($dbName,$tableName=null){ 
( (!is_string($dbName)) || strlen($dbName)==0 ) && die('$dbName must be a string value'); 
//step1:����Ƿ�������ݿ� �����ӣ� 
@mysql_select_db($dbName) || die("the database <b>$dbName</b> dose not exists"); 
//step2:����Ƿ�������ݿⱸ��Ŀ¼ 
$dbDir = $this->_dataDir.DIRECTORY_SEPARATOR.$dbName; 
!is_dir($dbDir) && die("$dbDir not exists"); 
//step3:start restore 
$this->_TableBak = new TableBak($this->_mysql_link_id,$dbDir); 
if(is_null($tableName)){//backup all table in the db 
$this->_restoreAllTable($dbName); 
return; 
} 
if(is_string($tableName)){ 
(strlen($tableName)==0) && die('....'); 
$this->_restoreOneTable($dbName,$tableName); 
return; 
} 
if (is_array($tableName)){ 
foreach ($tableName as $table){ 
( (!is_string($table)) || strlen($table)==0 ) && die('....'); 
} 
$this->_restoreSomeTalbe($dbName,$tableName); 
return; 
} 
} 
function _getTableList($dbName) 
{ 
$tableList = array(); 
$result=mysql_list_tables($dbName,$this->_mysql_link_id); 
for ($i = 0; $i < mysql_num_rows($result); $i++){ 
array_push($tableList,mysql_tablename($result, $i)); 
} 
mysql_free_result($result); 
return $tableList; 
} 
function _backupAllTable($dbName) 
{ 
foreach ($this->_getTableList($dbName) as $tableName){ 
$this->_TableBak->backupTable($tableName); 
} 
} 
function _backupOneTable($dbName,$tableName) 
{ 
!in_array($tableName,$this->_getTableList($dbName)) && die("ָ���ı���<b>$tableName</b>�����ݿ��в�����"); 
$this->_TableBak->backupTable($tableName); 
} 
function _backupSomeTalbe($dbName,$TableNameList) 
{ 
foreach ($TableNameList as $tableName){ 
!in_array($tableName,$this->_getTableList($dbName)) && die("ָ���ı���<b>$tableName</b>�����ݿ��в�����"); 
} 
foreach ($TableNameList as $tableName){ 
$this->_TableBak->backupTable($tableName); 
} 
} 
function _restoreAllTable($dbName) 
{ 
//step1:����Ƿ�����������ݱ�ı����ļ� �Լ��Ƿ��д�� 
foreach ($this->_getTableList($dbName) as $tableName){ 
$tableBakFile = $this->_dataDir.DIRECTORY_SEPARATOR 
. $dbName.DIRECTORY_SEPARATOR 
. $tableName.DIRECTORY_SEPARATOR 
. $tableName.'.sql'; 
!is_writeable ($tableBakFile) && die("$tableBakFile not exists or unwirteable"); 
} 
//step2:start restore 
foreach ($this->_getTableList($dbName) as $tableName){ 
$tableBakFile = $this->_dataDir.DIRECTORY_SEPARATOR 
. $dbName.DIRECTORY_SEPARATOR 
. $tableName.DIRECTORY_SEPARATOR 
. $tableName.'.sql'; 
$this->_TableBak->restoreTable($tableName,$tableBakFile); 
} 
} 
function _restoreOneTable($dbName,$tableName) 
{ 
//step1:����Ƿ�������ݱ�: 
!in_array($tableName,$this->_getTableList($dbName)) && die("ָ���ı���<b>$tableName</b>�����ݿ��в�����"); 
//step2:����Ƿ�������ݱ����ļ� �Լ��Ƿ��д�� 
$tableBakFile = $this->_dataDir.DIRECTORY_SEPARATOR 
. $dbName.DIRECTORY_SEPARATOR 
. $tableName.DIRECTORY_SEPARATOR 
. $tableName.'.sql'; 
!is_writeable ($tableBakFile) && die("$tableBakFile not exists or unwirteable"); 
//step3:start restore 
$this->_TableBak->restoreTable($tableName,$tableBakFile); 
} 
function _restoreSomeTalbe($dbName,$TableNameList) 
{ 
//step1:����Ƿ�������ݱ�: 
foreach ($TableNameList as $tableName){ 
!in_array($tableName,$this->_getTableList($dbName)) && die("ָ���ı���<b>$tableName</b>�����ݿ��в�����"); 
} 
//step2:����Ƿ�������ݱ����ļ� �Լ��Ƿ��д�� 
foreach ($TableNameList as $tableName){ 
$tableBakFile = $this->_dataDir.DIRECTORY_SEPARATOR 
. $dbName.DIRECTORY_SEPARATOR 
. $tableName.DIRECTORY_SEPARATOR 
. $tableName.'.sql'; 
!is_writeable ($tableBakFile) && die("$tableBakFile not exists or unwirteable"); 
} 
//step3:start restore: 
foreach ($TableNameList as $tableName){ 
$tableBakFile = $this->_dataDir.DIRECTORY_SEPARATOR 
. $dbName.DIRECTORY_SEPARATOR 
. $tableName.DIRECTORY_SEPARATOR 
. $tableName.'.sql'; 
$this->_TableBak->restoreTable($tableName,$tableBakFile); 
} 
} 
} 
?> 
