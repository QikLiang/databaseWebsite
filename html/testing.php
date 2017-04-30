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
	<canvas id="graphics" width="2000" height="1000"></canvas>
	<script charset="utf-8">
		var canvas = document.getElementById("graphics").getContext("2d");
		var map = new Image();
		map.onload = function(){
			canvas.drawImage(map, 0, 0, 2000, 1000);
			draw(canvas);
		}
		map.src = "./DBProject_Background.png";

		var body = document.getElementsByTagName("body")[0];
		var data = JSON.parse('<?=json_encode($data)?>');
		var len = data.length;
		for(var i=0; i<len; i++){
			var pTag = document.createElement("p");
			var text = document.createTextNode(JSON.stringify(data[i]));
			pTag.appendChild(text);
			body.appendChild(pTag);
		}

		function draw(canvas){
			var x = 500,
				y=500,
				innerRadius = 30,
				outerRadius = 50;

			var grad = canvas.createRadialGradient(x, y, innerRadius, x, y, outerRadius);
			grad.addColorStop(0, "red");
			grad.addColorStop(1, "transparent");

			canvas.fillStyle = grad;
			canvas.arc(500, 500, 50, 2*Path.PI);
			canvas.fill();

		}
	</script>
</body>
</html>
