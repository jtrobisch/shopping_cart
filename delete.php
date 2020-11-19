<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_shop_db";


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "DELETE FROM tblproduct WHERE code = '" . $_GET['del_code']."'";
mysqli_query($conn, $sql);
mysqli_close($conn);
var_dump($sql);
header( "Location: welcome.php" );
exit ;

?>