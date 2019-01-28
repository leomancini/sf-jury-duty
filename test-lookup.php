<!DOCTYPE HTML>
<html>

	<head>
		<title>Lookup Page</title>
		<link rel="stylesheet/less" href="resources/css/style.less">
		<script src="resources/js/lib/less.js"></script>
		<script src="resources/js/lib/jquery.js"></script>
		<script src="resources/js/main.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>

		<form>
			<!--
			<label>Location:</label>
			<select name="location">
				<option value="civic_center">Civic Center (400 McAllister St)</option>
				<option value="hall_of_justice">Hall of Justice (850 Bryant St)</option>
			</select>
			<br>
			-->
			<label>Group Number:</label> <input type="text" name="group-number" autocomplete="off" value="<?php echo $_GET["group-number"]; ?>">
		</form>

		<pre>
			<div id="response"><div class="loading">Loading...</div><div class="message"></div></div>
		</pre>
	</body>
</html>