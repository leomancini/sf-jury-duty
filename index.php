<!DOCTYPE HTML>
<html>

	<head>
		<title>🏛 Jury Duty – Status Checker</title>
		<link rel="stylesheet/less" href="resources/css/style.less">
		<script src="resources/js/lib/less.js"></script>
		<script src="resources/js/lib/jquery.js"></script>
		<script src="resources/js/main.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>

		<div id="container">
			<div id="main" class="card">
				<h1>🏛</h1> 
				<div id="digits">
					<input class="digit" data-digit-index="1" type="text" maxlength="1" value="<?php echo $_GET["group-number"][0]; ?>" <?php if($_GET["group-number"][0] == "") { echo "autofocus"; } ?>>
					<input class="digit" data-digit-index="2" type="text" maxlength="1" value="<?php echo $_GET["group-number"][1]; ?>" <?php if($_GET["group-number"][1] == "") { echo "autofocus"; } ?>>
					<input class="digit" data-digit-index="3" type="text" maxlength="1" value="<?php echo $_GET["group-number"][2]; ?>" <?php if($_GET["group-number"][2] == "") { echo "autofocus"; } ?>>
				</div>
				<div id="response"><div class="loading">Loading...</div><div class="message"></div></div>
			</div>
		</div>
		
	</body>
</html>