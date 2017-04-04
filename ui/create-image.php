<?php
$url = "localhost";
$user = "root";
$pass = "root";
$db = "images";
 
$id = $_GET['id'];
 
$link = mysql_connect( $url, $user, $pass ) or die("MySQLへの接続に失敗しました。");
$sdb = mysql_select_db( $db, $link ) or die("データベースの選択に失敗しました。");
$sql = "SELECT * FROM images.posts WHERE ID = '".$id."'";
$result = mysql_query( $sql, $link ) or die("クエリの送信に失敗しました。");
$rows = mysql_num_rows( $result );
mysql_close( $link ) or die("MySQL切断に失敗しました。");
 
if( $rows ){
    while($row = mysql_fetch_array($result)) {
        header( "Content-Type: ".$row['mime'] );
        echo $row['imgdat'];
    }
}

?>