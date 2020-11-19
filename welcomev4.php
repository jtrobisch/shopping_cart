<?php
   session_start();
   if(!isset($_SESSION['login_user'])){
		header("location:index.php");
		exit;
   }
   
	$host = "localhost";
	$user = "root";
	$password = "";
	$database = "my_shop_db";
	$conn = mysqli_connect($host,$user,$password,$database);

	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
?>
<html>
<head>
	<title>Welcome </title>
	<link rel="stylesheet" href="mystyle.css">
</head>
<body>
	<p class="signout"><a href = "logout.php">Sign Out</a></p>
	<?php
		$sql = "SELECT * FROM user_tbl WHERE username = '" .$_SESSION['login_user'] ."';";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		$user_id = $row["user_id"];
		echo '<h1>Welcome  ' . $row["fname"] . ' ' .  $row["lname"] . '</h1>';
	?>
	<?php 
	if($row["admin_acc"]==False)
	{
	?>
	<?php
		$sql = "SELECT * FROM order_tbl INNER JOIN user_tbl ON user_id_fk = user_id INNER JOIN tblproduct ON product_id_fk = id WHERE user_id_fk = $user_id ;";
		$result = mysqli_query($conn, $sql);
	?>
	<div id="welcome_container">
		<table cellpadding="10" cellspacing="1" width="100%">
			<tbody>
			<tr>
				<th class="left">Order ID</th>
				<th class="left">Name</th>
				<th class="left">Code</th>
				<th class="right" width="10%">Price</th>
				<th class="right" width="10%">Date</th>
				<th class="centre" width="10%">Time</th>
			</tr>	
		<?php
			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
		?>
				<tr>
					<td><?php echo $row["order_id"]; ?></td>
					<td><img src="<?php echo $row["image"]; ?>" /><?php echo $row["name"]; ?></td>
					<td><?php echo $row["code"]; ?></td>
					<td class="right">&pound;<?php echo $row["price"]; ?></td>
					<td class="right"><?php echo $row["ord_date"]; ?></td>
					<td class="centre"><?php echo $row["ord_time"]; ?></td>
				</tr>
			<?php
				}
			} else {
				echo "<p>0 products found.</p>";
			}
		?>
		</table> 
    </div>
	<?php
	}else{
	?>
	<?php
		$sql = "SELECT * FROM tblproduct";
		$result = mysqli_query($conn, $sql);
	?>
	<div id="welcome_container">
	<table cellpadding="10" cellspacing="1" width="100%">
		<tbody>
		<tr>
			<th class="left">Product ID</th>
			<th class="left">Name</th>
			<th class="left">Code</th>
			<th class="right" width="10%">Price</th>
			<th class="right" width="15%">Delete Item</th>
		</tr>	
	<?php
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
	?>
			<tr>
				<td><?php echo $row["id"]; ?></td>
				<td><img src="<?php echo $row["image"]; ?>" /><?php echo $row["name"]; ?></td>
				<td><?php echo $row["code"]; ?></td>
				<td class="right">&pound;<?php echo $row["price"]; ?></td>
				<td class="right"><a href="delete.php?del_code=<?php echo $row["code"]; ?>">DELETE</a></td>
			</tr>
		<?php
			}
		} else {
			echo "<p>0 products found.</p>";
		}
	?>
	</table> 
    </div>
	<!--New Code-->
	<div id="insert_form">
		<form action="insert.php" method="post" enctype="multipart/form-data">
			<p><label>Name:</label><input type = "text" name = "name" /></p>
			<p><label>Code:</label><input type = "text" name = "code" /></p>
		    <p><label>Price:</label><input type = "text" name = "price" /></p>
			<p>Select Product Image:<input type="file" name="fileToUpload" id="fileToUpload"></p>
			<p><input type="submit" value="Upload Product" name="submit"></p>
		</form>
	</div>
	<!--End Of New Code-->
	<?php
	}
	?>
   </body>
</html>
<?php
	mysqli_close($conn);
?>