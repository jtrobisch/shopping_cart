<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "my_shop_db";

	$conn = mysqli_connect($servername, $username, $password, $dbname);

	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
	$name = mysqli_real_escape_string($conn,$_POST['name']);
	$code = mysqli_real_escape_string($conn,$_POST['code']); 
	$price = mysqli_real_escape_string($conn,$_POST['price']);

	//handle image
	$target_dir = "product-images/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			$uploadOk = 1;
		} else {
			$uploadOk = 0;
		}
	}
	// Check if file already exists
	if (file_exists($target_file)) {
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000000) {
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 1) {
		move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
		$sql = "INSERT INTO tblproduct  VALUES (NULL, '$name', '$code', 'product-images/".$_FILES["fileToUpload"]["name"]."','$price')";
		mysqli_query($conn, $sql);
	}

	mysqli_close($conn);
	header( "Location: welcome.php" );
	exit ;
?>

