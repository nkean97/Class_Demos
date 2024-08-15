<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>AWS Test Web Server Application</title>
	<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default" />

</head>

<body>

	<?php
# Stress the system for a maximum of 10 minutes. Kill all stress processes when requested by the user. 
$stressOrKill = $_GET["stress"];
if (strlen($stressOrKill) > 0) {
				if ($stressOrKill == "start") {
								echo("<h2>Generating load</h2>");
								exec("stress --cpu 4 --io 1 --vm 1 --vm-bytes 128M --timeout 600s > /dev/null 2>/dev/null &");
				} elseif ($stressOrKill == "stop") {
								exec("killall -9 stress");
								echo("<h2>Killed stress processes</h2>");
				} else {

				}
}
?>
	<!-- start content -->
	<div id="content">
		<center>
			<img src="omg.jpg">
			<br />
			<br />
			<h2>Generate Load</h2>
			<h2>
				<?php
                echo $_SERVER['SERVER_ADDR'];
            ?>
			</h2> <br /> <br />
			<table border="0" width="30%" cellpadding="0" cellspacing="0" id="content-table">
				<tr>
					<td>
						<form action="index.php"><input type="hidden" name="stress" value="start" /><input type="submit"
								value="Start Stress" /></form>
					</td>
					<td>
						<form action="index.php"><input type="hidden" name="stress" value="stop" /><input type="submit"
								value="Stop Stress" /></form>
					</td>
				</tr>
			</table>
		</center> <!-- end content -->
	</div>

</body>

<!-- PHP code to establish connection with the localserver -->
<?php
 
// Username is root
$user = 'root';
$password = '';
 
// Database name is geeksforgeeks
$database = 'geeksforgeeks';
 
// Server is localhost with
// port number 3306
$servername='localhost:3306';
$mysqli = new mysqli($servername, $user,
                $password, $database);
 
// Checking for connections
if ($mysqli->connect_error) {
    die('Connect Error (' .
    $mysqli->connect_errno . ') '.
    $mysqli->connect_error);
}
 
// SQL query to select data from database
$sql = " SELECT * FROM userdata ORDER BY score DESC ";
$result = $mysqli->query($sql);
$mysqli->close();
?>
<!-- HTML code to display data in tabular format -->
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>GFG User Details</title>
	<!-- CSS FOR STYLING THE PAGE -->
	<style>
		table {
			margin: 0 auto;
			font-size: large;
			border: 1px solid black;
		}

		h1 {
			text-align: center;
			color: #006600;
			font-size: xx-large;
			font-family: 'Gill Sans', 'Gill Sans MT',
				' Calibri', 'Trebuchet MS', 'sans-serif';
		}

		td {
			background-color: #E4F5D4;
			border: 1px solid black;
		}

		th,
		td {
			font-weight: bold;
			border: 1px solid black;
			padding: 10px;
			text-align: center;
		}

		td {
			font-weight: lighter;
		}
	</style>
</head>

<body>
	<section>
		<h1>GeeksForGeeks</h1>
		<!-- TABLE CONSTRUCTION -->
		<table>
			<tr>
				<th>GFG UserHandle</th>
				<th>Practice Problems</th>
				<th>Coding Score</th>
				<th>GFG Articles</th>
			</tr>
			<!-- PHP CODE TO FETCH DATA FROM ROWS -->
			<?php 
                // LOOP TILL END OF DATA
                while($rows=$result->fetch_assoc())
                {
            ?>
			<tr>
				<!-- FETCHING DATA FROM EACH
                    ROW OF EVERY COLUMN -->
				<td>
					<?php echo $rows['username'];?>
				</td>
				<td>
					<?php echo $rows['problems'];?>
				</td>
				<td>
					<?php echo $rows['score'];?>
				</td>
				<td>
					<?php echo $rows['articles'];?>
				</td>
			</tr>
			<?php
                }
            ?>
		</table>
	</section>
</body>

</html>
