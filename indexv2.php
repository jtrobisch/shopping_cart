<?php

	$host = "localhost";
	$user = "root";
	$password = "";
	$database = "my_shop_db";
	$conn = mysqli_connect($host,$user,$password,$database);
	
	session_start();
	
	if(!empty($_GET["action"])) {
		switch($_GET["action"]) {
			case "add":
				if(!empty($_POST["quantity"])) {
					$result  = mysqli_query($conn,"SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
					$row=mysqli_fetch_assoc($result);
					
					$itemArray = array($row["code"]=>array('name'=>$row["name"], 'code'=>$row["code"], 'quantity'=>$_POST["quantity"], 'price'=>$row["price"], 'image'=>$row["image"]));
					
					if(!empty($_SESSION["cart_item"])) {
						if(in_array($row["code"],array_keys($_SESSION["cart_item"]))) {
							$_SESSION["cart_item"][$row["code"]]["quantity"] += $_POST["quantity"];
						} else {
							$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
						}
					} else {
						$_SESSION["cart_item"] = $itemArray;
					}
				}
				var_dump($_SESSION["cart_item"]);
			break;
		}
	}
	
?>


<html>
<head>
	<title>Joe's Emporium of Shopping Delights </title>
</head>
<body style ="background-color:#CFE0C3;font-family: Arial;color: #211a1a;">
	<h1 style="text-align:center;">Joe's Emporium of Shopping Delights </h1>
	<div style="margin:40px; background-color:white;">
		<h3 style="color: #211a1a;border-bottom: 1px solid black; ">Products</h3>
		<?php
			$result = mysqli_query($conn,"SELECT * FROM tblproduct ORDER BY id ASC");
			if (!empty($result)) { 
				while($row=mysqli_fetch_assoc($result)) {
		?>
			<div style="float:left; background:#ffffff; margin: 30px 30px 30px 0px; border: black 1px solid; padding: 15px 15px 15px 15px;">
				<form method="post" action="index.php?action=add&code=<?php echo $row["code"]; ?>">
					<img src="<?php echo $row["image"]; ?>" width ="250px" height="155px">
					<p style="margin-bottom: 10px;"><strong><?php echo $row["name"]; ?></strong></p>
					<p style="margin-bottom: 10px;"><?php echo "&pound;".$row["price"]; ?></p>
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