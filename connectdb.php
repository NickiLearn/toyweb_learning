<?php
//echo "Connected with database";
//$sql_conn=mysqli_connect("localhost","root","","test1"); // host, username, password, databasename
$sql_conn=mysqli_connect("localhost","id11754644_tester","123456","id11754644_newtest"); // host, username, password, databasename

if (mysqli_error($sql_conn)){
    echo mysqli_error($sql_conn);
    exit; //will stop run the rest code, means stop the software continue
}

session_start();
?>