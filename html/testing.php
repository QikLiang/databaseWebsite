<?php
//get username and password to database
include '/var/www/inc/dbinfo.inc';

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($conn->connect_error){
	echo '<html><body>';
	echo 'Error: unable to connect to server, please try again.';
	echo '</body></html>';
	return;
}

$query = $conn->query('select * from location');
$data = [];
while($row = $query->fetch_assoc()){
	array_push($data, $row);
}

$conn->close();
?>

<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Testing PHP</title>
</head>
<body>
	<script charset="utf-8">
		var body = document.getElementsByTagName("body")[0];
		var data = JSON.parse('<?=json_encode($data)?>');
		var len = data.length;
		for(var i=0; i<len; i++){
			var pTag = document.createElement("p");
			var text = document.createTextNode(JSON.stringify(data[i]));
			pTag.appendChild(text);
			body.appendChild(pTag);
		}
	</script>
</body>
</html>
