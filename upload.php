<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "encrypt";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$base64 = $_POST['base64'];

$base64md5 = md5($base64);

$base64md5 = "storefiles/".$base64md5;

$base64md5_2 = "'".md5($base64)."'";

$filename = "'".$_POST['filename']."'";

$fileex = "'".$_POST['fileex']."'";

$security = $_POST['security'];

$sql = "INSERT INTO objects (base64, filename, extension, security) VALUES ($base64md5_2, $filename, $fileex, $security)";

mysqli_query($conn, $sql);

$myfile = fopen($base64md5, "w") or die("Unable to open file!");
fwrite($myfile, $base64);
fclose($myfile);




?>

<html>

<head>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<meta content="width=device-width, initial-scale=1" name="viewport" />

	<link rel="stylesheet" type="text/css" href="index.css">
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>

	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	
	<meta content="utf-8" http-equiv="encoding">

</head>


	<body>


	</body>
	
	<script>

		</script>

</html>