<?php
    // $dbusername = 'phpproj';
    // $dbpassword = 'kHc16289!';
    // $dbhost = 'phpproj.db.10521321.hostedresource.com';
    // $dbdatabase = 'phpproj';
    $dbusername = 'root';
    $dbpassword = '';
    $dbhost = 'localhost';
    $dbdatabase = 'phpclassdb';
    $bd = mysql_connect($dbhost, $dbusername, $dbpassword) 
or die("Opps some thing went wrong");
mysql_select_db($dbdatabase, $bd) or die("Oops some thing went wrong");

function select($table, $params){
    if($params==='')
        $sql="SELECT * FROM " . $table;
    else
	   $sql="SELECT * FROM " . $table . " WHERE " . $params;
    $result=mysql_query($sql);
    return $result;
}
?>