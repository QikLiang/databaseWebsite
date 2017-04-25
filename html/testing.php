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
	array_push($data, row);
}

$conn->close();
?>

<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Testing PHP</title>
</head>
<body>
	<h1>
		<?=json_encode($data)?>
	</h1>
	//<script charset="utf-8">
		//var data = JSON.parse(<?=json_encode($data)?>);
	//</script>
</body>
</html>
