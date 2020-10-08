<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "encrypt";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_GET['md5'])) {$md5lookup = $_GET['md5'];}

if (!isset($_GET['md5'])) {
	
	echo("Invalid URL");
	
	die();
	
}

$result = mysqli_query($conn, "SELECT * FROM objects WHERE base64=\"$md5lookup\"");
$resultsnum = mysqli_num_rows($result);

if ($resultsnum == 0) {
	
	echo("No file found");
	die();
	
}

echo "<script type='text/javascript'>
		
		var maindata;
		var filename;
		var extension;
		var security;

		
	</script>";



$fileURL = "storefiles/".$md5lookup;

$file = fopen($fileURL,"r");
$stat = fstat($file);
$fileRead = fread($file,$stat['size']);

while ($row = mysqli_fetch_assoc($result)) {

	echo "<script type='text/javascript'>
	
		maindata = \"". $fileRead  ."\";
		filename = \"". $row['filename']  ."\";
		extension = \"". $row['extension']  ."\";
		security = \"". $row['security'] ."\";
		
	</script>";
							
}

fclose($file);

?>

<html>

<head>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<meta content="width=device-width, initial-scale=1" name="viewport" />

	<link rel="stylesheet" type="text/css" href="getfile.css">
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
	<script src="https://cdn.rawgit.com/CryptoStore/crypto-js/3.1.2/build/rollups/sha256.js"></script>

	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	
	<meta content="utf-8" http-equiv="encoding">

</head>


	<body>
	
		<div id="center">
		
			<div id="center_container">
			
				<div id="center_container_header">
				
					file.file
				
				</div>
		
				<input type="text" id="center_container_input" placeholder="Decryption Password">
				
				<div id="linebreak">
				
				</div>
		
				<button type="submit" id="center_container_button" onclick="okay();">
		
					Download
		
				</button>
			
			</div>
		
		</div>

	</body>
	
	<script>
	
	$('#center_container_header').text(filename+'.'+extension);
	
	
	// Start decrypt function
	let code = (function(){
		return {
			decryptMessage: function(encryptedMessage = '', secretkey = ''){
			var decryptedBytes = CryptoJS.AES.decrypt(encryptedMessage, secretkey);
			var decryptedMessage = decryptedBytes.toString(CryptoJS.enc.Utf8);
			return decryptedMessage;
			}
		}
	})();

	// End decrypt function	

	function okay() {
		
		var encryptionPass = $('#center_container_input').val();
		
		console.log(encryptionPass);
		
		for (i = 0; i <= security; i++) {
	
			encryptionPass = CryptoJS.SHA256(encryptionPass).toString();
	
			console.log(i);
			
			console.log(encryptionPass);
	
		}
	
			console.log("start decrypt");

			decryptedB64 = code.decryptMessage(maindata,encryptionPass);
			filenameExtension = filename.concat(".");
			filenameExtension = filenameExtension.concat(extension);
			download(filenameExtension, decryptedB64);
  
		
			console.log(decryptedB64);
	
	}

	function download(filename, data) {

		var element = document.createElement('a');
		element.setAttribute('href', 'data:text/plain;base64,' + data);
		element.setAttribute('download', filename);
		element.style.display = 'none';
		document.body.appendChild(element);
		element.click();
		document.body.removeChild(element);
  
	}

	window.onerror = function(error) {
		alert("Incorrect Password");
	}

		</script>

</html>