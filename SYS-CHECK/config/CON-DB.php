<!-- Code PHP ใช้สำหรับในการทดสอบ เชื่อใต่อ Database  -->
<?php
$serverName = "AOTHLP0135\SQLEXPRESS"; //serverName\instanceName
$connectionInfo = array( "Database"=>"SYS-CHECK", "UID"=>"", "PWD"=>"");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
echo "Connection established connection completed.<br />";
?>