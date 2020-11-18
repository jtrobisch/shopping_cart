<?php
	$host = "localhost";
	$user = "root";
	$password = "";
	$database = "my_shop_db";
	$conn = mysqli_connect($host,$user,$password,$database);
?>
<html>
<head>
	<title>Joe's Emporium of Shopping Delights </title>
	<link rel="stylesheet" href="mystyle.css">
</head>
<body>
	<h1 >Joe's Emporium of Shopping Delights </h1>
	<div class="container">
		<h3>Products</h3>
		<?php
			$result = mysqli_query($conn,"SELECT * FROM tblproduct ORDER BY id ASC");
			if (!empty($result)) 
			{ 
				while($row=mysqli_fetch_assoc($result)) 
				{
		?>
				<div class ="form_container">
					<form method="post" action="index.php?action=add&code=<?php echo $row["code"]; ?>">
						<img src="<?php echo $row["image"]; ?>" width ="250px" height="155px">
						<p><strong><?php echo $row["name"]; ?></strong></p>
						<p><?php echo "&pound;".$row["price"]; ?></p>
						<input type="text" name="quantity" value="1" size="2" />
						<input type="submit" value="Add to Cart" />
					</form>
				</div>
		<?php
				}
			}
		?>
	</div>
</body>
</html>
<?php
	mysqli_close($conn);
?>