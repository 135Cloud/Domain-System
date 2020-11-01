<?php http_response_code(404); ?>
<!DOCTYPE html>
<html>
<head>
<title>404 Not Found</title>
<link href="https://fonts.googleapis.com/css?family=Nunito:400,700" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="<?=$_Global['URL']?>/static/error/css/style.css" />
</head>
<body>
<div id="notfound">
		<div class="notfound">
			<div class="notfound-404"></div>
			<h1>404</h1>
			<h2>Oops! Page Not Be Found</h2>
			<p>Sorry but the page you are looking for does not exist, have been removed. name changed or is temporarily unavailable</p>
			<a href="<?=$_Global['URL']?>">Back to homepage</a>
		</div>
	</div>
</body>
</html>