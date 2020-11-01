<?php http_response_code(403); ?>
<!DOCTYPE html>
<html>
<head>
<title>403 Forbidden</title>
<link href="https://fonts.googleapis.com/css?family=Nunito:400,700" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="<?=$_Global['URL']?>/static/error/css/style.css" />
</head>
<body>
<div id="notfound">
		<div class="notfound">
			<div class="notfound-404"></div>
			<h1>403</h1>
			<h2>Oops! Forbidden</h2>
			<p>You do not have permission to access this document.</p>
			<a href="<?=$_Global['URL']?>">Back to homepage</a>
		</div>
	</div>
</body>
</html>