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
			case "remove":
				if(!empty($_SESSION["cart_item"])) {
					unset($_SESSION["cart_item"][$_GET["code"]]);
				}
				var_dump($_SESSION["cart_item"]);
			break;
			case "empty":
				unset($_SESSION["cart_item"]);
			break;	
		}
	}
?>
<html>
<head>
	<title>Joe's Emporium of Shopping Delights </title>
	<link rel="stylesheet" href="mystyle.css">
</head>
<body>
	<h1 >Joe's Emporium of Shopping Delights </h1>
	<!--New Content-->
	<div class="basket">
		<h3>Shopping Cart</h3>
		<a href="index.php?action=empty">Empty Cart</a>
		
		<table cellpadding="10" cellspacing="1">
			<tbody>
			<tr>
				<th class="left">Name</th>
				<th class="left">Code</th>
				<th class="right" width="5%">Quantity</th>
				<th class="right" width="10%">Unit Price</th>
				<th class="right" width="10%">Price</th>
				<th class="centre" width="5%">Remove</th>
			</tr>	

			<tr>
				<td><img class="bkimg" src="product-images/external-hard-drive.jpg" alt="product image"/>EXP Portable Hard Drive</td>
				<td>USB02</td>
				<td class="right">3</td>
				<td class="right">&pound;800</td>
				<td class="right">&pound;2400</td>
				<td class="centre"><a href="index.php?action=remove&code=USB02" class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a></td>
			</tr>
			<tr>
				<td colspan="2" class="right">Total:</td>
				<td class="right">3</td>
				<td class="right" colspan="2"><strong>&pound;2400</strong></td>
				<td></td>
			</tr>
			</tbody>
		</table>		
	</div>
	<!--End Of New Content-->
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