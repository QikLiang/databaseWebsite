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

function sanitize($text){
	$text = trim($text);
	$text = stripslashes($text);
	$text = htmlspecialchars($text);
	return $text;
}

$from = sanitize($_GET["from"]);
$to = sanitize($_GET["to"]);
if ( !preg_match('/\d{4}/',$from) || !preg_match('/\d{4}/',$to) ){
	$from = 0;
	$to = 2400;
}

$sql = <<<END
select *, (down + up)/2 as mean from(
	select l.building, xCoord, yCoord, avg(upload) as up,
		avg(download) as down, avg(ping) as ping, (down + up)/2 as mean
	from location l left join performance p
	on l.building = p.building
	where hour(time)*100 + minute(time) <= $to
		and hour(time)*100 + minute(time) >= $from
	group by l.building
)a
order by mean desc;
END;

$query = $conn->query("select * from location;");
//$query = $conn->query($sql);
echo $sql;
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

	<form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

	Select start time:
	<select name="from">
		<option value = "0000">0000</option>
		<option value = "0030">0030</option>
		<option value = "0100">0100</option>
		<option value = "0130">0130</option>
		<option value = "0200">0200</option>
		<option value = "0230">0230</option>
		<option value = "0300">0300</option>
		<option value = "0330">0330</option>
		<option value = "0400">0400</option>
		<option value = "0430">0430</option>
		<option value = "0500">0500</option>
		<option value = "0530">0530</option>
		<option value = "0600">0600</option>
		<option value = "0630">0630</option>
		<option value = "0700">0700</option>
		<option value = "0730">0730</option>
		<option value = "0800">0800</option>
		<option value = "0830">0830</option>
		<option value = "0900">0900</option>
		<option value = "0930">0930</option>
		<option value = "1000">1000</option>
		<option value = "1030">1030</option>
		<option value = "1100">1100</option>
		<option value = "1130">1130</option>
		<option value = "1200">1200</option>
		<option value = "1230">1230</option>
		<option value = "1300">1300</option>
		<option value = "1330">1330</option>
		<option value = "1400">1400</option>
		<option value = "1430">1430</option>
		<option value = "1500">1500</option>
		<option value = "1530">1530</option>
		<option value = "1600">1600</option>
		<option value = "1630">1630</option>
		<option value = "1700">1700</option>
		<option value = "1730">1730</option>
		<option value = "1800">1800</option>
		<option value = "1830">1830</option>
		<option value = "1900">1900</option>
		<option value = "1930">1930</option>
		<option value = "2000">2000</option>
		<option value = "2030">2030</option>
		<option value = "2100">2100</option>
		<option value = "2130">2130</option>
		<option value = "2200">2200</option>
		<option value = "2230">2230</option>
		<option value = "2300">2300</option>
		<option value = "2330">2330</option>

		</select>

		select end time

		<select name="to">
		<option value = "0000">0000</option>
		<option value = "0030">0030</option>
		<option value = "0100">0100</option>
		<option value = "0130">0130</option>
		<option value = "0200">0200</option>
		<option value = "0230">0230</option>
		<option value = "0300">0300</option>
		<option value = "0330">0330</option>
		<option value = "0400">0400</option>
		<option value = "0430">0430</option>
		<option value = "0500">0500</option>
		<option value = "0530">0530</option>
		<option value = "0600">0600</option>
		<option value = "0630">0630</option>
		<option value = "0700">0700</option>
		<option value = "0730">0730</option>
		<option value = "0800">0800</option>
		<option value = "0830">0830</option>
		<option value = "0900">0900</option>
		<option value = "0930">0930</option>
		<option value = "1000">1000</option>
		<option value = "1030">1030</option>
		<option value = "1100">1100</option>
		<option value = "1130">1130</option>
		<option value = "1200">1200</option>
		<option value = "1230">1230</option>
		<option value = "1300">1300</option>
		<option value = "1330">1330</option>
		<option value = "1400">1400</option>
		<option value = "1430">1430</option>
		<option value = "1500">1500</option>
		<option value = "1530">1530</option>
		<option value = "1600">1600</option>
		<option value = "1630">1630</option>
		<option value = "1700">1700</option>
		<option value = "1730">1730</option>
		<option value = "1800">1800</option>
		<option value = "1830">1830</option>
		<option value = "1900">1900</option>
		<option value = "1930">1930</option>
		<option value = "2000">2000</option>
		<option value = "2030">2030</option>
		<option value = "2100">2100</option>
		<option value = "2130">2130</option>
		<option value = "2200">2200</option>
		<option value = "2230">2230</option>
		<option value = "2300">2300</option>
		<option value = "2330">2330</option>

		</select>







	<input type="submit" name="submit" value="Submit">
	</form>

	<script charset="utf-8">
		var canvas = document.getElementById("graphics").getContext("2d");
		var map = new Image();
		map.onload = function(){
			canvas.drawImage(map, 0, 0, 2000, 1000);
			draw(canvas);
		}
		map.src = "./DBProject_Background.png";

		function draw(canvas){
			var data = JSON.parse('<?=json_encode($data)?>');
			var len = data.length;

			var maxDown = 0;
			for(var i=0; i<len; i++){
			    if (data[i]["down"] > maxDown){
			        maxDown = data[i]["down"];
			    }
			}

			for(var i=0; i<len; i++){
				drawCircle(canvas, data[i]["xCoord"], data[i]["yCoord"], 20, data[i]["down"], maxDown);
			}
		}

		function drawCircle(canvas, x, y, radius, currDown, maxDown){
			var grad = canvas.createRadialGradient(x, y, 0, x, y, radius);

            var ratio = currDown / maxDown;

            var red = 255 * (1 - ratio);
            var green = 255 * ratio;

			grad.addColorStop(0, rgbToHex(parseInt(red), parseInt(green), 0));
			grad.addColorStop(1, "transparent");

			canvas.fillStyle = grad;
			canvas.fillRect(x - radius, y - radius, x + radius, y + radius);
		}

		function componentToHex(c) {
            var hex = c.toString(16);
            return hex.length == 1 ? "0" + hex : hex;
        }

        function rgbToHex(r, g, b) {
            return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
        }
	</script>


</body>
</html>
