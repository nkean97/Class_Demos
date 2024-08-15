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

</html>
